<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Inquiry;
use App\Models\Appointment;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class AgentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Listings
        $properties = Property::where('agent_id', $user->id)->latest()->get();

        // 2. Inquiries for the agent's properties
        $inquiries = Inquiry::whereHas('property', function($q) use ($user) {
            $q->where('agent_id', $user->id);
        })->with(['property', 'user'])->latest()->get();

        // 3. Appointments
        $appointments = Appointment::where('agent_id', $user->id)
            ->with(['property', 'buyer'])
            ->latest()
            ->get();

        // 4. Reservations
        $reservations = Reservation::whereHas('property', function($q) use ($user) {
            $q->where('agent_id', $user->id);
        })->with(['property', 'buyer'])->latest()->get();

        return view('dashboard.agent', compact('properties', 'inquiries', 'appointments', 'reservations'));
    }
}