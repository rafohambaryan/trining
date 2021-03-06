<?php

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
         $this->call(LinesSeeder::class);
         $this->call(RoleSeeder::class);
         $this->call(GenreSeeder::class);
         $this->call(UnitSeeder::class);
    }
}
