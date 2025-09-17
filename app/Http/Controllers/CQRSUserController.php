<?php

namespace App\Http\Controllers;

use App\Domain\User\Commands\CreateUserCommand;
use App\Domain\User\Commands\DeleteUserCommand;
use App\Domain\User\Commands\UpdateUserCommand;
use App\Domain\User\Queries\GetUserQuery;
use App\Domain\User\Queries\ListUsersQuery;
use App\Infrastructure\Bus\CommandBus;
use App\Infrastructure\Bus\QueryBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CQRSUserController extends Controller
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly QueryBus $queryBus
    ) {}

    public function index(): JsonResponse
    {
        $users = $this->queryBus->dispatch(new ListUsersQuery());
        
        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->queryBus->dispatch(new GetUserQuery($id));

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ]
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $command = new CreateUserCommand(
                name: $validated['name'],
                email: $validated['email'],
                password: $validated['password']
            );

            $user = $this->commandBus->dispatch($command);

            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at
                ]
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
                'password' => 'sometimes|required|string|min:8',
            ]);

            $command = new UpdateUserCommand(
                id: $id,
                name: $validated['name'] ?? null,
                email: $validated['email'] ?? null,
                password: $validated['password'] ?? null
            );

            $user = $this->commandBus->dispatch($command);

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'updated_at' => $user->updated_at
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        $command = new DeleteUserCommand($id);
        $deleted = $this->commandBus->dispatch($command);

        if (!$deleted) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully'
        ]);
    }
}