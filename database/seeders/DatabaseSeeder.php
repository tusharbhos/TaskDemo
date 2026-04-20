<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\DealerProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Seed Roles ────────────────────────────────────────────────────────
        $employee = Role::create(['name' => 'employee', 'label' => 'Employee']);
        $dealer   = Role::create(['name' => 'dealer',   'label' => 'Dealer']);

        // ── Demo Employee ─────────────────────────────────────────────────────
        User::create([
            'first_name' => 'Alice',
            'last_name'  => 'Smith',
            'email'      => 'employee@demo.com',
            'password'   => Hash::make('Password@1'),
            'role_id'    => $employee->id,
        ]);

        // ── Demo Dealer ───────────────────────────────────────────────────────
        $dealerUser = User::create([
            'first_name' => 'Bob',
            'last_name'  => 'Johnson',
            'email'      => 'dealer@demo.com',
            'password'   => Hash::make('Password@1'),
            'role_id'    => $dealer->id,
        ]);

        DealerProfile::create([
            'user_id'      => $dealerUser->id,
            'company_name' => 'Johnson Auto Group',
            'phone'        => '+1 555 0199',
            'city'         => 'Los Angeles',
            'state'        => 'California',
            'zip'          => '90001',
        ]);
    }
}
