<?php

namespace App\Http\Controllers\Gp;

use App\Http\Controllers\Controller;
use App\Models\Benifet;
use App\Models\Blood;
use App\Models\Donor;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{

    ###Get Home page###
    public function home()
    {
        return view('interfaces/home');
    }


    public function getallbloods()
    {
        $blood = Blood::Select('blood_group', 'amount')->get();
        $don = Donor::with('order')->whereHas('order', function ($q) {
            $q->where('order_status', 1);
        })->count('id');
        // $ben = Benifet::count('id');
        $ben = Benifet::with('order')->whereHas('order', function ($q) {
            $q->where('order_status', 1);
        })->count('id');


        $currentTime = Carbon::today();
        $now = Carbon::now()->toDateString();

        $todayben = Order::with('benifet')->whereHas('benifet')->where('date', 'like', '%' . $now . '%')->where('order_status', 1)->count('id');


        $todaydon = Order::with('donor')->whereHas('donor')->where('date', 'like', '%' . $now . '%')->where('order_status', 1)->count('id');
        // return $now;
        return view('interfaces/home', compact('blood', 'don', 'ben', 'todaydon', 'todayben'));
    }
}
