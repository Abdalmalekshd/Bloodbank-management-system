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
use App\Models\Admin;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminLoginController extends Controller
{


    public function login()
    {
        return view('interfaces/Adminlogin');
    }

    public function check(LoginRequest $req)
    {




        // $blood = Blood::select()->get();
        // $don = Donor::with('order')->whereHas('order', function ($q) {
        //     $q->where('order_status', 1);
        // })->count('id');
        // $ben = Benifet::count('id');
        //     $ben = Benifet::with('order')->whereHas('order', function ($q) {
        //         $q->where('order_status', 1);
        //     })->count('id');


        //     $currentTime = Carbon::today();
        //     $now = Carbon::now()->toDateString();

        //     $todayben = Order::with('benifet')->whereHas('benifet')->where('date', 'like', '%' . $now . '%')->where('order_status', 1)->count('id');


        //     $todaydon = Order::with('donor')->whereHas('donor')->where('date', 'like', '%' . $now . '%')->where('order_status', 1)->count('id');

        //     return view('interfaces/home', compact('blood', 'don', 'ben', 'todaydon', 'todayben'));
        // }


        if (Auth::guard('admin')->attempt(['Email' => $req->Email, 'password' => $req->Password])) {
            return redirect()->intended(route('admin'));
        }
        return redirect()->back()->withInput($req->only('email'));
    }
}
