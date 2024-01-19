<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $times = 100;

    // İstenen sayıda seyiciyi çalıştırın
    for ($i = 0; $i < $times; $i++) {
        $this->call(UserSeeder::class);
    }

        
        /*
        $this->call([
            CompanySeeder::class,
            ContactSeeder::class,
            UserSeeder::class
        ]);*/

    }
}
