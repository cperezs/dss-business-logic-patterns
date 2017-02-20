<?php

namespace App\DataAccessLayer\DataMappers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\BusinessLogicLayer\DomainModel\Category;

class CategoryMapper {
    // THIS FINDER SHOULDN'T BE HERE!!! see Fowler(2003), DataMapper
    public static function find($id) {
        $query = DB::table('categories')
            ->where('id', $id)
            ->first();
        
        if ($query) {
            $category = new Category();
            $category->setId($query->id);
            $category->setName($query->name);
            return $category;
        }
        else return null;
    }

    public static function insert($category) {
        $id = DB::table('categories')
            ->insertGetId([
                'name' => $category->getName(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        $category->setId($id);
    }
}
