<?php

namespace App\ServiceLayer;

use Illuminate\Support\Facades\DB;

use App\BusinessLogicLayer\DomainModel\ActiveRecord\Order;
use App\BusinessLogicLayer\DomainModel\ActiveRecord\OrderLine;
use App\BusinessLogicLayer\DomainModel\ActiveRecord\Product;

class ActiveRecordServices {
    public static function processOrder($products) {
        $rollback = false;
        $lineNumber = 1;

        DB::beginTransaction();

        $order = new Order();
        $order->insert();

        foreach ($products as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product->getStock() >= $quantity) {
                $product->setStock($product->getStock() - $quantity);
                $product->update();
                
                $line = new OrderLine();
                $line->setNumber($lineNumber);
                $line->setQuantity($quantity);
                $line->setOrderId($order->getId());
                $line->setProductId($productId);
                $line->insert();

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
        return $order;
    }

}
