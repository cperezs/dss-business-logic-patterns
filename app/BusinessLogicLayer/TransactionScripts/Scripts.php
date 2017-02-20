<?php

namespace App\BusinessLogicLayer\TransactionScripts;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\DataAccessLayer\TableDataGateways\CategoriesGateway as CG;
use App\DataAccessLayer\TableDataGateways\OrdersGateway as OG;
use App\DataAccessLayer\TableDataGateways\OrderLinesGateway as OLG;
use App\DataAccessLayer\TableDataGateways\ProductsGateway as PG;

class Scripts {

    /**
     * Returns an array of products
     *
     * @param category name
     * @return array of products
     */
    public static function productsByCategory($category) {
        $category = CG::findByName($category);
        if ($category)
            return PG::findByCategoryId($category->id);
        else
            return null;
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

        $orderId = OG::insert();

        foreach ($products as $productId => $quantity) {
            $product = PG::find($productId);
            // Checks the availability of the product
            if ($product->stock >= $quantity) {
                // Creates new order line
                OLG::insert($lineNumber, $quantity, $orderId, $productId);
                // Increments next line number
                $lineNumber++;

                // Updates stock
                PG::updateStock($productId, $product->stock - $quantity);
            }
            else {
                // THERE IS NOT ENOGH STOCK -> ROLLBACK
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
