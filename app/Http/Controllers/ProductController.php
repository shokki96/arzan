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
            ->select(['id','title','images','price','locationP','categoryC','created_at','colors', 'size', 'quantity']);

        foreach ($filters as $key => $filter){
            $query->where($key,$filter);
        }
        //        todo sorting???
        return $query->orderBy('created_at','DESC')
            ->paginate(10);
    }



    public function item($id){
        return Product::with([
            'location:id,name_tm,name_ru',
            'subCategory:id,name_tm,name_ru',
        ])->find($id);
    }

    public function store(ProductRequest $request){

        try{
            Product::create([

                'title' => $request['title'],
                'description' => $request['description'],
                'abonent_id' => auth()->id(),
                'price' => $request['price'],
                'locationP' => $request['locationP'],
//                'locationC' => $request['locationC'],
                'phone' => auth()->user()->phone,
                'email' => auth()->user()->email,
                'categoryP' => $request['categoryP'],
                'categoryC' => $request['categoryC']
            ]);
            return response()->json(['message' => 'Successfully saved']);
        }catch (\Exception $ex){
            return response()->json(['error' => 'Failed']);
        }

    }

    public function update(ProductRequest $request){

    }

    public function delete($id){
        $announce = Product::find($id);
        if($announce && $announce->abonent_id == auth()->id()){
            $announce->delete();
        }
    }
}
