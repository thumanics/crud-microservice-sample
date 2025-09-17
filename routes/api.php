<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);

Route::get('/', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'User CRUD API is running',
        'endpoints' => [
            'GET /api/users' => 'List all users',
            'GET /api/users/{id}' => 'Get specific user',
            'POST /api/users' => 'Create new user',
            'PUT /api/users/{id}' => 'Update user',
            'DELETE /api/users/{id}' => 'Delete user'
        ]
    ]);
});