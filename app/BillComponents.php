<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillComponents extends Model
{
    //
    protected $fillable = ['bill_id', 'name', 'amount'];


    public function bill(){
        return $this->belongsTo('App\Bill');
    }
}
