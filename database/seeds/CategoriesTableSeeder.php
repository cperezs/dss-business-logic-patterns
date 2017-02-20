<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();

        DB::table('categories')->insert(['name' => 'Processors', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('categories')->insert(['name' => 'Hard disks', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
