<?php

namespace App\Repositories;

use App\Contracts\Repositories\IpRepositoryInterface;
use App\Http\Requests\Api\IpAddRequest;
use App\Http\Requests\Api\IpUpdateRequest;
use App\Models\Ip;
use Illuminate\Support\Collection;

class IpRepository implements IpRepositoryInterface
{
    protected Ip $ipModel;

    public function __construct(Ip $ipModel)
    {
        $this->ipModel = $ipModel;
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->ipModel->newModelQuery()
                             ->latest()
                             ->get();
    }

    /**
     * @param IpAddRequest $request
     *
     * @return Ip|null
     */
    public function add(IpAddRequest $request): ?Ip
    {
        return $this->ipModel->create($request->only('ip_address', 'label'));
    }

    /**
     * @param IpUpdateRequest $request
     * @param Ip              $ip
     *
     * @return void
     */
    public function update(IpUpdateRequest $request, Ip $ip): void
    {
        $ip->update([
            'label' => $request->label
        ]);
    }
}