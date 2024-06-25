<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("admin")->delete();

        $defaultData =
            [
                'id' => 1,
                'name' => "Mustafa Karaca",
                'email' => 'admin@admin.com',
                "password" => "$2y$10$2SKzngoMiR2zThWcDGLTXe1ACtykXUuwdb94Cx5s5AiB1v6nlJOEC",
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
            ];

        Admin::query()->insert($defaultData);
    }
}
