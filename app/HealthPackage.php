<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HealthPackage extends Model
{
    protected $fillable = ['package_id','patient_id', 'date', 'expiry'];
    protected $dates = ['date', 'expiry'];

    public function patient(){
        return $this->belongsTo('App\Patient');
    }

    public function package(){
        return $this->belongsTo('App\Package');
    }
}
