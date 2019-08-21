<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index($parent = 0){
        if($parent)
            $locations = Location::where('parent_id',$parent);
        else
            $locations = Location::where('depth',1);

        return $locations->select(['id','name_tm','name_ru', 'name_en'])
            ->orderBy('lft')
            ->get();
    }
}
