<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class salesNavigationController extends Controller
{
    //for navigation
    public function ClientManagement()
    {
        return view('sales.ClientManagement');
    }
        public function FollowupManagement()
    {
        return view('sales.FollowupManagement');
    }
        public function TrackPayment()
    {
        return view('sales.TrackPayment');
    }
        public function ReportsandAnalytics()
    {
        return view('sales.ReportsandAnalytics');
    }
        public function Settings()
    {
        return view('sales.Settings');
    }
        public function Inbox()
    {
        return view('sales.Inbox');
    }

}
