<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\DelivermenRequest as StoreRequest;
use App\Http\Requests\DelivermenRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class DelivermenCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class DelivermenCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Delivermen');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/delivermen');
        $this->crud->setEntityNameStrings('delivermen', 'delivermens');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        //$this->crud->setFromDb();
        $this->crud->addColumns([
            ['name'=>'name','type'=>'text','label'=>'Ady'],
            ['name'=>'phone','type'=>'text','label'=>'Telefon'],
        ]);
        $this->crud->addFields([
            ['name'=>'name','type'=>'text','label'=>'Ady'],
            ['name'=>'phone','type'=>'text','label'=>'Telefon'],

             ]);

        // add asterisk for fields that are required in DelivermenRequest
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
