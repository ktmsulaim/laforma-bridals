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
        // Setting::setMany([
        //     "store_name" => "La'forma Bridals",
        //     "store_location" => 'Malappuram',
        //     "primary_contact_number" => '+91 9846 374 743',
        //     "secondary_contact_number" => '+91 9645 374 743',
        //     "email" => 'laformabridals@gmail.com',
        //     "address" => "Ring Road Tirur, Japan square building \n
        //     1st floor Kotak Mahindra Bank Tirur \n
        //     676101",
        //     "enable_cash_on_delivery" => 'enable',
        //     "enable_razorpay" => 'disable',
        //     "razorpay_key" => '',
        //     "razorpay_secret" => '',
        //     "opening_hour" => '8:00 AM',
        //     "closing_hour" => '8:00 PM',
        //     "working_hours" => 12,
        //     "holidays" => ""
        // ]);

        Setting::setMany([
            'store_name' => 'La\'forma Bridals',
            'store_location' => 'Malappuram',
            'primary_contact_number' => '+91 9846 374 743',
            'secondary_contact_number' => '+91 9645 374 743',
            'email' => 'laformabridals@gmail.com',
            'address' => 'Ring Road Tirur, Japan square building \n 1st floor Kotak Mahindra Bank Tirur \n 676101',
            'enable_cash_on_delivery' => 'enable',
            'enable_razorpay' => 'enable',
            'razorpay_key' => 'rzp_test_wYMUaWsQpvQKhL',
            'razorpay_secret' => 'OooDbXYoFzZsCuQWmL7wjfcb',
            'opening_hour' => '8:00 AM',
            'closing_hour' => '8:00 PM',
            'working_hours' => '12',
            'holidays' => '',
            'email_notification' => 'enable',
            'welcome_mail' => 'enable',
            'order_summary_mail' => 'enable',
            'order_status_mail' => 'enable',
            'booking_confirmation_mail' => 'enable',
            'booking_status_mail' => 'enable',
            'booking_progress_mail' => 'enable',
            'about_page' => 'about-us',
            'privacy_policy_page' => 'privacy-policy',
            'terms_of_use_page' => 'terms-of-use',
            'refund_policy_page' => 'refund-policy',
            'twitter_link' => '',
            'facebook_link' => '',
            'instagram_link' => '',
            'youtube_link' => '',
        ]);
    }
}
