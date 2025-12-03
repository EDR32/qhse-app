<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use App\Models\DriverPerformanceLog;

class Driver extends Model
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
        'karyawan_id',
        'driver_category',
        'sim_type',
        'sim_expiry_date',
        'status',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_drivers';

    /**
     * Get the karyawan record associated with the driver.
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'id');
    }

    /**
     * Get the performance logs for the driver.
     */
    public function performanceLogs()
    {
        return $this->hasMany(DriverPerformanceLog::class, 'driver_id', 'id');
    }
}
