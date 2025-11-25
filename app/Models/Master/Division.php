<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $connection = 'pgsql_master';
    protected $table = 'm_division';
    protected $primaryKey = 'div_code';
    public $incrementing = false;
    protected $keyType = 'string';
}
