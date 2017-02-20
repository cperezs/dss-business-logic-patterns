<?php

namespace App\BusinessLogicLayer\DomainModel\ActiveRecord;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Category {
    private $id;
    private $name;

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }

    public function getProducts() {
        $products = Product::findByCategoryId($this->id);
        return $products;
    }

    // ActiveRecord methods

    public static function find($id) {
        $query = DB::table('categories')
            ->where('id', $id)
            ->first();

        if ($query) {
            $category = new Category();
            $category->id = $query->id;
            $category->name = $query->name;
            return $category;
        }
        else
            return null;
    }

    public static function findByName($name) {
        $query = DB::table('categories')
            ->where('name', $name)
            ->first();

        if ($query) {
            $category = new Category();
            $category->id = $query->id;
            $category->name = $query->name;
            return $category;
        }
        else
            return null;
    }

    public function update() {
        return DB::table('categories')
            ->where('id', $this->id)
            ->update([
                'name' => $this->name,
                'updated_at' => Carbon::now()
            ]);
    }

    public function insert() {
        $this->id = DB::table('categories')
            ->insertGetId([
                'name' => $this->name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
    }

    public function delete() {
        return DB::table('categories')
            ->where('id', $this->id)
            ->delete();
    }
}
