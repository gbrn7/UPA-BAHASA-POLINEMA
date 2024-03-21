<?php

namespace App\Http\Controllers;

use App\Models\DepartementModel;
use App\Models\EventModel;
use App\Models\ProdyModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(){


        $activeEvent = EventModel::where('status', true)
                        ->where('remaining_quota','!=', 0)
                        ->first();

        if (!isset($activeEvent)) {
            return view('client.landingPage');
        }

        $dateNow = Carbon::now();
        $registerEnd = Carbon::parse($activeEvent->register_end);

        if($dateNow->greaterThan($registerEnd)){

            $activeEvent->update(['status' => false]);

            return view('client.landingPage');
            
        }

        return view('client.landingPage', ['activeEvent' => $activeEvent]);
    }

    public function formView(){
        $activeEvent = EventModel::where('status', true)
                        ->where('remaining_quota','!=', 0)
                        ->first();

        if (!isset($activeEvent)) {
            return redirect()->route('client');
        }

        $dateNow = Carbon::now();
        $registerEnd = Carbon::parse($activeEvent->register_end);

        if($dateNow->greaterThan($registerEnd)){

            $activeEvent->update(['status' => false]);

            return redirect()->route('client');   
        }

        $departements = DepartementModel::all();
        $prodys = ProdyModel::all();
        
        return view('client.form', 
        [
        'departements' => $departements, 
        'prodys' => $prodys
        ]);
    }
}
