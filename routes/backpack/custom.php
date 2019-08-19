<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    CRUD::resource('estate', 'EstateCrudController');
    CRUD::resource('estate_type', 'Estate_typeCrudController');
    CRUD::resource('location', 'LocationCrudController');
    CRUD::resource('customer', 'AbonentCrudController');
    CRUD::resource('announcement', 'AnnouncementCrudController');
    CRUD::resource('category', 'CategoryCrudController');
    CRUD::resource('mark', 'MarkCrudController');
    CRUD::resource('vehicle', 'VehicleCrudController');
    CRUD::resource('product', 'ProductCrudController');
    CRUD::resource('contact', 'ContactCrudController');
    CRUD::resource('order', 'OrderCrudController');
    CRUD::resource('slider', 'SliderCrudController');
}); // this should be the absolute last line of this file