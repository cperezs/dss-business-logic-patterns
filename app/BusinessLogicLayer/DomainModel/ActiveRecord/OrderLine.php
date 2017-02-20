<?php

namespace App\BusinessLogicLayer\DomainModel\ActiveRecord;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderLine {
    private $id;
    private $number;
    private $quantity;
    private $orderId;
    private $productId;

    public function getId() { return $this->id; }
    public function getNumber() { return $this->number; }
    public function setNumber($number) { $this->number = $number; }
    public function getQuantity() { return $this->quantity; }
    public function setQuantity($quantity) { $this->quantity = $quantity; }
    public function getOrderId() { return $this->orderId; }
    public function setOrderId($orderId) { $this->orderId = $orderId; }
    public function getProductId() { return $this->productId; }
    public function setProductId($productId) { $this->productId = $productId; }

    public function getSubTotal() {
        $product = $this->getProduct();
        return $product->getPrice() * $this->quantity;
    }

    public function getProduct() {
        return Product::find($this->productId);
    }

    public function getOrder() {
        return Order::find($this->orderId);
    }

    // ActiveRecord methods

    private static function queryToOrderLine($query) {
        $orderLine = new OrderLine();
        $orderLine->id = $query->id;
        $orderLine->number = $query->number;
        $orderLine->quantity = $query->quantity;
        $orderLine->orderId = $query->order_id;
        $orderLine->productId = $query->product_id;
        return $orderLine;
    }

    public static function find($id) {
        $query = DB::table('order_lines')
            ->where('id', $id)
            ->first();

        if ($query) return self::queryToOrderLine($query);
        else return null;
    }

    public static function findByOrderId($orderId) {
        $query = DB::table('order_lines')
            ->where('order_id', $orderId)
            ->get();

        $lines = array();
        foreach ($query as $line) {
            $lines[] = self::queryToOrderLine($line);
        }
        return $lines;
    }

    public function update() {
        return DB::table('order_lines')
            ->where('id', $this->id)
            ->update([
                'number' => $this->number,
                'quantity' => $this->quantity,
                'order_id' => $this->orderId,
                'product_id' => $this->productId,
                'updated_at' => Carbon::now()
            ]);
    }

    public function insert() {
        $this->id = DB::table('order_lines')
            ->insertGetId([
                'number' => $this->number,
                'quantity' => $this->quantity,
                'order_id' => $this->orderId,
                'product_id' => $this->productId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
    }

    public function delete() {
        return DB::table('order_lines')
            ->where('id', $this->id)
            ->delete();
    }
}
