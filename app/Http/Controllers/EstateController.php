<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstateRequest;
use App\Models\Estate;
use Illuminate\Http\Request;

class EstateController extends Controller
{
    public function list(){

        $filters = \request()->only([
            'estate_type',
            'announcement_type',
            'locationP',//'locationC'
        ]);

        $room = \request('room');

        $query = Estate::with('location:id,name_tm,name_ru')
            ->with('type:id,name_tm,name_ru')
            ->select(['id','images','title','locationP','estate_type','announcement_type']);

        foreach ($filters as $key=>$filter){
            $query->where($key,$filter);
        }

        if($room)
        {
            if($query > 4)
                $query->where('room','>=',$room);
            else
                $query->where('room',$room);
        }

        return $query->orderBy('created_at','DESC')
            ->paginate(10);

    }

    public function item($id){
        return Estate::with(['location:id,name_tm,name_ru','type:id,name_ru,name_tm'])
            ->find($id);
    }

    public function store(EstateRequest $request){

        try{
            Estate::create([
                'title' => $request['title'],
                'description' => $request['description'],
                'locationP' => $request['locationP'],
//                'locationC' => $request['locationC'],
                'estate_type' => $request['estate_type'],
                'room' => $request['room'],
                'phone' => auth()->user()->phone,
                'abonent_id' => auth()->id(),
//                'email' => auth()->user()->email,
                'announcement_type' => $request['announcement_type']
            ]);
            return response()->json(['message' => 'Successfully saved']);
        }
        catch (\Exception $ex){
            return response()->json(['error' => 'Failed']);
        }
    }

    public function delete($id){
        $estate = Estate::find($id);
        if($estate && $estate->abonent_id == auth()->id()){
            $estate->delete();
        }
    }

}
