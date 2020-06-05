<?php

use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genre = ['ujs', 'drama', 'triller', 'fantazia'];
        foreach ($genre as $index => $item) {
            \App\Models\Genre::create([
                'name' => $item
            ]);
        }
    }
}
