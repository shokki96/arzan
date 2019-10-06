<?php

namespace App\Http\Controllers;

use App\Models\Abonent;
use App\Models\Order;
use App\Models\Order_line;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;
use DB;
use Log;

class OrderController extends Controller
{
    public function store(Request $request){

        $lines = json_decode($request['lines'],true);

        if (empty($request['lines'])) {
            return response()->json(['error' => 'No lines']);
        }

        try{
            DB::beginTransaction();
            $order = new Order();

            if(!auth('api')->guest())
            {
                $order->abonent_id = auth('api')->id();
                $order->phone = auth('api')->user()->phone;
            }else
            {
                $order->phone = $request->get('phone');
                Abonent::firstOrCreate(['phone'=>$order->phone],['password'=>bcrypt($order->phone)]);
            }

            $order->total_price = 0;
            $order->save();

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

                $product = Product::find($orderLine->product_id);
                $product->quantity -= $orderLine->quantity;
                $product->save();
                $order->total_price += $orderLine->total_cost;
            }
            $order->save();

            DB::commit();
            return response()->json(['message' => 'success']);
        }
        catch (\Exception $ex){
            Log::error($ex);
            DB::rollBack();
            DB::commit();
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
}
