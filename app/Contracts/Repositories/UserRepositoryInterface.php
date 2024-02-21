<?php

namespace App\Contracts\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * @param string $email
     *
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User;
}