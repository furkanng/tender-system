<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table("contacts")->delete();
        $defaultData =
            [
                ['id' => 1, 'address' => "", 'email' => '', "phone" => "", "created_at" => now(), "updated_at" => now()],
            ];

        Contact::query()->insert($defaultData);
    }
}
