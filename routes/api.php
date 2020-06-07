<?php

use App\Slider;
use Illuminate\Http\Request;
app('debugbar')->disable();

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('slider', function (Request $request) {
    return Slider::orderBy("id", "desc")
                ->take(4)->get();
});

