<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\IntegrationController;


Route::resource('products', ProductController::class);

Route::get('/itens', 'IntegrationController@listarItens');
Route::get('/municipios-rio', 'IntegrationController@consultarMunicipiosRio');
