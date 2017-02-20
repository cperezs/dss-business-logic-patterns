<?php

namespace App\BusinessLogicLayer\DomainModel\ActiveRecord;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Order {
    private $id;

    public function getId() { return $this->id; }

    public function getLines() {
        $lines = OrderLine::findByOrderId($this->id);
        return $lines;
    }

    public function getTotal() {
        $total = 0.0;
        
        $lines = $this->getLines();
        foreach ($lines as $line) {
            $total += $line->getSubTotal();
        }

        return $total;
    }

    // ActiveRecord methods

    private static function queryToOrder($query) {
        $order = new Order();
        $order->id = $query->id;
        return $order;
    }

    public static function find($id) {
        $query = DB::table('orders')
            ->where('id', $id)
            ->first();

        if ($query) return self::queryToOrder($query);
        else return null;
    }

    public function update() {
        return DB::table('orders')
            ->where('id', $this->id)
            ->update([
                'updated_at' => Carbon::now()
            ]);
    }

    public function insert() {
        $this->id = DB::table('orders')
            ->insertGetId([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
    }

    public function delete() {
        return DB::table('orders')
            ->where('id', $this->id)
            ->delete();
    }
}
