<?php

namespace App\Http\Controllers\Gp;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Blood;
use App\Models\Donor;
use App\Models\Benifet;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{


    public function login()
    {
        return view('interfaces/login');
    }

    public function check(LoginRequest $req)
    {

        $users = User::where([
            ['email', '=', $req->Email],
            ['password', '=', sha1($req->Password)],

        ])->get();

        if (count($users) > 0) {


            session(['user_id' => $users[0]->id]);
            $bloods = Blood::select()->get();

            return view('interfaces/Userhome', compact('bloods'));
        }
        //  elseif ($admin = User::select('email', 'password')->where([
        //     ['email', '=', $req->Email],
        //     ['password', '=', $req->Password],
        //     ['type', '=', 0]

        // ])->exists()) {

        //     $blood = Blood::select()->get();
        //     $don = Donor::with('order')->whereHas('order', function ($q) {
        //         $q->where('order_status', 1);
        //     })->count('id');
        //     // $ben = Benifet::count('id');
        //     $ben = Benifet::with('order')->whereHas('order', function ($q) {
        //         $q->where('order_status', 1);
        //     })->count('id');


        //     $currentTime = Carbon::today();
        //     $now = Carbon::now()->toDateString();

        //     $todayben = Order::with('benifet')->whereHas('benifet')->where('date', 'like', '%' . $now . '%')->where('order_status', 1)->count('id');


        //     $todaydon = Order::with('donor')->whereHas('donor')->where('date', 'like', '%' . $now . '%')->where('order_status', 1)->count('id');

        //     return view('interfaces/home', compact('blood', 'don', 'ben', 'todaydon', 'todayben'));
        // } else {
        //     return redirect()->back()->with(['error' => 'Email address does not exist']);
        // }
    }


    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('bloodbank/login');
    }
}
