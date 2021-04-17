<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('categories')->insert([
                'title' => 'Category-' . $i,
            ]);
        }

        for ($i = 1; $i <= 10; $i++) {
            DB::table('category_product')->insert([
                'category_id' => 1,
                'product_id' => $i,
            ]);

            DB::table('category_product')->insert([
                'category_id' => 2,
                'product_id' => $i,
            ]);

            DB::table('category_product')->insert([
                'category_id' => 3,
                'product_id' => $i + 10,
            ]);
        }

    }
}
