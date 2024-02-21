<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Ip extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $fillable = ['ip_address', 'label'];

    /**
     * @return MorphMany
     */
    public function auditTrails(): MorphMany
    {
        return $this->morphMany(AuditTrail::class, 'auditable');
    }
}
