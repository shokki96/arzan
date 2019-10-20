<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\OrderRequest as StoreRequest;
use App\Http\Requests\OrderRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Support\Facades\DB;
use Prologue\Alerts\Facades\Alert;

/**
 * Class OrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class OrderCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Order');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/order');
        $this->crud->setEntityNameStrings('order', 'orders');
        $this->crud->enableExportButtons();
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->addColumns([
            ['name'=>'phone','label'=>'Musderi nomeri', 'type'=>'text'],
            ['name'=>'total_price', 'label'=>'Jemi bahasy', 'type'=>'number', 'decimals' => 2],
            ['name'=>'status','type'=>'text','label'=>'Sargyt statusy'],
            ['name'=>'created_at', 'type'=>'datetime','label'=>'Wagty']

        ]);

        $this->crud->addFields([
            ['name'=>'phone','label'=>'Customer phone', 'type'=>'text'],
            ['name'=>'total_price', 'label'=>'Total price', 'type'=>'number', 'decimals' => 2],
            ['name'=>'status','type'=>'enum','label'=>'Order Status'],
            [  // Select
                'label' => "Dostawshik",
                'type' => 'select',
                'name' => 'delivermen', // the db column for the foreign key
                'entity' => 'delivermen', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\Delivermen",
             
             ]
        ]);
        // TODO: remove setFromDb() and manually define Fields and Columns
        //$this->crud->setFromDb();
        $this->crud->enableDetailsRow();
        $this->crud->allowAccess('details_row');
        // add asterisk for fields that are required in OrderRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
        $this->crud->addButtonFromModelFunction('line', 'sell', 'complete_button', 'beginning');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function showDetailsRow($id){
        $this->crud->hasAccessOrFail('details_row');

        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('crud::details_row', $this->data);
    }

    public function complete($id){
        $order = Order::with('lines')->findOrFail($id);

        DB::beginTransaction();
        foreach ($order->lines as $line){
            $product = $line->product;
            $product_size = json_decode($product->size);
            $key = array_search($line->size, $product_size);
            dd($product_size);
            if($product_size[$key]['quantity']>= $line->quantity){
                $product_size[$key]['quantity'] -=$line->quantity;
                $product->size = json_encode($product_size);
                $product->save();
            }
            else{
                DB::rollBack();
                Alert::error('Zakaz edilen möçber skladda ýeterlik ýok')->flash();
                return redirect()->back();
            }

        }
        $order->status ='completed';
        $order->save();
        DB::commit();
        Alert::success('Zakaz satyldy')->flash();
        return redirect()->back();
    }
}
