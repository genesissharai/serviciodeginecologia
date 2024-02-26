<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function index(){
        $user = \Auth::user();
        $nextSchedules = \App\Models\MedicalConsultation::
            when( ($user->rol == strtoupper("patient")) , function($q) use($user){
                $q->where('patient_id',$user->id);
            })
            ->whereNot('status', strtoupper("canceled"))
            ->whereDate('consultation_date', '>=', \Carbon\Carbon::now())
            ->paginate(25);

        return view('admin.dashboard', ['title' => 'Dashboard', 'nextSchedules' => $nextSchedules]);

    }
}
