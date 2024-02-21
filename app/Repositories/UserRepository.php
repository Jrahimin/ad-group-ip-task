<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * @param string $email
     *
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User
    {
        return $this->userModel->newModelQuery()
            ->where('email', $email)
            ->first();
    }
}
