<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginEmployee;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\InsertController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/export', function () {
    return view('export');
});

Route::get('/employe', function () {
    return view('loginEmploye');
});


Route::get('/index', function () {
    return view('index');
});

Route::post('/login', [LoginEmployee::class, 'connexion']);


Route::get('/event',[ListController::class,"ajoutDevis"])->name("ajoutDevis");
Route::get('/insertDevis',[InsertController::class,"insert_devis"])->name("insertDevis");


Route::get('/eventArtiste',[ListController::class,"ajoutArtisteDevis"])->name("ajoutArtisteDevis");
Route::get('/insertArtisteDevis',[InsertController::class,"insert_artiste_devis"])->name("insertArtisteDevis");

Route::get('/eventSono',[ListController::class,"ajoutSonoDevis"])->name("ajoutSonoDevis");
Route::get('/insertSonoDevis',[InsertController::class,"insert_sono_devis"])->name("insertSonoDevis");

Route::get('/eventLogis',[ListController::class,"ajoutLogisDevis"])->name("ajoutLogisDevis");
Route::get('/insertLogisDevis',[InsertController::class,"insert_logis_devis"])->name("insertLogisDevis");

Route::get('/eventAutre',[ListController::class,"ajoutAutreDevis"])->name("ajoutAutreDevis");
Route::get('/insertAutreDevis',[InsertController::class,"insert_autre_devis"])->name("insertAutreDevis");

Route::get('/listeDevis',[ListController::class,"listeDevis"])->name("listeDevis");

Route::get('/devisDetail/{id}', [ListController::class,"depenseByIdEvent"])->name('devisDetail');

Route::get('/ListupdateEvent/{id}',[InsertController::class,"update_event"])->name("ListupdateEvent");
Route::put('/updateEvent/{id}',[InsertController::class,"update_event2"])->name("updateEvent");

Route::get('/ListupdateArtiste/{id}',[InsertController::class,"update_artiste"])->name("ListupdateArtiste");
Route::get('/updateArtiste',[InsertController::class,"update_artiste2"])->name("updateArtiste");

Route::get('/ListupdateSono',[InsertController::class,"update_sono"])->name("ListupdateSono");
Route::get('/updateSono',[InsertController::class,"update_sono2"])->name("updateSono");

Route::get('/ListupdateLogis',[InsertController::class,"update_logis"])->name("ListupdateLogis");
Route::get('/updateSono',[InsertController::class,"update_logis2"])->name("updateLogis");

Route::get('/ListupdateAutre',[InsertController::class,"update_autre"])->name("ListupdateAutre");
Route::get('/updateAutre',[InsertController::class,"update_autre2"])->name("updateLogis");