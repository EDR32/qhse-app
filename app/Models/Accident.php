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
        'employee_payroll_id',
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
        'penyebab_dasar',
        'penjelasan_penyebab_dasar',
        'penyebab_langsung',
        'kondisi_tidak_aman',
        'kesimpulan',
    ];

    protected $casts = [
        'accident_date' => 'date',
        'financial_loss' => 'decimal:2',
        'injured_body_parts' => 'array',
        'accident_types' => 'array',
    ];

    public function getUserAttribute()
    {
        // Caching sederhana agar tidak query berulang kali
        if (!array_key_exists('user_data', $this->attributes)) {
            $this->attributes['user_data'] = app(\App\Services\UserService::class)->findById($this->user_id);
        }
        return $this->attributes['user_data'];
    }

    public function rca(): HasOne
    {
        return $this->hasOne(RootCauseAnalysis::class);
    }
}
