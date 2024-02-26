<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $owner = Role::create(['name' => 'owner']);
        $admin = Role::create(['name' => 'admin']);

        $user = User::factory()->create([
            'name' => 'owner',
            'email' => 'owner@inventory.com',
            'password' => Hash::make('12345678')
        ]);
        $user->assignRole($owner);


        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@inventory.com',
            'password' => Hash::make('12345678')
        ]);
        $user->assignRole($admin);


        $faker = Faker::create('id_ID');

        for($i = 1; $i <= 10; $i++){

            // insert data ke table pegawai menggunakan Faker
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make('12345678'),
            ]);

        }
    }
}
