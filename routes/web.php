<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\CustomerController;

Route::get('/', function (Request $request) {
   return view('welcome');
});

// @todo should have been on the routes/api.php
Route::get('/customers', [CustomerController::class, 'getAllCustomers']);
Route::get('/customers/{customerId}', [CustomerController::class, 'getCustomer']);