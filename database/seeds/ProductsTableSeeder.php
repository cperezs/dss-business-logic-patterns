<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->truncate();

        $category = DB::table('categories')->where('name', 'Processors')->first();
        DB::table('products')->insert(['name' => 'Intel i3-6100', 'price' => '12290', 'stock' => 2, 'category_id' => $category->id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('products')->insert(['name' => 'Intel i5-6400', 'price' => '19578', 'stock' => 1, 'category_id' => $category->id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('products')->insert(['name' => 'AMD FX-4300', 'price' => '7201', 'stock' => 4, 'category_id' => $category->id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        $category = DB::table('categories')->where('name', 'Hard disks')->first();
        DB::table('products')->insert(['name' => '1TB Seagate SATA3 7200', 'price' => '5165', 'stock' => 10, 'category_id' => $category->id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('products')->insert(['name' => '2TB Seagate SATA3 7200', 'price' => '7699', 'stock' => 7, 'category_id' => $category->id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('products')->insert(['name' => '1TB WD SATA3 7200', 'price' => '5424', 'stock' => 5, 'category_id' => $category->id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
