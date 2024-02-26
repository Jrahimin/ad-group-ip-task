<?php

namespace App\Repositories;

use App\Contracts\Repositories\AuditTrailRepositoryInterface;
use App\Enums\AuditTrailActions;
use App\Enums\CacheKeys;
use App\Models\AuditTrail;
use App\Models\Ip;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AuditTrailRepository implements AuditTrailRepositoryInterface
{
    protected AuditTrail $auditTrailModel;

    public function __construct(AuditTrail $ipModel)
    {
        $this->auditTrailModel = $ipModel;
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Cache::remember(CacheKeys::AUDIT_TRAIL_KEY, 60, function () {
            return $this->auditTrailModel->newModelQuery()
                                         ->with('auditable')
                                         ->latest()
                                         ->get();
        });
    }

    /**
     * @param Ip|User    $auditObj
     * @param int        $auditAction
     * @param array|null $extraData
     *
     * @return void
     */
    public function add(User|Ip $auditObj, int $auditAction = AuditTrailActions::IP_ADD, ?array $extraData = []): void
    {
        $data = array_merge($extraData, [
            'auditable_type' => get_class($auditObj),
            'auditable_id'   => $auditObj->id,
            'action_type'    => $auditAction,
        ]);

        try {
            $this->auditTrailModel->create($data);

            Cache::forget(CacheKeys::AUDIT_TRAIL_KEY);
        } catch (\Exception $e) {
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');
        }
    }
}