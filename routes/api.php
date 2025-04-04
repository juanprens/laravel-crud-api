<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas CRUD para Productos
Route::apiResource('products', ProductController::class);

// Rutas adicionales para el CRUD
Route::prefix('products')->group(function () {
    Route::delete('force-delete/{id}', [ProductController::class, 'forceDelete']);
    Route::post('restore/{id}', [ProductController::class, 'restore']);
    Route::get('deleted', [ProductController::class, 'deletedProducts']);
});

// Ruta de salud de la API
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API is running',
        'timestamp' => now()->toDateTimeString()
    ]);
});