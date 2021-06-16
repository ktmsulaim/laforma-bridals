<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Web admin',
            'username' => 'webadmin',
            'email' => 'webadmin@laformabridal.com',
            'password' => 'webadmin@lf.com',
            'email_verified_at' => Carbon::now()
        ]);
    }
}
