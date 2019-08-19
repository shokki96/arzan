<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ProductRequest as StoreRequest;
use App\Http\Requests\ProductRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Product');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/product');
        $this->crud->setEntityNameStrings('product', 'products');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        //$this->crud->setFromDb();\

         $this->crud->addColumns([
            ['name'=>'title','type'=>'text','label'=>'Title'],
            ['name'=>'description','type'=>'text','label'=>'Description'],
            ['name'=>'phone','label'=>'Phone','type' => 'number'],
            ['name'=>'price','label'=>'Price','type' => 'number'],
            ['name'=>'images','type'=>'text','label'=>'Images'],
            ['name'=>'created_at','type'=>'date_time','label'=>'Date'],
            ['label'=>'Category P.', 'type'=>'select', 'name'=>'categoryP', 'entity'=>'category',
                'model'=>'App\Models\Category','attribute' => 'name_tm', 'searchLogic' => false],
            ['name'=>'categoryC','type'=>'select','label'=>'Category C.', 'entity'=>'subCategory',
                'model'=>'App\Models\Category', 'attribute' => 'name_tm','searchLogic' => false],
            ['name'=>'locationP','type'=>'select','label'=>'Location P.', 'entity'=>'location',
                'model'=>'App\Models\Location','attribute' => 'name_tm', 'searchLogic' => false],

                ['name'=>'quantity','type'=>'text','label'=>'Quantity'],
             // ['name'=>"colors", 'type'=>'table', 'label'=>'Colors','columns'=>['name'=>'Name','code'=>'Code']],
             // ['name'=>"size", 'type'=>'table', 'label'=>'Size','columns'=>['size'=>'Size']]

        ]);
        $this->crud->addFields([
            ['name'=>'title','type'=>'text','label'=>'Title'],
            ['name'=>'quantity','type'=>'number','label'=>'Quantity'],
            ['name'=>'description','type'=>'text','label'=>'Description'],

            ['name'=>'images','type'=>'upload_multiple','label'=>'Images',
            'upload' => true,'uploads'=>true],

            ['name'=>'phone','label'=>'Phone','type' => 'number'],
            ['name'=>'price','label'=>'Price','type' => 'number'],
            ['name'=>'categoryP','attribute'=>'name_tm','type'=>'select','label'=>'Category P.',
                'entity'=>'category', 'model'=>'App\Models\Category',
                'options'=>(function ($query) {
                    return $query->orderBy('name_tm', 'ASC')->where('depth', 1)->get();
                }),
            ],
            ['name'=>'categoryC','attribute'=>'name_tm','type'=>'select2_nested','label'=>'Category C.', 'entity'=>'subCategory', 'model'=>'App\Models\Category'],
            ['name'=>'locationP','attribute'=>'name_tm','type'=>'select','label'=>'Location P.',
                'entity'=>'location', 'model'=>'App\Models\Location',
                'options'=>(function ($query) {
                    return $query->orderBy('name_tm', 'ASC')->where('depth', 1)->get();
                })
            ],
            ['name'=>"colors", 'type'=>'table','entity_singular' => 'option', 'label'=>'Colors','columns'=>['name'=>'Name','code'=>'Code']],
            ['name'=>"size", 'type'=>'table', 'entity_singular' => 'option','label'=>'Size','columns'=>['size'=>'Size']]
             ]);

        // add asterisk for fields that are required in ProductRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
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
}
