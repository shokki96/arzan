<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function list(){
        $filters = \request()->only(['mark','model','locationP',//'locationC',
            'year','motor','probeg','kredit','obmen','karopka']);
        $price_start = \request('price_start');
        $price_end = \request('price_end');

        $query = Vehicle::with(['location:id,name_tm,name_ru','mark:id,name','model:id,name'])
            ->select(['id','title','images','price','locationP','categoryC','created_at'])
            ->where('approved',1);

        foreach ($filters as $key=>$filter){
            $query->where($key,$filter);
        }

        if($price_start)
            $query->where('price','>=',$price_start);

        if($price_end)
            $query->where('price','<=',$price_end);

//        todo sorting???
        return $query->orderBy('created_at','DESC')
            ->paginate(10);
    }

    public function store(VehicleRequest $request){
        try{
            //todo add vehicle type sedan, depik ...
            Vehicle::create([
                'mark' =>$request['mark'],
                'model'=>$request['model'],
                'locationP'=>$request['locationP'],
//                'locationC'=>$request['locationC'],
                'year'=>$request['year'],
                'motor'=>$request['motor'],
                'probeg'=>$request['probeg'],
                'kredit'=>$request['kredit'],
                'obmen'=>$request['obmen'],
                'karopka'=>$request['karopka'],
                'phone' => auth()->user()->phone,
//                'email' => auth()->user()->email,
            ]);
            return response()->json(['message' => 'Successfully saved']);
        }catch (\Exception $ex){
            return response()->json(['error' => 'Failed']);
        }
    }

    public function item($id){
        return Vehicle::with(['location:name_tm,name_ru','model:name','mark:name'])->find($id);
    }

    public function delete($id){
        $vehicle = Vehicle::find($id);
        if($vehicle && $vehicle->abonent_id == auth()->id()){
            $vehicle->delete();
        }
    }
}
