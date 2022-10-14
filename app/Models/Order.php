<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['id', 'name', 'id_num', 'phone', 'order_status', 'date', 'blood_id', 'user_id', 'created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];
    public $timestamp = false;


    public function blood()
    {
        return $this->belongsTo('App\Models\Blood', 'blood_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'order_id', 'id');
    }

    public function donor()
    {
        return $this->hasMany('App\Models\Donor', 'order_id', 'id');
    }

    public function benifet()
    {

        return $this->hasMany('App\Models\Benifet', 'order_id', 'id');
    }



    public function exemption()
    {
        return $this->hasMany('App\Models\Exemption', 'order_id', 'id');
    }
}
