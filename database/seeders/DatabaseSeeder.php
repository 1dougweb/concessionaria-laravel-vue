<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@concessionaria.local'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin#123'),
                'email_verified_at' => now(),
            ],
        );

        $this->call([
            CustomerSeeder::class,
            VehicleSeeder::class,
            ProposalSeeder::class,
            SaleSeeder::class,
        ]);

        $this->command?->info(sprintf(
            'Admin: %s / %s',
            $admin->email,
            'Admin#123'
        ));
    }
}
