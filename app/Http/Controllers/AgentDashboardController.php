<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgentDashboardController extends Controller
{
    public function dashboard(){
        return view("callcenter.dashboard");
    }

    public function qcdashboard(){
        return view("callcenter.qc_dashboard");
    }
}
