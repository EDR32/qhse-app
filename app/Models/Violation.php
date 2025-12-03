<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'location',
        'violation_date',
        'description',
        'rule_broken',
    ];

    /**
     * Get the user that owns the violation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
