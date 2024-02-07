<?php

use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\ProduitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


            /****** Produit Api *****/
Route::controller(ProduitController::class)->prefix("/products")->group(function (){
    Route::post("/", "create");
    Route::get("/", "index");
    Route::get("/{product}", "findOne")->where('product', '[0-9]+');
    Route::patch("/{product}", "update")->where('product','[0-9]+');
    Route::delete("/{product}", "delete")->where('product','[0-9]+');
});




/********** Invoice Api **********/
Route::controller(InvoiceController::class)->prefix("/invoices")->group(function (){
    Route::get("/", "index");
    Route::get("/{invoice}", "findOne")->where('invoice','[0-9]+');
    Route::delete("/{invoice}", "delete")->where('invoice','[0-9]+');
    Route::post("/", "create")->where('invoice','[0-9]+');
    Route::patch("/{invoice}", "update")->where('invoice','[0-9]+');
});


