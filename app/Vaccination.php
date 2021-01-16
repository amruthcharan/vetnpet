<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    protected $fillable = ['id', 'patient_id', 'vaccine_id', 'date', 'expiry'];

    protected $dates = ['date', 'expiry'];

    public function patient() {
        return $this->belongsTo('App\Patient');
    }

    public function vaccine(){
        return $this->belongsTo('App\Vaccine');
    }

}
