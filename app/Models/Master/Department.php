<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $connection = 'pgsql_master';
    protected $table = 'm_dept';
    protected $primaryKey = 'dept_code';
    public $incrementing = false;
    protected $keyType = 'string';
}
