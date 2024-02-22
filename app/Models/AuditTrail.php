<?php

namespace App\Models;

use App\Enums\AuditTrailActions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuditTrail extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $appends = ['action_type_label'];

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return MorphTo
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return string
     */
    public function getActionTypeLabelAttribute(): string
    {
        switch ($this->attributes['action_type']) {
            case AuditTrailActions::LOGIN:
                return 'Login';
            case AuditTrailActions::IP_ADD:
                return 'IP Add';
            case AuditTrailActions::IP_EDIT:
                return 'IP Edit';
            default:
                return 'n/a';
        }
    }
}
