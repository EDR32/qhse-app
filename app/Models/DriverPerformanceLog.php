<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Master\Driver;

class DriverPerformanceLog extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = 'pgsql_master';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'driver_id',
        'year',
        'month',
        'fatigue_count',
        'distraction_count',
        'fov_count',
        'rest_area_non_compliance_count',
        'prohibited_hours_violation_count',
        'accident_count',
        'general_violation_count',
        'monthly_score',
    ];

    /**
     * Get the driver associated with the performance log.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }
}
