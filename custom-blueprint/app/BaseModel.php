<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $user = Auth::user();
            if (is_null($user)){

            }
            else{
                $model->created_by = $user->id;
                $model->updated_by = $user->id;
                
            }

        });

        static::updating(function ($model) {

            $user = Auth::user();
            if (is_null($user)){

            }
            else{
                $model->updated_by = $user->id;
            }
        });

        static::deleting(function ($model) {
            $user = Auth::user();
            if (is_null($user)){

            }
            else{
                $model->deleted_by = $user->id;
                $model->is_deleted = 1;
                $model->save();
            }

        });
    }
}
