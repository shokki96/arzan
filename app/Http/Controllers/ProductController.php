<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function contact(){
        $query = Contact::get();
        return $query;
    }


    public function list(){
        $filters = \request()->only(['categoryP','categoryC','locationP']);
        $query = Product::with('location:id,name_tm,name_ru')
            ->with('subCategory:id,name_tm,name_ru')
            ->select(['id','title','title_ru','title_en','images','price','locationP','categoryC','created_at','colors', 'size', 'quantity']);

        foreach ($filters as $key => $filter){
            $query->where($key,$filter);
        }
        //        todo sorting???
        return $query->orderBy('created_at','DESC')
            ->paginate(6);
    }



    public function item($id){
        return Product::with([
            'location:id,name_tm,name_ru,name_en',
            'subCategory:id,name_tm,name_ru,name_en',
        ])->find($id);
    }



}
