<?php

namespace App\Observers;

use App\Contracts\Repositories\AuditTrailRepositoryInterface;
use App\Enums\AuditTrailActions;
use App\Models\Ip;

class IpObserver
{
    protected AuditTrailRepositoryInterface $auditTrailRepository;

    public function __construct(AuditTrailRepositoryInterface $auditTrailRepository)
    {
        $this->auditTrailRepository = $auditTrailRepository;
    }

    /**
     * Handle the Ip "created" event.
     *
     * @param Ip $ip
     *
     * @return void
     */
    public function created(Ip $ip): void
    {
        $extraData = ['new_label' => $ip->label];

        $this->auditTrailRepository->add($ip, AuditTrailActions::IP_ADD, $extraData);
    }

    /**
     * Handle the Ip "updated" event.
     *
     * @param Ip $ip
     *
     * @return void
     */
    public function updated(Ip $ip): void
    {
        $extraData = [
            'old_label' => $ip->getOriginal('label'),
            'new_label' => $ip->label
        ];

        $this->auditTrailRepository->add($ip, AuditTrailActions::IP_EDIT, $extraData);
    }
}
