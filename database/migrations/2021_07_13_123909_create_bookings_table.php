<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('package_id');
            $table->date('date');
            $table->string('time');
            $table->string('progress')->default("not_started"); // Not started | In progress | Finished 
            $table->string('status'); // Pending | Booking Charge Pending | Full amount pending | Cancelled | On hold | Completed
            $table->timestamps();

            $table->tinyInteger('cancelled')->default(0);
            $table->string('cancelled_by')->nullable();
            $table->unsignedBigInteger('cancelled_by_id')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
