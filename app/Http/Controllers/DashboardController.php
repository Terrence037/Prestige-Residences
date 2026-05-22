<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Payment;
use App\Models\User;

class DashboardController extends Controller
{
    public function adminStats()
    {
        return [
            'totalProperties' => Property::count(),
            'soldProperties' => Property::where('status', 'sold')->count(),
            'reservedProperties' => Property::where('status', 'reserved')->count(),
            'totalPayments' => Payment::count(),
            'totalRevenue' => Payment::where('payment_status', 'verified')->sum('amount'),
            'totalUsers' => User::count(),
            'totalAgents' => User::where('role', 'agent')->count(),
        ];
    }
}
