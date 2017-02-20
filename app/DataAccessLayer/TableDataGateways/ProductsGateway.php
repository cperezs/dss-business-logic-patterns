<?php

namespace App\DataAccessLayer\TableDataGateways;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductsGateway {
    public static function find($id) {
        return DB::table('products')
            ->where('id', $id)
            ->first();
    }

    public static function findByCategoryId($categoryId) {
        return DB::table('products')
            ->where('category_id', $categoryId)
            ->get();
    }

    public static function update($id, $name, $price, $stock, $categoryId) {
        return DB::table('products')
            ->where('id', $id)
            ->update([
                'name' => $name,
                'price' => $price,
                'stock' => $stock,
                'category_id' => $categoryId,
                'updated_at' => Carbon::now()
            ]);
    }

    public static function updateStock($id, $stock) {
        return DB::table('products')->where('id', $id)
            ->update([
                'stock' => $stock,
                'updated_at' => Carbon::now()
            ]);
    }

    public static function insert($name, $price, $stock, $categoryId) {
        $id = DB::table('products')
            ->insertGetId([
                'name' => $name,
                'price' => $price,
                'stock' => $stock,
                'category_id' => $categoryId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        return $id;
    }

    public static function delete($id) {
        return DB::table('products')
            ->where('id', $id)
            ->delete();
    }
}
