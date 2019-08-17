<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_line;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request){

        try{

            $lines = json_decode($request['lines'],true);

            $order = new Order();

            if(!auth('api')->guest())
            {
                $order->abonent_id = auth('api')->id();
                $order->phone = auth('api')->user()->phone;
            }else
                $order->phone = $request->get('phone');

            $order->total_price = 0;
            $order->save();

            if (empty($request['lines'])) {
              return response()->json(['error' => 'No lines']);
            }

            //dd($lines);
            foreach ($lines as $line){
                $orderLine = new Order_line();
                $orderLine->product_id = $line['product_id'];
                $orderLine->quantity = $line['quantity'];
                $orderLine->size = $line['size'];
                $orderLine->color = $line['color'];
                $orderLine->price = $line['price'];
                $orderLine->order_id = $order->id;
                $orderLine->total_cost = $line['price']*$line['quantity'];
                $orderLine->save();
                $order->total_price += $orderLine->total_cost;
            }
            $order->save();
            return response()->json(['message' => 'Successfully saved']);
        }
        catch (\Exception $ex){
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
}
