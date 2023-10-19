<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultData =
            [
                ['id' => 1, 'name' => "Autogong", 'email' => 'vatanoto', "password" => "513545", "created_at" => now(), "updated_at" => now()],
                ['id' => 2, 'name' => "Otopert", 'email' => 'karaca353535@hotmail.com', "password" => "1100", "created_at" => now(), "updated_at" => now()],
                ['id' => 3, 'name' => "PertBorsasi", 'email' => 'vatanotomotiv', "password" => "1536", "created_at" => now(), "updated_at" => now()],
            ];

        Company::query()->insert($defaultData);
    }
}
