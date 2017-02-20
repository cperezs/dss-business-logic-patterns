<?php

namespace App\BusinessLogicLayer\TableModules;

use App\BusinessLogicLayer\TableModules\Category;

use App\DataAccessLayer\TableDataGateways\ProductsGateway as PG;

class Product {
    public static function findByCategory($category) {
        $category = Category::findByName($category);
        if ($category)
            return PG::findByCategoryId($category->id);
        else
            return null;
    }

    public static function decreaseStock($id, $quantity) {
        $product = PG::find($id);
        if ($product && $product->stock >= $quantity) {
            PG::updateStock($id, $product->stock - $quantity);
            return true;
        }
        else
            return false;
    }

    public static function find($id) {
        return PG::find($id);
    }

    public static function insert($name, $price, $stock, $category_id) {
        return PG::insert($name, $price, $stock, $category_id);
    }

    public static function update($id, $name, $price, $stock, $categoryId) {
        return PG::update($id, $name, $price, $stock, $categoryId);
    }

    public static function delete($id) {
        return PG::delete($id);
    }
}
