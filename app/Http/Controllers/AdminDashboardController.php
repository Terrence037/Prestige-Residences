<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Property;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Statistics
        $stats = [
            'totalRevenue' => Payment::where('payment_status', 'verified')->sum('amount'),
            'soldProperties' => Property::where('status', 'sold')->count(),
            'reservedProperties' => Property::where('status', 'reserved')->count(),
            'totalUsers' => User::where('role', 'buyer')->count(),
            'totalAgents' => User::where('role', 'agent')->count(),
        ];

        // 2. Performance Reports (Aggregated Data)
        $agentPerformance = User::where('role', 'agent')
            ->withCount(['properties as totalListings'])
            ->withCount(['properties as soldListings' => function ($query) {
                $query->where('status', 'sold');
            }])
            ->get()
            ->map(function ($agent) {
                $agent->revenueGenerated = Property::where('agent_id', $agent->id)
                    ->where('status', 'sold')
                    ->sum('price');
                return $agent;
            });

        // 3. Recent Reservations
        $recentReservations = Reservation::with(['property', 'buyer'])->latest()->take(10)->get();

        // 4. Payments, Users, Properties
        $payments = Payment::with(['reservation', 'buyer'])->latest()->get();
        $users = User::orderBy('name')->get();
        $properties = Property::latest()->get();

        return view('dashboard.admin', compact(
            'stats', 
            'agentPerformance', 
            'recentReservations', 
            'payments', 
            'users', 
            'properties'
        ));
    }
}