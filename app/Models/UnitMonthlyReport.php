<?php

namespace App\Models;

use App\Models\Master\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnitMonthlyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'month',
        'year',
        'kilometer',
        'user_id',
    ];

    protected $casts = [
        'kilometer' => 'decimal:2',
    ];

    /**
     * Custom accessor to get the Unit model from the master database.
     */
    public function getUnitAttribute()
    {
        // Cache the result in a custom attribute to avoid repeated queries
        if (!array_key_exists('unit_relation_cache', $this->attributes)) {
            $this->attributes['unit_relation_cache'] = Unit::find($this->unit_id);
        }
        return $this->attributes['unit_relation_cache'];
    }

    public function user(): BelongsTo
    {
        // This relationship points to a table in another database.
        // It's defined here for convenience, but joins will require manual handling.
        // The actual user object will be fetched via accessor and UserService.
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function storingEvents(): HasMany
    {
        return $this->hasMany(StoringEvent::class);
    }
}
