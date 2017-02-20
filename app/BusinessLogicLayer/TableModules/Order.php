<?php

namespace App\BusinessLogicLayer\TableModules;

use App\DataAccessLayer\TableDataGateways\OrdersGateway as OG;

class Order {
    public static function find($id) {
        return OG::find($id);
    }

    public static function update($id) {
        return OG::update($id);
    }

    public static function insert() {
        return OG::insert();
    }

    public static function delete($id) {
        return OG::delete($id);
    }
}
