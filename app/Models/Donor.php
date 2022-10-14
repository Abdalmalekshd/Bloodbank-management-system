<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    protected $fillable = ['id', 'don_amount', 'reason', 'order_id'];
    // protected $hidden=['created_at','updated_at'];
    public $timestamps = false;


    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }
}
