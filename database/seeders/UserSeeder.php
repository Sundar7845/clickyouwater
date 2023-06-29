<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'user_name'     => 'Super Admin',
                'email'         => 'superadmin@gmail.com',
                'password'      => Hash::make('123456789'),
                'role_id'       => 1,
                'display_name'  => 'Super Admin',
                'mobile'        => '9876543210',
                'is_active'     => 1,
                'OTP'           => '015976'
            ]
        ];

        User::insert($data);
    }
}
