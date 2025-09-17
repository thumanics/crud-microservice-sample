<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CQRSUserController;
use App\Http\Controllers\DDDUserController;
use Illuminate\Support\Facades\Route;

// Traditional CRUD endpoints
Route::apiResource('users', UserController::class);

// CQRS-based endpoints
Route::prefix('v2')->group(function () {
    Route::apiResource('users', CQRSUserController::class);
});

// DDD + CQRS enterprise endpoints
Route::prefix('v3')->group(function () {
    Route::apiResource('users', DDDUserController::class);
});




// Route::get('/', function () {
//     return response()->json([
//         'status' => 'success',
//         'message' => 'Enterprise User Management API - Multiple Architecture Patterns',
//         'architecture_evolution' => [
//             '' => 'Traditional CRUD with direct Eloquent (Basic)',
//             'v2' => 'CQRS with Command/Query separation (Intermediate)',
//             'v3' => 'DDD + CQRS with Value Objects, Entities, Aggregates (Enterprise)'
//         ],
//         'endpoints' => [
//             'traditional' => [
//                 'GET /api/users' => 'List all users (Traditional MVC)',
//                 'GET /api/users/{id}' => 'Get specific user (Traditional MVC)',
//                 'POST /api/users' => 'Create new user (Traditional MVC)',
//                 'PUT /api/users/{id}' => 'Update user (Traditional MVC)',
//                 'DELETE /api/users/{id}' => 'Delete user (Traditional MVC)'
//             ],
//             'v2_cqrs' => [
//                 'GET /api/v2/users' => 'List all users (CQRS Pattern)',
//                 'GET /api/v2/users/{id}' => 'Get specific user (CQRS Pattern)',
//                 'POST /api/v2/users' => 'Create new user (CQRS Pattern)',
//                 'PUT /api/v2/users/{id}' => 'Update user (CQRS Pattern)',
//                 'DELETE /api/v2/users/{id}' => 'Delete user (CQRS Pattern)'
//             ],
//             'v3_ddd_enterprise' => [
//                 'GET /api/v3/users' => 'List all users (DDD + CQRS + Clean Architecture)',
//                 'GET /api/v3/users/{id}' => 'Get specific user (DDD + CQRS + Clean Architecture)',
//                 'POST /api/v3/users' => 'Create new user (DDD + CQRS + Clean Architecture)',
//                 'PUT /api/v3/users/{id}' => 'Update user (DDD + CQRS + Clean Architecture)',
//                 'DELETE /api/v3/users/{id}' => 'Delete user (DDD + CQRS + Clean Architecture)'
//             ]
//         ],
//         'features' => [
//             'domain_driven_design' => 'Value Objects, Entities, Aggregates, Domain Services',
//             'cqrs_implementation' => 'Command/Query Bus, Handlers, Separation of Concerns',
//             'clean_architecture' => 'Domain, Application, Infrastructure layers',
//             'enterprise_patterns' => 'Repository, DTO, Service patterns',
//             'domain_events' => 'Event sourcing ready (placeholder implementation)',
//             'validation' => 'Domain-level validation with Value Objects'
//         ]
//     ]);
// });
