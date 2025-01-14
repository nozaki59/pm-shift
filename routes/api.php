<?php

use App\Http\Controllers\ShiftController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/shifts', [ShiftController::class, 'getShifts']);
