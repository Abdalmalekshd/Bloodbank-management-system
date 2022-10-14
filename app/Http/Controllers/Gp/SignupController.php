<?php

namespace App\Http\Controllers\Gp;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Blood;
use  Illuminate\Validation\Validator;

use App\Models\User;

class SignupController extends Controller
{
    public function sign()
    {
        return view('interfaces/signup');
    }


    public function signup(UserRequest $req)
    {


        User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => sha1($req->password),
        ]);
        $bloods = Blood::select()->get();

        return view('interfaces/userhome', compact('bloods'));
    }
}
