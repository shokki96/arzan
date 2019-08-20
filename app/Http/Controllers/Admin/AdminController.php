<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    protected $data = []; // the information we send to the view
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(backpack_middleware());
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $start_date = request('start_date');
        $end_date = request('end_date');
        $order = Order::select('id');//count with sum
        $users = User::select('id');
        if($start_date && $end_date)
        {
            //$filter_by_date = " and (orders.created_at BETWEEN {$start_date} and {$end_date})";
            $order->whereBetween('created_at',[date($start_date),date($end_date)]);
            $users->whereBetween('created_at',[date($start_date),date($end_date)]);
        }

        $this->data['orders'] = $order->count();
        $this->data['users'] = $users->count();
//        $this->data['categories'] = Category::withCount(['orders'])->get();
        $query = Category::has('orders')->withCount([
            'orders',
            'orders as total' => function($query) use ($end_date, $start_date) {
                $query->select(DB::raw('SUM(order_lines.total_cost)'));
                if($start_date && $end_date){
                    $query->whereBetween('order_lines.created_at',[date($start_date),date($end_date)]);
                }
            }
        ]);



        $this->data['categories'] = $query->get();
        //dd($this->data['categories']);
        return view('backpack::dashboard', $this->data);
    }
}
