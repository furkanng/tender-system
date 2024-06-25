<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("companies")->delete();

        $defaultData =
            [
                ['id' => 1, 'name' => "Autogong", 'email' => 'vatanoto', "password" => "513545", "created_at" => now(), "updated_at" => now()],
                ['id' => 2, 'name' => "Otopert", 'email' => 'karaca353535@hotmail.com', "password" => "1100", "created_at" => now(), "updated_at" => now()],
                ['id' => 3, 'name' => "Sovtajyeri", 'email' => 'SVT60383', "password" => "3tEwYGWİ", "created_at" => now(), "updated_at" => now()],
                ['id' => 99, 'name' => "Oto İhale Sistemi", 'email' => null, "password" => null, "created_at" => now(), "updated_at" => now()],
            ];

        Company::query()->insert($defaultData);
    }
}
