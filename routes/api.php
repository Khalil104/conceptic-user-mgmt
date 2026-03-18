<?php
use Illuminate\Support\Facades\Route;

Route::get('/test', function() {
    return response()->json(['message' => 'L’API répond enfin !']);
});

Route::post('/register', function() {
    return response()->json(['message' => 'Route register trouvée !']);
});