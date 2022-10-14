<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Donor;
class Blood extends Model
{
    protected $Table = 'blood';
    protected $fillable = ['id', 'blood_group', 'amount'];

    public $timestamps = false;



    public function order()
    {
        return $this->hasMany('App\Models\Order', 'blood_id', 'id');
        // return $this->hasMany('Donor::class');
    }
}
