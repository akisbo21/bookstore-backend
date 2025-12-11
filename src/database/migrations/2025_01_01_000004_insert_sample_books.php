<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('authors')->insert([
            ['id' => 1, 'name' => 'J. R. R. Tolkien', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Isaac Asimov',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'George R. R. Martin', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Fantasy', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Sci-fi',  'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Drama',   'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('books')->insert([
            [
                'title'        => 'The Hobbit',
                'author_id'    => 1,
                'category_id'  => 1,
                'release_date' => '1937-09-21',
                'price_huf'    => 4500,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'title'        => 'The Lord of the Rings',
                'author_id'    => 1,
                'category_id'  => 1,
                'release_date' => '1954-07-29',
                'price_huf'    => 7800,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'title'        => 'Foundation',
                'author_id'    => 2,
                'category_id'  => 2,
                'release_date' => '1951-01-01',
                'price_huf'    => 5200,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'title'        => 'I, Robot',
                'author_id'    => 2,
                'category_id'  => 2,
                'release_date' => '1950-12-02',
                'price_huf'    => 3900,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'title'        => 'A Game of Thrones',
                'author_id'    => 3,
                'category_id'  => 3,
                'release_date' => '1996-08-06',
                'price_huf'    => 6500,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('books')->delete();
        DB::table('authors')->delete();
        DB::table('categories')->delete();
    }
};
