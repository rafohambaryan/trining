<?php

use Illuminate\Database\Seeder;
use App\Models\Line;
use App\Models\CountLine;

class LinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lines = ['Lux', 'Lux', 'Standart', 'Standart', 'Standart', 'Free', 'Free'];

        foreach ($lines as $index => $line) {
            $lineModel = new Line();
            $lineModel->name = $line;
            $lineModel->order = $index + 1;
            $lineModel->save();
            for ($i = 1; $i < 16; $i++) {
                $heir = new CountLine();
                $heir->name = 'N';
                $heir->order = $i;
                $heir->line_id = $lineModel->id;
                $heir->save();
            }
        }
    }
}
