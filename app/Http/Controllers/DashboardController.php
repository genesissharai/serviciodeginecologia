<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function index(){
        $nextSchedules = \App\Models\MedicalConsultation::whereNot('status', strtoupper("canceled"))->whereDate('date', '>=', \Carbon\Carbon::now())->paginate(25);

        return view('admin.dashboard', ['title' => 'Dashboard', 'nextSchedules' => $nextSchedules]);

    }
}
