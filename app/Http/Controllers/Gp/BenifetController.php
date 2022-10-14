<?php

namespace App\Http\Controllers\Gp;

use App\Http\Controllers\Controller;
use App\Models\Benifet;
use App\Models\Order;
use App\Models\Blood;
use Illuminate\Http\Request;

class BenifetController extends Controller
{


    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    #### Get All Benifet Orders####
    public function getAllbenifetorders()
    {

        $orders = Benifet::with('order')->whereHas('order', function ($q) {
            $q->where('order_status', '=', 0);
        })->get();

        $bloods = Blood::select()->get();
        $benifet = null;
        return view('interfaces/req-benifet', compact('orders', 'bloods', 'benifet'));
    }

    ###Delete Button For benifet orders###

    public function DeleteBenfietorder($order_id)
    {
        Benifet::where('order_id', '=', $order_id)->delete();
        $order = Order::find($order_id);
        $order->delete();

        return redirect()->back()->with(['success' => 'deleted successfully']);
    }

    public function edit(Request $req)
    {
        $orders = Benifet::with('order')->whereHas('order', function ($q) {
            $q->where('order_status', '=', 0);
        })->get();

        $benifet = Benifet::with('order')->find($req->id);
        $bloods = Blood::select()->get();

        return view('interfaces/req-benifet', compact('benifet', 'bloods', 'orders'));
    }


    public function updatebenifet(Request $req)
    {
        $benifet = Benifet::find($req->id);

        $benifet->update([
            'recipient_name' => $req->rename,
            'required_amount' => $req->rq,
        ]);
        $benifet->save();

        $order = Order::find($benifet->order->id);

        $order->update([
            'name' => $req->name,
            'id_num' => $req->id_num,
            'phone' => $req->phone,
            'blood_id' => $req->blood_id,

        ]);

        return redirect()->route('reqbenifets');
    }











    ####Begin Approve Button in Benifet_order interface####
    public function approvebenifetorder($order_id)
    {

        $order = Order::find($order_id);

        $order->update([

            'order_status' => 1,
        ]);

        $donor = Benifet::where('order_id', '=', $order_id)->get()[0];

        $blod = Blood::find($order->blood_id);
        $blod->amount = $blod->amount - $donor->required_amount;
        $blod->save();




        return redirect()->back()->with(['success' => 'Order Approved']);
    }
    ####End Approve Button in donors-order interface####





    public function getAllbenifets()
    {
        $orders = Benifet::with('order')->whereHas('order', function ($q) {
            $q->where('order_status', '=', 1);
        })->paginate(6);
        $bloods = Blood::select()->get();
        return view('interfaces/benifetorder', compact('orders', 'bloods'));
    }
}
