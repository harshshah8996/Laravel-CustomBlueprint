<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\BaseModel;

class Role extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'created_at', 'created_by',
        'updated_at', 'updated_by',
        'deleted_at', 'deleted_by', 'is_deleted',
    ];

    public static function boot()
    {
        parent::boot();
    }
}
