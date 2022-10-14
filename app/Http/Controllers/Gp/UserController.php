<?php

namespace App\Http\Controllers\Gp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BenifetRequest;
use App\Http\Requests\DonorRequest;
use App\Http\Requests\ExemptionRequest;
use App\Models\Benifet;
use App\Models\Blood;
use App\Models\Donor;
use App\Models\Exemption;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\User;
use Faker\Core\Number;
use Illuminate\Support\Facades\Date;
use PhpParser\Node\Expr\BinaryOp\NotEqual;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function user()
    {
        $bloods = Blood::select()->get();

        return view('interfaces/Userhome', compact('bloods'));
    }

    // add donotion request
    public function adddon(DonorRequest $req)
    {

        $blo = Order::with('Donor')->whereHas('Donor')->where("id_num", $req->id_num)->max('date');
        $blo1 = Carbon::parse(Order::with('Donor')->whereHas('Donor')->where("id_num", $req->id_num)->max('date'))->addMonths(3);
        $bl = $blo1->diffInMonths($blo);
        if ($bl != 3) {

            $order = Order::create($req->all());
            $order->user_id = session('user_id');


            $maxDate = Order::with('donor')->whereHas('donor')->max('date');

            if ($maxDate) {
                $maxDate = Carbon::parse(Order::with('donor')->whereHas('donor')->max('date'));
                $dateNow = Date::now();

                if ($dateNow->day > $maxDate->day && ($dateNow->month >= $maxDate->month))
                    $maxDate = $dateNow;

                if ($maxDate->hour >= 14) {
                    $maxDate = $maxDate->addDays(1);
                    $maxDate->setHours(8);
                    $maxDate->setMinutes(0);
                    $maxDate->setSeconds(0);
                } else {
                    $maxDate =  $maxDate->addMinutes(15);
                }
            } else {
                $maxDate = Date::now();
                if ($maxDate->hour > 14) {
                    $maxDate =  $maxDate->addDay(1);
                }
                $maxDate->setHours(8);
                $maxDate->setMinutes(0);
                $maxDate->setSeconds(0);
            }
            $order->date = $maxDate;

            $order->save();


            $donor = new Donor();
            $donor->don_amount = $req->amount;
            $donor->reason = $req->reason;
            $donor->order_id = $order->id;
            $donor->save();


            return  date('d/m/Y , H:i', strtotime($maxDate));
        } else {
            return 1;
        }
    }

    // add benifet request
    public function addben(BenifetRequest $req)
    {

        if (Blood::select('amount')->where('id', $req->blood_id)->first()->amount < number_format($req->required_amount)) {
            //blood_group==A-

            if (Blood::select('blood_group')->where('id', $req->blood_id)->first()->blood_group == 'A-') {
                // return $blod = Blood::select('id')->where('blood_group', 'O-')->first()->id;

                $order = Order::create($req->all());
                return
                    $order->user_id = session('user_id');
                if (Blood::select('amount')->where('blood_group', 'O-')->first()->amount > number_format($req->required_amount)) {
                    $blod = Blood::select('id')->where('blood_group', 'O-')->first()->id;
                    $order->blood_id = $blod;
                } else {
                    return response()->json('error', 'required amount is not available');
                }
                $maxDate = Order::with('benifet')->whereHas('benifet')->max('date');
                if ($maxDate) {
                    $maxDate = Carbon::parse(Order::with('benifet')->whereHas('benifet')->max('date'));
                    $dateNow = Date::now();

                    if ($dateNow->day > $maxDate->day && ($dateNow->month >= $maxDate->month))
                        $maxDate = $dateNow;

                    if ($maxDate->hour >= 14) {
                        $maxDate = $maxDate->addDays(1);
                        $maxDate->setHours(8);
                        $maxDate->setMinutes(0);
                        $maxDate->setSeconds(0);
                    } else {
                        $maxDate =  $maxDate->addMinutes(15);
                    }
                } else {
                    $maxDate = Date::now();
                    if ($maxDate->hour > 14) {
                        $maxDate =  $maxDate->addDay(1);
                    }
                    $maxDate->setHours(8);
                    $maxDate->setMinutes(0);
                    $maxDate->setSeconds(0);
                }
                $order->date = $maxDate;

                $order->save();

                $ben = new Benifet();

                $ben->recipient_name = $req->recipient_name;
                $ben->required_amount = $req->required_amount;
                $ben->order_id = $order->id;
                $ben->save();

                return  date('d/m/Y , H:i', strtotime($maxDate));
            }
            //blood_group==Ab+
            elseif (Blood::select('blood_group')->where('id', $req->blood_id)->first()->blood_group == 'Ab+') {

                $order = Order::create($req->all());
                $order->user_id = session('user_id');

                if (Blood::select('amount')->where('blood_group', 'O-')->first()->amount > number_format($req->required_amount)) {
                    $blod = Blood::select('id')->where('blood_group', 'O-')->first()->id;
                    $order->blood_id = $blod;
                } elseif (Blood::select('amount')->where('blood_group', 'A+')->first()->amount > number_format($req->required_amount)) {
                    $blod = Blood::select('id')->where('blood_group', 'A+')->first()->id;
                    $order->blood_id = $blod;
                } elseif (Blood::select('amount')->where('blood_group', 'A-')->first()->amount > number_format($req->required_amount)) {
                    $blod = Blood::select('id')->where('blood_group', 'A-')->first()->id;
                    $order->blood_id = $blod;
                } elseif (Blood::select('amount')->where('blood_group', 'O+')->first()->amount > number_format($req->required_amount)) {
                    $blod = Blood::select('id')->where('blood_group', 'O+')->first()->id;
                    $order->blood_id = $blod;
                } elseif (Blood::select('amount')->where('blood_group', 'AB-')->first()->amount > number_format($req->required_amount)) {
                    $blod = Blood::select('id')->where('blood_group', 'AB-')->first()->id;
                    $order->blood_id = $blod;
                } elseif (Blood::select('amount')->where('blood_group', 'B-')->first()->amount > number_format($req->required_amount)) {
                    $blod = Blood::select('id')->where('blood_group', 'B-')->first()->id;
                    $order->blood_id = $blod;
                } elseif (Blood::select('amount')->where('blood_group', 'B+')->first()->amount > number_format($req->required_amount)) {
                    $blod = Blood::select('id')->where('blood_group', 'B+')->first()->id;
                    $order->blood_id = $blod;
                } else {
                    return response()->json('error', 'required amount is not available');
                }
                $maxDate = Order::with('benifet')->whereHas('benifet')->max('date');
                if ($maxDate) {
                    $maxDate = Carbon::parse(Order::with('benifet')->whereHas('benifet')->max('date'));
                    $dateNow = Date::now();

                    if ($dateNow->day > $maxDate->day && ($dateNow->month >= $maxDate->month))
                        $maxDate = $dateNow;

                    if ($maxDate->hour >= 14) {
                        $maxDate = $maxDate->addDays(1);
                        $maxDate->setHours(8);
                        $maxDate->setMinutes(0);
                        $maxDate->setSeconds(0);
                    } else {
                        $maxDate =  $maxDate->addMinutes(15);
                    }
                } else {
                    $maxDate = Date::now();
                    if ($maxDate->hour > 14) {
                        $maxDate =  $maxDate->addDay(1);
                    }
                    $maxDate->setHours(8);
                    $maxDate->setMinutes(0);
                    $maxDate->setSeconds(0);
                }
                $order->date = $maxDate;

                $order->save();

                $ben = new Benifet();

                $ben->recipient_name = $req->recipient_name;
                $ben->required_amount = $req->required_amount;
                $ben->order_id = $order->id;
                $ben->save();

                return  date('d/m/Y , H:i', strtotime($maxDate));
            } //blood_group==Ab-
            elseif (Blood::select('blood_group')->where('id', $req->blood_id)->first()->blood_group == 'Ab-') {
                $order = Order::create($req->all());
                $order->user_id = session('user_id');

                if (Blood::select('amount')->where('blood_group', 'O-')->first()->amount > number_format($req->required_amount)) {

                    $blod = Blood::select('id')->where('blood_group', 'O-')->first()->id;
                    $order->blood_id = $blod;
                } elseif (Blood::select('amount')->where('blood_group', 'A-')->first()->amount > number_format($req->required_amount)) {
                    $blod = Blood::select('id')->where('blood_group', 'A-')->first()->id;
                    $order->blood_id = $blod;
                } elseif (Blood::select('amount')->where('blood_group', 'B-')->first()->amount > number_format($req->required_amount)) {
                    $blod = Blood::select('id')->where('blood_group', 'B-')->first()->id;
                    $order->blood_id = $blod;
                } else {
                    return response()->json('error', 'required amount is not available');
                }
                $maxDate = Order::with('benifet')->whereHas('benifet')->max('date');
                if ($maxDate) {
                    $maxDate = Carbon::parse(Order::with('benifet')->whereHas('benifet')->max('date'));
                    $dateNow = Date::now();

                    if ($dateNow->day > $maxDate->day && ($dateNow->month >= $maxDate->month))
                        $maxDate = $dateNow;

                    if ($maxDate->hour >= 14) {
                        $maxDate = $maxDate->addDays(1);
                        $maxDate->setHours(8);
                        $maxDate->setMinutes(0);
                        $maxDate->setSeconds(0);
                    } else {
                        $maxDate =  $maxDate->addMinutes(15);
                    }
                } else {
                    $maxDate = Date::now();
                    if ($maxDate->hour > 14) {
                        $maxDate =  $maxDate->addDay(1);
                    }
                    $maxDate->setHours(8);
                    $maxDate->setMinutes(0);
                    $maxDate->setSeconds(0);
                }
                $order->date = $maxDate;

                $order->save();

                $ben = new Benifet();

                $ben->recipient_name = $req->recipient_name;
                $ben->required_amount = $req->required_amount;
                $ben->order_id = $order->id;
                $ben->save();

                return  date('d/m/Y , H:i', strtotime($maxDate));
            }
            //blood_group==B-
            elseif (Blood::select('blood_group')->where('id', $req->blood_id)->first()->blood_group == 'B-') {

                $order = Order::create($req->all());
                $order->user_id = session('user_id');

                if (Blood::select('amount')->where('blood_group', 'O-')->first()->amount > number_format($req->required_amount)) {
                    $blod = Blood::select('id')->where('blood_group', 'O-')->first()->id;
                    $order->blood_id = $blod;
                } else {
                    return response()->json('error', 'required amount is not available');
                }
                $maxDate = Order::with('benifet')->whereHas('benifet')->max('date');
                if ($maxDate) {
                    $maxDate = Carbon::parse(Order::with('benifet')->whereHas('benifet')->max('date'));
                    $dateNow = Date::now();

                    if ($dateNow->day > $maxDate->day && ($dateNow->month >= $maxDate->month))
                        $maxDate = $dateNow;

                    if ($maxDate->hour >= 14) {
                        $maxDate = $maxDate->addDays(1);
                        $maxDate->setHours(8);
                        $maxDate->setMinutes(0);
                        $maxDate->setSeconds(0);
                    } else {
                        $maxDate =  $maxDate->addMinutes(15);
                    }
                } else {
                    $maxDate = Date::now();
                    if ($maxDate->hour > 14) {
                        $maxDate =  $maxDate->addDay(1);
                    }
                    $maxDate->setHours(8);
                    $maxDate->setMinutes(0);
                    $maxDate->setSeconds(0);
                }
                $order->date = $maxDate;

                $order->save();

                $ben = new Benifet();

                $ben->recipient_name = $req->recipient_name;
                $ben->required_amount = $req->required_amount;
                $ben->order_id = $order->id;
                $ben->save();

                return  date('d/m/Y , H:i', strtotime($maxDate));
            } //blood_group==O-
            elseif (Blood::select('blood_group')->where('id', $req->blood_id)->first()->blood_group == 'O-') {

                $order = Order::create($req->all());
                $order->user_id = session('user_id');

                if (Blood::select('amount')->where('blood_group', 'O-')->first()->amount < number_format($req->required_amount)) {
                    return response()->json('error', 'required amount is not available');
                }
                $maxDate = Order::with('benifet')->whereHas('benifet')->max('date');
                if ($maxDate) {
                    $maxDate = Carbon::parse(Order::with('benifet')->whereHas('benifet')->max('date'));
                    $dateNow = Date::now();

                    if ($dateNow->day > $maxDate->day && ($dateNow->month >= $maxDate->month))
                        $maxDate = $dateNow;

                    if ($maxDate->hour >= 14) {
                        $maxDate = $maxDate->addDays(1);
                        $maxDate->setHours(8);
                        $maxDate->setMinutes(0);
                        $maxDate->setSeconds(0);
                    } else {
                        $maxDate =  $maxDate->addMinutes(15);
                    }
                } else {
                    $maxDate = Date::now();
                    if ($maxDate->hour > 14) {
                        $maxDate =  $maxDate->addDay(1);
                    }
                    $maxDate->setHours(8);
                    $maxDate->setMinutes(0);
                    $maxDate->setSeconds(0);
                }
                $order->date = $maxDate;

                $order->save();

                $ben = new Benifet();

                $ben->recipient_name = $req->recipient_name;
                $ben->required_amount = $req->required_amount;
                $ben->order_id = $order->id;
                $ben->save();

                return  date('d/m/Y , H:i', strtotime($maxDate));
            } //blood_group==B+
            elseif (Blood::select('blood_group')->where('id', $req->blood_id)->first()->blood_group == 'B+') {

                $order = Order::create($req->all());
                $order->user_id = session('user_id');

                if (Blood::select('amount')->where('blood_group', 'O-')->first()->amount > number_format($req->required_amount)) {

                    $blod = Blood::select('id')->where('blood_group', 'O-')->first()->id;
                    $order->blood_id = $blod;
                } elseif (Blood::select('amount')->where('blood_group', 'O+')->first()->amount > number_format($req->required_amount)) {
                    $blod = Blood::select('id')->where('blood_group', 'O+')->first()->id;
                    $order->blood_id = $blod;
                } elseif (Blood::select('amount')->where('blood_group', 'B-')->first()->amount > number_format($req->required_amount)) {
                    $blod = Blood::select('id')->where('blood_group', 'B-')->first()->id;
                    $order->blood_id = $blod;
                } else {
                    return response()->json('error', 'required amount is not available');
                }
                $maxDate = Order::with('benifet')->whereHas('benifet')->max('date');
                if ($maxDate) {
                    $maxDate = Carbon::parse(Order::with('benifet')->whereHas('benifet')->max('date'));
                    $dateNow = Date::now();

                    if ($dateNow->day > $maxDate->day && ($dateNow->month >= $maxDate->month))
                        $maxDate = $dateNow;

                    if ($maxDate->hour >= 14) {
                        $maxDate = $maxDate->addDays(1);
                        $maxDate->setHours(8);
                        $maxDate->setMinutes(0);
                        $maxDate->setSeconds(0);
                    } else {
                        $maxDate =  $maxDate->addMinutes(15);
                    }
                } else {
                    $maxDate = Date::now();
                    if ($maxDate->hour > 14) {
                        $maxDate =  $maxDate->addDay(1);
                    }
                    $maxDate->setHours(8);
                    $maxDate->setMinutes(0);
                    $maxDate->setSeconds(0);
                }
                $order->date = $maxDate;

                $order->save();

                $ben = new Benifet();

                $ben->recipient_name = $req->recipient_name;
                $ben->required_amount = $req->required_amount;
                $ben->order_id = $order->id;
                $ben->save();

                return  date('d/m/Y , H:i', strtotime($maxDate));
            }
        } elseif (Blood::select('amount')->where('id', $req->blood_id)->first()->amount > number_format($req->required_amount)) {
            $order = Order::create($req->all());
            $order->user_id = session('user_id');

            $maxDate = Order::with('benifet')->whereHas('benifet')->max('date');
            if ($maxDate) {
                $maxDate = Carbon::parse(Order::with('benifet')->whereHas('benifet')->max('date'));
                $dateNow = Date::now();

                if ($dateNow->day > $maxDate->day && ($dateNow->month >= $maxDate->month))
                    $maxDate = $dateNow;

                if ($maxDate->hour >= 14) {
                    $maxDate = $maxDate->addDays(1);
                    $maxDate->setHours(8);
                    $maxDate->setMinutes(0);
                    $maxDate->setSeconds(0);
                } else {
                    $maxDate =  $maxDate->addMinutes(15);
                }
            } else {
                $maxDate = Date::now();
                if ($maxDate->hour > 14) {
                    $maxDate =  $maxDate->addDay(1);
                }
                $maxDate->setHours(8);
                $maxDate->setMinutes(0);
                $maxDate->setSeconds(0);
            }
            $order->date = $maxDate;

            $order->save();

            $ben = new Benifet();

            $ben->recipient_name = $req->recipient_name;
            $ben->required_amount = $req->required_amount;
            $ben->order_id = $order->id;
            $ben->save();

            return  date('d/m/Y , H:i', strtotime($maxDate));
        } elseif (Blood::select('amount')->where('id', $req->blood_id)->first()->amount < number_format($req->required_amount)) {
            return response()->json('error', 'required amount is not available');
        }
    }

    // add exemption request
    public function addexem(ExemptionRequest $req)
    {

        $order = Order::create($req->all());
        $order->user_id = session('user_id');

        $maxDate = Order::with('exemption')->whereHas('exemption')->max('date');
        if ($maxDate) {
            $maxDate = Carbon::parse(Order::with('exemption')->whereHas('exemption')->max('date'));
            $dateNow = Date::now();

            if ($dateNow->day > $maxDate->day && ($dateNow->month >= $maxDate->month))
                $maxDate = $dateNow;

            if ($maxDate->hour >= 14) {
                $maxDate = $maxDate->addDays(1);
                $maxDate->setHours(8);
                $maxDate->setMinutes(0);
                $maxDate->setSeconds(0);
            } else {
                $maxDate =  $maxDate->addMinutes(15);
            }
        } else {
            $maxDate = Date::now();
            if ($maxDate->hour > 14) {
                $maxDate =  $maxDate->addDay(1);
            }
            $maxDate->setHours(8);
            $maxDate->setMinutes(0);
            $maxDate->setSeconds(0);
        }
        $order->date = $maxDate;
        $order->save();


        $exem = new Exemption();

        $exem->reason_for_don = $req->reason_for_don;
        $exem->reason_for_exe = $req->reason_for_exe;
        $exem->order_id = $order->id;
        $exem->save();

        return  date('d/m/Y , H:i', strtotime($maxDate));
    }
}
