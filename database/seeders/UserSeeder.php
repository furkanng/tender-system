<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //DB::table("users")->delete();
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10).'@example.com',
            'password' => Hash::make('password'),
            'phone'=>random_int(100000, 1000000),
            'role'=>random_int(1, 3),
            'status'=>1,
            'address'=>Str::random(10),
            'city'=>Str::random(10),
            'district'=>Str::random(10),
            'office'=>Str::random(10),
            'created_at'=>now(),
            'updated_at'=>now()

        ]);
    }
}
