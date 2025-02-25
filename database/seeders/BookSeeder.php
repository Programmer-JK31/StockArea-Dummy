<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $books = [];
        for($i = 0; $i < 10; $i++) {
            $books[] = ['name' => 'Book'.($i + 1)];
        }

        DB::table('books')->insert($books);
    }
}
