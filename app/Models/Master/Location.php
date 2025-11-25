<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $connection = 'pgsql_master';
    protected $table = 'm_lokasi';
    protected $primaryKey = 'loc_code';
    public $incrementing = false;
    protected $keyType = 'string';
}
