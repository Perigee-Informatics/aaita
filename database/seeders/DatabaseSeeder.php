<?php

namespace Database\Seeders;

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
        $this->call(DateSettingSeeder::class);
        $this->call(PrimaryMasterTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(GeoCoordinatesSeeder::class);

    }
}
