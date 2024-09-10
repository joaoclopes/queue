<?php

namespace App\Http\Controllers;

use App\Abstracts\CustomException;
use App\Http\Requests\User\StoreUserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $userData = $request->validated();
            if (!$userData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocorreu um erro criar o usuario, preencha os dados corretamente!'
                ], 400);
            }
            $this->userService->store($userData);

            return response()->json([
                'success' => true,
                'message' => 'O usuario foi criado com sucesso!',
            ], 200);
        } catch(CustomException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro criar o usuario, tente novamente mais tarde! Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
