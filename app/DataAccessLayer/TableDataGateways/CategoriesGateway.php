<?php

namespace App\DataAccessLayer\TableDataGateways;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoriesGateway {
    public static function find($id) {
        return DB::table('categories')
            ->where('id', $id)
            ->first();
    }

    public static function findByName($name) {
        return DB::table('categories')
            ->where('name', $name)
            ->first();
    }

    public static function update($id, $name) {
        return DB::table('categories')
            ->where('id', $id)
            ->update([
                'name' => $name,
                'updated_at' => Carbon::now()
            ]);
    }

    public static function insert($name) {
        $id = DB::table('categories')
            ->insertGetId([
                'name' => $name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        return $id;
    }

    public static function delete($id) {
        return DB::table('categories')
            ->where('id', $id)
            ->delete();
    }
}
