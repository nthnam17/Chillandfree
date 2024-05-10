<?php

namespace Database\Seeders;

use Database\Seeders\GeneralTableSeeder as SeedersGeneralTableSeeder;
use GeneralTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call(usersTableSeeder::class);
       $this->call(SeedersGeneralTableSeeder::class);
       $this->call(GeneralTranslationsTableSeeder::class);
    }
}
