<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($parent = 0){
        if($parent)
            $locations = Category::where('parent_id',$parent);
        else
            $locations = Category::where('depth',1);

        return $locations->select(['id','name_tm','name_ru','name_en','icon'])
            ->orderBy('lft')
            ->get();
    }
}
