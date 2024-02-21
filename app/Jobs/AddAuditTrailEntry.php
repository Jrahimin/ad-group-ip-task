<?php

namespace App\Jobs;

use App\Contracts\Repositories\AuditTrailRepositoryInterface;
use App\Models\Ip;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AddAuditTrailEntry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User|Ip $auditObj;
    protected int $auditAction;
    protected array|null $extraData;

    /**
     * Create a new job instance.
     *
     * @param User|Ip    $auditObj
     * @param int        $auditAction
     * @param array|null $extraData
     */
    public function __construct(User|Ip $auditObj, int $auditAction, ?array $extraData = [])
    {
        $this->auditObj    = $auditObj;
        $this->auditAction = $auditAction;
        $this->extraData   = $extraData;
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        app(AuditTrailRepositoryInterface::class)->add($this->auditObj, $this->auditAction, $this->extraData);
    }
}
