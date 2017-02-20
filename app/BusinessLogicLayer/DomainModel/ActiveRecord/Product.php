<?php

namespace App\BusinessLogicLayer\DomainModel\ActiveRecord;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Product {
    private $id;
    private $name;
    private $price;
    private $stock;
    private $categoryId;

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }
    public function getPrice() { return $this->price; }
    public function setPrice($price) { $this->price = $price; }
    public function getStock() { return $this->stock; }
    public function setStock($stock) { $this->stock = $stock; }
    public function getCategoryId() { return $this->categoryId; }
    public function setCategoryId($categoryId) { $this->categoryId = $categoryId; }

    public function getCategory() {
        $category = Category::find($this->categoryId);
        return $category;
    }

    // ActiveRecord methods

    private static function queryToProduct($query) {
        $product = new Product();
        $product->id = $query->id;
        $product->name = $query->name;
        $product->price = $query->price;
        $product->stock = $query->stock;
        $product->categoryId = $query->category_id;
        return $product;
    }

    public static function find($id) {
        $query = DB::table('products')
            ->where('id', $id)
            ->first();

        if ($query) return self::queryToProduct($query);
        else return null;
    }

    public static function findByCategoryId($categoryId) {
        $query = DB::table('products')
            ->where('category_id', $categoryId)
            ->get();

        if ($query) {
            $products = array();
            foreach ($query as $product) {
                $products[] = self::queryToProduct($product);
            }
            return $products;
        }
        else return null;
    }

    public function update() {
        return DB::table('products')
            ->where('id', $this->id)
            ->update([
                'name' => $this->name,
                'price' => $this->price,
                'stock' => $this->stock,
                'category_id' => $this->categoryId,
                'updated_at' => Carbon::now()
            ]);
    }

    public  function insert() {
        $this->id = DB::table('products')
            ->insertGetId([
                'name' => $this->name,
                'price' => $this->price,
                'stock' => $this->stock,
                'category_id' => $this->categoryId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
    }

    public function delete() {
        return DB::table('products')
            ->where('id', $this->id)
            ->delete();
    }
}
