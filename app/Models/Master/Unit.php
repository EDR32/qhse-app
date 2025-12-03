<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
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
    protected $table = 'm_unit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'no_unit',
        'jenis_unit',
        'kategori',
    ];

    /**
     * Scope a query to only include units matching a search term.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where('no_unit', 'like', '%' . $search . '%')
            ->orWhere('jenis_unit', 'like', '%' . $search . '%')
            ->orWhere('kategori', 'like', '%' . $search . '%');
    }
}
