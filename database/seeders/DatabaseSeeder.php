<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Database\Factories\ProductFactory;
use Database\Seeders\SizeColorSeeder;
use App\Models\Product;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // $this->call(SizeColorSeeder::class);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Product::factory(10)->create();
       

        // DB::table('users')->insert([
        //     'id' => 1,
        //     'name' => 'Admin',
        //     'email' => 'admin@admin.com',
        //     'password' => Hash::make('12345678'),
        //     'no_telepon' => '08312345678',
        //     'address' => 'jl. apel',
        //     'image' => 'avatar.png',
        //     'is_admin' => true
        // ]);
    }
}
