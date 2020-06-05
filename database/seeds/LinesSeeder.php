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
        $lines = [
            [
                'name' => 'Lux',
                'price' => '500',
                'order' => '1'
            ],
            [
                'name' => 'Lux',
                'price' => '450',
                'order' => '2'
            ],
            [
                'name' => 'Standart',
                'price' => '300',
                'order' => '3'
            ],
            [
                'name' => 'Standart',
                'price' => '350',
                'order' => '4'
            ],
            [
                'name' => 'Free',
                'price' => '0',
                'order' => '5'
            ],
        ];

        foreach ($lines as $index => $line) {
            $lineModel = new Line();
            $lineModel->name = $line['name'];
            $lineModel->price = $line['price'];
            $lineModel->order = $line['order'];
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
