<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function store($data)
    {
        return $this->userRepository->store($data);
    }
}