<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\MarkRequest as StoreRequest;
use App\Http\Requests\MarkRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class MarkCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class MarkCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Mark');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/mark');
        $this->crud->setEntityNameStrings('mark', 'marks');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            ['name'=>'name','type'=>'text','label'=>'Name'],
            ['name'=>'logo','type'=>'text','label'=>'Logo'],
        ]);

        $this->crud->addFields([
            ['name'=>'name','type'=>'text','label'=>'Name'],
            ['name'=>'logo','type'=>'text','label'=>'Logo'],
        ]);

        $this->crud->allowAccess('reorder');
        $this->crud->enableReorder('name', 2);

        // add asterisk for fields that are required in MarkRequest
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
