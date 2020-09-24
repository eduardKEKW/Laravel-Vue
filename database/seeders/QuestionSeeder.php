<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $possibilities = array_map(function ($pos) {
            return ['name' => $pos];
        }, ['Good', 'Fair', 'Neutral', 'Bad']);

        DB::table('questions')->insert($possibilities);
    }
}
