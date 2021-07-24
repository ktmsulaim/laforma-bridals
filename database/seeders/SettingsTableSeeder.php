<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::setMany([
            "store_name" => "La'forma Bridals",
            "store_location" => 'Malappuram',
            "primary_contact_number" => '+91 9846 374 743',
            "secondary_contact_number" => '+91 9645 374 743',
            "email" => 'laformabridals@gmail.com',
            "address" => "Ring Road Tirur, Japan square building \n
            1st floor Kotak Mahindra Bank Tirur \n
            676101",
            "enable_cash_on_delivery" => 'enable',
            "enable_razorpay" => 'disable',
            "razorpay_key" => '',
            "razorpay_secret" => '',
            "opening_hour" => '8:00 AM',
            "closing_hour" => '8:00 PM',
            "working_hours" => 12,
            "holidays" => ""
        ]);
    }
}
