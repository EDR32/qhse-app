<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoringEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_monthly_report_id',
        'event_date',
        'event_time',
        'week_of_month',
        'location',
        'description',
        'user_id',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function unitMonthlyReport(): BelongsTo
    {
        return $this->belongsTo(UnitMonthlyReport::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
