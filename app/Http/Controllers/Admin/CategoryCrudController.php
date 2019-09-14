<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CategoryRequest as StoreRequest;
use App\Http\Requests\CategoryRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CategoryCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Category');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/category');
        $this->crud->setEntityNameStrings('category', 'categories');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            ['name'=>'name_tm','type'=>'text','label'=>'Tm ady'],
            ['name'=>'name_ru','type'=>'text','label'=>'Ru ady'],
            ['name'=>'name_en','type'=>'text','label'=>'En ady'],
            ['name'=>'icon','type'=>'text','label'=>'Icon'],
            // options: fontawesome, glyphicon, ionicon, weathericon, mapicon, octicon, typicon, elusiveicon, materialdesign],
        ]);
        $this->crud->addFields([
            ['name'=>'name_tm','type'=>'text','label'=>'Tm ady'],
            ['name'=>'name_ru','type'=>'text','label'=>'Ru ady'],
            ['name'=>'name_en','type'=>'text','label'=>'En ady'],
            [ // image

                'label' => "Material Image",
                'name' => "icon",
                'type' => 'image',
                'upload' => true,
                'crop' => true, // set to true to allow cropping, false to disable
                'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
                'disk' => 'uploads', // in case you need to show images from a different disk
                'prefix' => 'uploads/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            ],
        ]);
        $this->crud->allowAccess('reorder');
        $this->crud->enableReorder('name_tm', 2);

        // add asterisk for fields that are required in CategoryRequest
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
