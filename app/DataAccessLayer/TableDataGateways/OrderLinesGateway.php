<?php

namespace App\DataAccessLayer\TableDataGateways;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderLinesGateway {
    public static function find($id) {
        return DB::table('order_lines')
            ->where('id', $id)
            ->first();
    }

    public static function findByOrderId($orderId) {
        return DB::table('order_lines')
            ->where('order_id', $orderId)
            ->get();
    }

    public static function update($id, $number, $quantity, $orderId, $productId) {
        return DB::table('order_lines')
            ->where('id', $id)
            ->update([
                'number' => $number,
                'quantity' => $quantity,
                'order_id' => $orderId,
                'product_id' => $productId,
                'updated_at' => Carbon::now()
            ]);
    }

    public static function insert($number, $quantity, $orderId, $productId) {
        $id = DB::table('order_lines')
            ->insertGetId([
                'number' => $number,
                'quantity' => $quantity,
                'order_id' => $orderId,
                'product_id' => $productId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        return $id;
    }

    public static function delete($id) {
        return DB::table('order_lines')
            ->where('id', $id)
            ->delete();
    }
}
