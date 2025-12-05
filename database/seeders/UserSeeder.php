<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin One',
                'email' => 'admin1@example.com',
                'phone' => '1234567890',
                'password' => 'password1',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Admin Two',
                'email' => 'admin2@example.com',
                'password' => 'password2',
                'phone' => '1234567890',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Manish Kumar',
                'email' => 'manishkumar@ibarts.in',
                'password' => 'manishkumar@ibarts.in',
                'phone' => '1234567890',
                'email_verified_at' => now(),
            ],
        ];
        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'password' => Hash::make($data['password']),
                    'email_verified_at' => now(),
                ]
            );
            $user->assignRole('bank_admin', 'super_admin', 'mediator', 'defaulter', 'arbitrator');
            if ($user->wasRecentlyCreated) {
                $this->command->info('User created successfully!');
            } else {
                $this->command->info('User updated successfully!');
            }
        }
    }
}
