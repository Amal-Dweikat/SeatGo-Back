<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Item;

use App\Http\Controllers\ItemController;

Route::get('/search', [ItemController::class, 'ItemController']);
Route::get('/test', function () {
    return "hello";
});


