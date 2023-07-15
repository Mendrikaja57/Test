<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('sonorisation', 'SonorisationCrudController');
    Route::crud('logistique', 'LogistiqueCrudController');
    Route::crud('type-lieu', 'TypeLieuCrudController');
    Route::crud('lieu', 'LieuCrudController');
    Route::crud('autre-depense', 'AutreDepenseCrudController');
    Route::crud('type-event', 'TypeEventCrudController');
}); // this should be the absolute last line of this file