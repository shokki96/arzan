<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Slider;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SliderCOntroller extends Controller
{
    public function contact(){
        $query = Contact::get();
        return $query;
    }


    public function list(){
        
        $query = Slider::select(['id','img']);

        //        todo sorting???
        return $query->orderBy('created_at','DESC')
            ->paginate(6);
    }



}
