<?php

namespace App\DataAccessLayer\TableDataGateways;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrdersGateway {
    public static function find($id) {
        return DB::table('orders')
            ->where('id', $id)
            ->first();
    }

    public static function update($id) {
        return DB::table('orders')
            ->where('id', $id)
            ->update([
                'updated_at' => Carbon::now()
            ]);
    }

    public static function insert() {
        $id = DB::table('orders')
            ->insertGetId([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        return $id;
    }

    public static function delete($id) {
        return DB::table('orders')
            ->where('id', $id)
            ->delete();
    }
}
