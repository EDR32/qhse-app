<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = 'pgsql_master';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_karyawan';

    /**
     * Get the user that owns the karyawan record.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'payroll_id', 'payroll_id');
    }

    /**
     * Get the title (jabatan) associated with the karyawan.
     */
    public function jabatan()
    {
        return $this->belongsTo(Title::class, 'title', 'title_code');
    }

    /**
     * Get the department associated with the karyawan.
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id', 'dept_code');
    }

    /**
     * Get the division associated with the karyawan.
     */
    public function division()
    {
        return $this->belongsTo(Division::class, 'div_id', 'div_code');
    }

    /**
     * Get the location associated with the karyawan.
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'lokasi', 'loc_code');
    }

    /**
     * Get the level associated with the karyawan.
     */
    public function levelRel()
    {
        return $this->belongsTo(Level::class, 'level', 'level_code');
    }
}