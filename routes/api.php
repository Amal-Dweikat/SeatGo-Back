<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Item;

use App\Http\Controllers\ItemController;

Route::get('/items', [ItemController::class, 'index']);

Route::get('/test', function () {
    return "hello";
});

Route::get('/search', function (Request $request) {
    $query = $request->query('query');
    $city = $request->query('city');

    $results = \App\Models\Item::query();

    if ($query) {
        $results->where('name', 'LIKE', "%$query%");
    }

    if ($city) {
        $results->where('city', $city);
    }

    return $results->get();
});