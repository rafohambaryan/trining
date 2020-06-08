<?php

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = ['RU', 'USD', 'KZ'];
        foreach ($units as $index => $unit) {
            Unit::create([
                'name' => $unit
            ]);
        }
    }
}
