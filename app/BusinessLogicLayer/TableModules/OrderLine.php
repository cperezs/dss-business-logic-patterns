<?php

namespace App\BusinessLogicLayer\TableModules;

use App\DataAccessLayer\TableDataGateways\OrderLinesGateway as OLG;

class OrderLine {
    public static function find($id) {
        return OLG::find($id);
    }

    public static function findByOrderId($orderId) {
        return OLG::findByOrderId($orderId);
    }

    public static function update($id, $number, $quantity, $orderId, $productId) {
        return OLG::update($id, $number, $quantity, $orderId, $productId);
    }

    public static function insert($number, $quantity, $orderId, $productId) {
        return OLG::insert($number, $quantity, $orderId, $productId);
    }

    public static function delete($id) {
        return OLG::delete($id);
    }
}
