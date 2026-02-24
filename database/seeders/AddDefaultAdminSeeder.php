<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddDefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminData = [
            'name'                 => "Admin",
            'phone_code'           => "91",
            'phone'                => "1234567890",
            'email'                => "admin@admin.com",
            'password'             => md5("admin@admin.com12345678"),
            'is_head'              => 1,
            'status'               => 1,
            'created_by'           => 1,
            'updated_by'           => 1,
            'created_at'           => Carbon::now(),
            'updated_at'           => Carbon::now(),
        ];

        DB::table('admins')->insert($adminData);

        $userData = [
            'id'                  => 1,
            'name'                 => "User",
            'email'                => "user@user.com",
            'password'             => md5("user@user.com12345678"),
            'created_at'           => Carbon::now(),
            'updated_at'           => Carbon::now(),
        ];

        DB::table('users')->insert($userData);
    }
}
