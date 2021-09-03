<template>
    <div>
        <div class="form-group">
            <label for="report_type">Report</label>
            <select
                name="report_type"
                id="report_type"
                class="form-control"
                v-model="report_type"
            >
                <option value="products_stock">Products stock</option>
                <option value="top_selling_products"
                    >Top selling products</option
                >
                <option value="top_wishlisted_products"
                    >Top wishlisted products</option
                >
                <option value="sales_report">Sales report</option>
                <option value="bookings_report">Bookings report</option>
            </select>
        </div>
        <div class="form-group" v-if="isForDateRange">
            <label for="date_range">Date range</label>
            <date-picker
                placeholder="Select date range"
                value-type="format"
                :range="true"
                format="DD-MM-YYYY"
                :disabled-date="disabledDate"
                v-model="date_range"
                required
            ></date-picker>
            <input
                type="hidden"
                name="date_range"
                :value="date_range"
                v-if="date_range"
            />
        </div>
        <div class="form-group" v-if="isForStatus">
            <label for="status-options">Status</label>
            <select class="form-control" v-model="status" name="status">
                <option
                    v-for="(option, index) in statusOptions"
                    :key="index"
                    :value="option.value"
                >
                    {{ option.text }}
                </option>
            </select>
        </div>
        <div class="form-group" v-if="isForLimit">
            <label for="limit">Limit</label>
            <input
                type="number"
                min="0"
                class="form-control"
                name="limit"
                v-model="limit"
            />
        </div>
        <div class="mt-2">
            <button class="btn btn-primary">Submit</button>
        </div>
    </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";

export default {
    name: "FiltersControl",
    components: {
        DatePicker
    },
    data() {
        return {
            report_type: "top_selling_products",
            date_range: [],
            limit: 20,
            disabledDate: date => {
                return date > moment();
            },
            status: "completed"
        };
    },
    computed: {
        isForDateRange() {
            const enabledTypes = ["sales_report", "bookings_report"];

            return enabledTypes.includes(this.report_type);
        },
        isForStatus() {
            const enabledTypes = ["sales_report", "bookings_report"];

            return enabledTypes.includes(this.report_type);
        },
        isForLimit() {
            const enabledTypes = [
                "top_selling_products",
                "top_wishlisted_products",
                "products_stock"
            ];

            return enabledTypes.includes(this.report_type);
        },
        statusOptions() {
            let options = [
                {
                    text: "Pending",
                    value: "pending"
                },
                {
                    text: "On hold",
                    value: "on_hold"
                },
                {
                    text: "Processing",
                    value: "processing"
                },
                {
                    text: "Completed",
                    value: "completed"
                },
                {
                    text: "Cancelled",
                    value: "cancelled"
                }
            ];

            if (this.report_type === "sales_report") {
                options.push(
                    { text: "Payment Pending", value: "payment_pending" },
                    { text: "Confirmed", value: "confirmed" },
                    { text: "Processing", value: "processing" },
                    { text: "Refunded", value: "refunded" }
                );
            } else if (this.report_type === "bookings_report") {
                options.push(
                    {
                        text: "Booking Charge Pending",
                        value: "booking_charge_pending"
                    },
                    { text: "Booked", value: "full_amount_pending" }
                );
            }

            return options;
        }
    },
    created() {
        const params = new URLSearchParams(window.location.search);

        if (params.has("report_type")) {
            this.report_type = params.get("report_type");
        }

        if (params.has("date_range")) {
            const date_range = params.get("date_range");

            if (typeof date_range == "string") {
                this.date_range = date_range.split(",");
            } else {
                this.date_range = date_range;
            }
        }

        if (params.has("limit")) {
            this.limit = params.get("limit");
        }

        if (params.has("status")) {
            this.status = params.get("status");
        }
    }
};
</script>

<style></style>
