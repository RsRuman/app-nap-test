<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\RegisterRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    private RegisterRepositoryInterface $registerRepository;

    public function __construct(RegisterRepositoryInterface $registerRepository)
    {
        $this->registerRepository = $registerRepository;
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => ResponseAlias::HTTP_NOT_ACCEPTABLE,
                'statusText' => 'Failed',
                'errors' => $validator->getMessageBag()->getMessages()
            ]);
        }

        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')]))
        {
            $user = Auth::user();
            $token = $user->createToken('app-nap')->accessToken;
            $data = [
                'token' => $token,
                'user' => $user,
            ];
            return response()->json([
                'status' => ResponseAlias::HTTP_OK,
                'statusText' => 'Succeed',
                'data' => $data,
                'message' => 'Login successful'
            ]);
        }

        return response()->json([
            'status' => ResponseAlias::HTTP_BAD_REQUEST,
            'statusText' => 'Failed',
            'message' => 'Invalid credentials'
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:25',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8|max:25',
            'password_confirmation' => 'required|min:8|max:25'
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => ResponseAlias::HTTP_NOT_ACCEPTABLE,
                'statusText' => 'Failed',
                'errors' => $validator->getMessageBag()->getMessages()
            ]);
        }

        return $this->registerRepository->register($request);
    }
}
