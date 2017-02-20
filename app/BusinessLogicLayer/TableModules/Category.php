<?php

namespace App\BusinessLogicLayer\TableModules;

use App\DataAccess\TableDataGateways\CategoriesGateway as CG;

class Category {
    public static function findByName($category) {
        return CG::findByName($category);
    }

    public static function find($id) {
        return CG::find($id);
    }

    public static function insert($name) {
        return CG::insert($name);
    }

    public static function update($id, $name) {
        return CG::update($id, $name);
    }

    public static function delete($id) {
        return CG::delete($id);
    }
}
