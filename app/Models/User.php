<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable

{
    use HasFactory;
    protected $Table = 'users';
    protected $fillable = ['id', 'name', 'email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];
    public $timestamps = false;



    public function order()
    {
        return $this->hasMany('App\Models\Order', 'user_id', 'id');
    }
}
