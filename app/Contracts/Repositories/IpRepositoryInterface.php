<?php

namespace App\Contracts\Repositories;

use App\Http\Requests\Api\IpAddRequest;
use App\Http\Requests\Api\IpUpdateRequest;
use App\Models\Ip;
use Illuminate\Support\Collection;

interface IpRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllIps(): Collection;

    public function add(IpAddRequest $request): ?Ip;

    public function update(IpUpdateRequest $request, Ip $ip): void;
}