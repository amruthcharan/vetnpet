<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicineDetails extends Model
{
    //
    protected $fillable = ['prescription_id', 'medicine_id', 'timing', 'duration'];

    public function medicine() {
        return $this->belongsTo('App\Medicine');
    }

    public function prescription(){
        return $this->belongsTo('App\Prescription');
    }
}
