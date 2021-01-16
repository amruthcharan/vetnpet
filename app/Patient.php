<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //
    protected $fillable = ['species_id','ownername', 'address', 'mobile', 'email', 'name', 'age', 'feeding_pattern', 'breed', 'created_by', 'updated_by', 'gender'];

    protected $dates = ['age'];

    public function species(){
        return $this->belongsTo('App\Species');
    }
    public function appointments(){
        return $this->hasMany('App\Appointment');
    }

    public function bills(){
        return $this->hasMany('App\Bill');
    }

    public function vaccinations(){
        return $this->hasMany('App\Vaccination');
    }

    public function package(){
        return $this->hasMany('App\HealthPackage');
    }


}
