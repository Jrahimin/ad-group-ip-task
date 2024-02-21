<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @param string $email
     *
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
