<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\RegisterRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RegisterRepository implements RegisterRepositoryInterface
{

    public function register($data): JsonResponse
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);
            if (empty($user)){
                throw new Exception('Could not create user');
            }
            return response()->json([
                'status' => ResponseAlias::HTTP_OK,
                'statusText' => 'Succeed',
                'data' => $user,
                'message' => 'Register successful'
            ]);
        } catch (Exception $exception){
            return response()->json([
                'status' => ResponseAlias::HTTP_BAD_REQUEST,
                'statusText' => 'Failed',
                'errors' => $exception->getMessage()
            ]);
        }
    }
}
