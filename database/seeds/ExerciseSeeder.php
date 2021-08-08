<?php

use App\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert([
            'name' => 'Animals'
        ]);
        DB::table('subjects')->insert([
            'name' => 'Body and Face'
        ]);
        DB::table('subjects')->insert([
            'name' => 'Clothes'
        ]);
        DB::table('subjects')->insert([
            'name' => 'Colours'
        ]);
        DB::table('subjects')->insert([
            'name' => 'Family and Friends'
        ]);
        DB::table('subjects')->insert([
            'name' => 'Food and Drinks'
        ]);
        DB::table('subjects')->insert([
            'name' => 'Home'
        ]);
        DB::table('subjects')->insert([
            'name' => 'Names'
        ]);
        DB::table('subjects')->insert([
            'name' => 'Numbers'
        ]);
        DB::table('subjects')->insert([
            'name' => 'Places and Directions'
        ]);
        DB::table('subjects')->insert([
            'name' => 'School'
        ]);
        DB::table('subjects')->insert([
            'name' => 'Sports and Leisure'
        ]);
        DB::table('types')->insert([
            'name' => 'Flashcard with Images',
            'slug' => str_slug('Flashcard with Images')
        ]);
        DB::table('types')->insert([
            'name' => 'Memory Game',
            'slug' => str_slug('Memory Game')
        ]);
        DB::table('types')->insert([
            'name' => 'Drag and Drop',
            'slug' => str_slug('Drag and Drop')
        ]);
    }
}
