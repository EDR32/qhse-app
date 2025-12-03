<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\UserService; // Important: Import the service

class CorrectiveActionReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'root_cause_analysis_id',
        'number',
        'source_of_information',
        'issued_by',
        'issued_date',
        'status',
        'management_notes',
        'mr_approved_by',
        'mr_approved_at',
        'director_approved_by',
        'director_approved_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'issued_date' => 'date',
        'mr_approved_at' => 'datetime',
        'director_approved_at' => 'datetime',
    ];

    /**
     * Get the root cause analysis associated with the report.
     */
    public function rootCauseAnalysis(): BelongsTo
    {
        return $this->belongsTo(RootCauseAnalysis::class);
    }

    /**
     * Get the actions associated with the report.
     */
    public function actions(): HasMany
    {
        return $this->hasMany(Action::class);
    }

    /**
     * Get the user who issued the report.
     */
    public function issuer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    /**
     * Get the user who approved as MR.
     */
    public function mrApprover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mr_approved_by');
    }

    /**
     * Get the user who approved as Director.
     */
    public function directorApprover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'director_approved_by');
    }
}