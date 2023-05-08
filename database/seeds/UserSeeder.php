<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$UKbZm3Ia0H5FtkjdyyDAhe.g11kIMbypQhtqpaqWyCj9lM5gsVnme',
        ]);
    }
}
