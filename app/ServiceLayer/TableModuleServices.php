<?php

namespace App\ServiceLayer;

use Illuminate\Support\Facades\DB;

use App\BusinessLogicLayer\TableModules\Order;
use App\BusinessLogicLayer\TableModules\OrderLine;
use App\BusinessLogicLayer\TableModules\Product;

class TableModuleServices {
    public static function processOrder($products) {
        $rollback = false;
        $lineNumber = 1;

        DB::beginTransaction();

        $orderId = Order::insert();

        foreach ($products as $productId => $quantity) {
            if (Product::decreaseStock($productId, $quantity)) {
                OrderLine::insert($lineNumber, $quantity, $orderId, $productId);
                $lineNumber++;
            }
            else {
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
