<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Master\Karyawan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = 'pgsql_master';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['karyawan'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'payroll_id',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the employee record associated with the user.
     */
    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'payroll_id', 'payroll_id');
    }

    /**
     * Get the user's full name from the associated karyawan record.
     *
     * @return string
     */
    public function getNameAttribute($value)
    {
        // If karyawan relationship exists, use its name, otherwise fall back to the user's own name attribute.
        return $this->karyawan->nama_karyawan ?? $value;
    }
}
