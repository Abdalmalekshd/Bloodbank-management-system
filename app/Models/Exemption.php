<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exemption extends Model
{
    protected $fillable=['id','reason_for_don','reason_for_exe','order_id'];
    protected $hidden=['created_at','updated_at'];
    public $timestamp=false;

    public function order(){
        return $this -> belongsTo('App\Models\Order','order_id','id');
    }
}
