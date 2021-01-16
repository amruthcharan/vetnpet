<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    //

    protected $fillable = ['name', 'address', 'mobile', 'email', 'created_by', 'updated_by'];

    public function patient(){
        return $this->hasMany('App\Patient');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }


}
