<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MidtransController;

Route::post('/mt-callback', [MidtransController::class, 'callback']);
