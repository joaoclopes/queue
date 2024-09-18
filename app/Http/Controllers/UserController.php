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

    public function index()
    {
        $users = $this->userService->getAll();
        return view('users.index', compact('users'));
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

            return redirect()->route('users.index');
        } catch(CustomException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro criar o usuario, tente novamente mais tarde! Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
