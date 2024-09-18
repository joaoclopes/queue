<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function __construct()
    {
    }

    public function store($data)
    {
        return User::create($data);
    }

    public function getUserById($userId)
    {
        return User::find($userId);
    }

    public function getAll()
    {
        return User::all();
    }
}