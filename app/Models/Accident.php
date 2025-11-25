<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Accident extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_name',
        'employee_age_group',
        'equipment_type',
        'location',
        'accident_date',
        'accident_time_range',
        'division',
        'description',
        'initial_action',
        'consequence',
        'financial_loss',
        'injured_body_parts',
        'accident_types',
        'lost_work_days',
        'photo_path',
    ];

    protected $casts = [
        'accident_date' => 'date',
        'financial_loss' => 'decimal:2',
        'injured_body_parts' => 'array',
        'accident_types' => 'array',
    ];

    public function getUserAttribute()
    {
        // Use a different, non-conflicting key for caching.
        if (!array_key_exists('user_relation_cache', $this->attributes)) {
            $this->attributes['user_relation_cache'] = app(\App\Services\UserService::class)->findById($this->user_id);
        }
        return $this->attributes['user_relation_cache'];
    }

    public function rca(): HasOne
    {
        return $this->hasOne(RootCauseAnalysis::class);
    }
}
