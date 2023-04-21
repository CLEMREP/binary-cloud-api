<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Company;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $address = Address::factory()->create([
            'address' => '63 Boulevard du Tertre',
            'city' => 'Nantes',
            'zip' => '44100',
            'state' => 'France',
        ]);

        $company = Company::factory()->create([
            'name' => 'Binary-Cloud',
            'email' => 'contact@clement-repel.fr',
            'phone' => '07 61 38 20 28',
            'siret' => '90468726600018',
            'address_id' => $address->getKey(),
        ]);

        $user = User::factory()->create([
            'firstname' => 'Clément',
            'lastname' => 'REPEL',
            'email' => 'contact@clement-repel.fr',
            'phone' => '07 61 38 20 25',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'admin' => true,
            'company_id' => $company->getKey(),
            'address_id' => $address->getKey(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Client::factory()->count(10)->create([
            'user_id' => $user->getKey(),
        ]);

        $secondUser = User::factory()->create();
        Client::factory()->count(10)->create([
            'user_id' => $secondUser->getKey(),
        ]);
    }
}
