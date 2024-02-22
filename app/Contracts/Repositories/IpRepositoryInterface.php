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
    public function getAll(): Collection;

    /**
     * @param IpAddRequest $request
     *
     * @return Ip|null
     */
    public function add(IpAddRequest $request): ?Ip;

    /**
     * @param IpUpdateRequest $request
     * @param Ip              $ip
     *
     * @return void
     */
    public function update(IpUpdateRequest $request, Ip $ip): void;
}