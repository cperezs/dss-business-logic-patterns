<?php

namespace App\BusinessLogicLayer\TransactionScripts;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RawScripts {

    /**
     * Returns an array of products
     *
     * @param category name
     * @return array of products
     */
    public static function productsByCategory($category) {
        $products = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('categories.name', $category)
            ->select('products.id', 'products.name', 'products.price', 'products.stock')
            ->get();
        return $products;
    }

    /**
     * Creates a new order if there is enough stock for the products
     *
     * @param associative array (product_id => quantity)
     * @return id of the new order or null
     */
    public static function processOrder($products) {
        $rollback = false;
        $lineNumber = 1;

        DB::beginTransaction();

        $orderId = DB::table('orders')->insertGetId([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        foreach ($products as $productId => $quantity) {
            $product = DB::table('products')->where('id', $productId)->first();
            // Checks the availability of the product
            if ($product->stock >= $quantity) {
                // Creates new order line
                DB::table('order_lines')->insert([
                    'number' => $lineNumber,
                    'quantity' => $quantity,
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                // Increments next line number
                $lineNumber++;

                // Updates stock
                DB::table('products')->where('id', $productId)
                    ->update([
                        'stock' => $product->stock - $quantity,
                        'updated_at' => Carbon::now()
                    ]);
            }
            else {
                // THERE IS NOT ENOUGH STOCK -> ROLLBACK
                $rollback = true;
                break;
            }
        }

        if ($rollback) {
            DB::rollBack();
            return null;
        }

        DB::commit();
        return $orderId;
    }
}
