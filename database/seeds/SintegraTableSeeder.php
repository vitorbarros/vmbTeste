<?php

use Illuminate\Database\Seeder;
use VmbTest\Models\Sintegra;

class SintegraTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Sintegra::class, 50)->create();
    }
}
