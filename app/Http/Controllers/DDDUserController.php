<?php

namespace App\Http\Controllers;

use App\Application\DTOs\CreateUserDTO;
use App\Application\DTOs\UpdateUserDTO;
use App\Application\Services\UserApplicationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DDDUserController extends Controller
{
    public function __construct(
        private readonly UserApplicationService $userApplicationService
    ) {}

    public function index(): JsonResponse
    {
        $users = $this->userApplicationService->getAllUsers();

        return response()->json([
            'status' => 'success',
            'message' => 'Users retrieved successfully',
            'data' => $users->map(fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ])
        ]);
    }

    public function show(int $id): JsonResponse
    {
        try {
            $userDTO = $this->userApplicationService->getUserById($id);

            if (!$userDTO) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User retrieved successfully',
                'data' => $userDTO->toArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while retrieving the user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $createUserDTO = CreateUserDTO::fromRequest($validated);
            $userDTO = $this->userApplicationService->createUser($createUserDTO);

            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully with DDD architecture',
                'data' => $userDTO->toArray()
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Domain validation failed',
                'error' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the user',
                'error' => $e->getMessage()
            ], 500);
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

            $updateUserDTO = UpdateUserDTO::fromRequest($id, $validated);
            $userDTO = $this->userApplicationService->updateUser($updateUserDTO);

            if (!$userDTO) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully with DDD architecture',
                'data' => $userDTO->toArray()
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Domain validation failed',
                'error' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->userApplicationService->deleteUser($id);

            if (!$deleted) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully with DDD architecture'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
