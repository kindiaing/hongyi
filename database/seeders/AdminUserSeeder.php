<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => '系统管理员',
            'email' => 'seeding@ihopeso.cn',
            'phone' => null,
            'password' => 'password',
            'avatar' => null,
            'vendor_id' => null,
            'department' => '系统管理部',
            'status' => 1,
            'last_login_at' => null,
            'email_verified_at' => now(),
        ]);

        $user->assignRole('super_admin');
    }
}
