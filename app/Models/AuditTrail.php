<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuditTrail extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

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
}
