<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use HasFactory;

    protected $connection = 'pgsql_master';
    protected $table = 'm_title';
    protected $primaryKey = 'title_code';
    public $incrementing = false;
    protected $keyType = 'string';
}
