<?php

namespace App\Http\Controllers\Gp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donor;
use App\Models\Order;
use App\Models\Blood;
use Illuminate\Database\Eloquent\Model;

class DonorsController extends Controller
{


    #### Get All Donotion Orders####
    public function getAlldonororders(Request $req)
    {

        $orders = Donor::with('order')->whereHas('order', function ($q) {
            $q->where('order_status', '=', 0);
        })->get();

        $bloods = Blood::select()->get();
        $donor = null;
        $reasons = null;
        $doreason = Donor::with('order')->select('reason')->find($req->id);

        return view('interfaces/req-donotion', compact('orders', 'bloods', 'donor', 'doreason'));
    }




    ###Delete Button For Donotion orders###
    public function Deletedonorder($order_id)
    {
        Donor::where('order_id', '=', $order_id)->delete();
        $order = Order::find($order_id);
        $order->delete();


        return redirect()->back()->with(['success' => 'deleted successfully']);
    }


    ####Begin Update Button in donors-order interface####
    public function Edit(Request $req)
    {
        $orders = Donor::with('order')->whereHas('order', function ($q) {
            $q->where('order_status', '=', 0);
        })->get();

        $donor = Donor::with('order')->find($req->id);
        $doreason = Donor::with('order')->select('reason')->find($donor->id);
        $reasons = $doreason->reason;
        $bloods = Blood::select()->get();

        return view('interfaces/req-donotion', compact('donor', 'bloods', 'orders', 'reasons'));
    }

    public function updatedonor(Request $req)
    {
        $donor = Donor::find($req->id);

        $donor->update([
            'don_amount' => $req->don_amount,
            'reason' => $req->reason,

        ]);
        $donor->save();

        $order = Order::find($donor->order->id);

        $order->update([
            'name' => $req->name,
            'id_num' => $req->id_num,
            'phone' => $req->phone,
            'blood_id' => $req->blood_id,

        ]);
        return redirect()->route('reqdonationsorder');
    }


    ####Begin Approve Button in donors-order interface####
    public function approveorder($order_id)
    {

        $order = Order::find($order_id);

        $order->update([

            'order_status' => 1,
        ]);



        $donor = Donor::where('order_id', '=', $order_id)->get()[0];

        $blod = Blood::find($order->blood_id);
        $blod->amount = $blod->amount + $donor->don_amount;
        $blod->save();



        return redirect()->back()->with(['success' => 'Order Apporved ']);
    }
    ####End Approve Button in donors-order interface####









    public function getAlldonors()
    {
        $orders = Donor::with('order')->whereHas('order', function ($q) {
            $q->where('order_status', '=', 1);
        })->paginate(6);
        $bloods = Blood::select()->get();
        return view('interfaces/donotionorder', compact('orders', 'bloods'));
    }
}
