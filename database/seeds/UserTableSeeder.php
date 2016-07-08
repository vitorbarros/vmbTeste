<?php

use Illuminate\Database\Seeder;
use VmbTest\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create();
    }
}
