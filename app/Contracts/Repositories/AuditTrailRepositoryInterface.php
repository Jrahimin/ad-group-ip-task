<?php

namespace App\Contracts\Repositories;

use App\Enums\AuditTrailActions;
use App\Models\Ip;
use App\Models\User;
use Illuminate\Support\Collection;

interface AuditTrailRepositoryInterface
{
    /**
     * @param Ip|User    $auditObj
     * @param int        $auditAction
     * @param array|null $extraData
     *
     * @return void
     */
    public function add(User|Ip $auditObj, int $auditAction = AuditTrailActions::IP_ADD, ?array $extraData = []): void;

    /**
     * @return Collection
     */
    public function getAll(): Collection;
}