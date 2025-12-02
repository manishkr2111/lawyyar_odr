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
                'password' => 'password1',
            ],
            [
                'name' => 'Admin Two',
                'email' => 'admin2@example.com',
                'password' => 'password2',
            ],
            [
                'name' => 'Manish Kumar',
                'email' => 'manishkumar@ibarts.in',
                'password' => 'manishkumar@ibarts.in',
            ],
        ];
        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'email_verified_at' => now(),
                ]
            );
            if ($user->wasRecentlyCreated) {
                $this->command->info('User created successfully!');
            } else {
                $this->command->info('User updated successfully!');
            }
        }
    }
}
