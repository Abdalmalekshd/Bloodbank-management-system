<?php

namespace App\Http\Controllers\Gp;

use App\Http\Controllers\Controller;
use App\Models\Exemption;
use App\Models\Order;
use App\Models\Blood;

use Illuminate\Http\Request;

class ExemptionController extends Controller
{

    #### Get All Exemption Orders####
    public function getAllexemptionorders()
    {
        $orders = Exemption::with('order')->whereHas('order', function ($q) {
            $q->where('order_status', '=', 0);
        })->get();
        $exemption = null;
        $bloods = Blood::select()->get();

        return view('interfaces/request_exemp', compact('orders', 'exemption', 'bloods'));
    }


    ####End method

    ###Delete Button For Exemption orders###
    public function DeleteExemptionOrder($order_id)
    {

        Exemption::where('order_id', '=', $order_id)->delete();
        $order = Order::find($order_id);
        $order->delete();

        return redirect()->back()->with(['success' => 'deleted successfully']);
    }

    public function Edit(Request $req)
    {
        $orders = Exemption::with('order')->whereHas('order', function ($q) {
            $q->where('order_status', '=', 0);
        })->get();

        $exemption = Exemption::with('order')->find($req->id);
        $bloods = Blood::select()->get();

        return view('interfaces/request_exemp', compact('exemption', 'bloods', 'orders'));
    }

    public function updateexemption(Request $req)
    {
        $exemption = Exemption::find($req->id);

        $exemption->update([
            'reason_for_don' => $req->reason_for_don,
            'reason_for_exe' => $req->reason_for_exe,

        ]);
        $exemption->save();

        $order = Order::find($exemption->order->id);

        $order->update([
            'name' => $req->name,
            'id_num' => $req->id_num,
            'phone' => $req->phone,
            'blood_id' => $req->blood_id,

        ]);
        return redirect()->route('reqexemp');
    }


    ####Begin Approve Button in Exemotion-Order interface####
    public function approveExemotionOrder($order_id)
    {

        $order = Order::find($order_id);
        $order->update([

            'order_status' => 1,
        ]);


        return redirect()->back()->with(['success' => 'Order Approved']);
    }
    ####End Approve Button in Exemptions-Order interface####



    ####Get all Approved Orders Methods####
    public function getAllexemptions()
    {
        $orders = Exemption::with('order')->whereHas('order', function ($q) {
            $q->where('order_status', '=', 1);
        })->paginate(6);
        $bloods = Blood::select()->get();
        return view('interfaces/exemption', compact('orders', 'bloods'));
    }
    ####End Get all Approved Orders Methods####

}
