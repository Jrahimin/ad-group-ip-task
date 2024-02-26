<?php

namespace App\Repositories;

use App\Contracts\Repositories\IpRepositoryInterface;
use App\Enums\CacheKeys;
use App\Http\Requests\Api\IpAddRequest;
use App\Http\Requests\Api\IpUpdateRequest;
use App\Models\Ip;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

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
        return Cache::remember(CacheKeys::IP_LIST_KEY, 60, function () {
            return $this->ipModel->newModelQuery()
                                 ->latest()
                                 ->get();
        });
    }

    /**
     * @param IpAddRequest $request
     *
     * @return Ip|null
     */
    public function add(IpAddRequest $request): ?Ip
    {
        return $this->ipModel->newModelQuery()
                             ->create($request->only('ip_address', 'label'));
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