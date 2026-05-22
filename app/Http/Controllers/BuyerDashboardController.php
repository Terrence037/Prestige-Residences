<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Appointment;
use App\Models\Reservation;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class BuyerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Favorites
        $favorites = Favorite::where('user_id', $user->id)->with('property')->get();

        // 2. Inquiries
        $inquiries = Inquiry::where('user_id', $user->id)->with('property')->latest()->get();

        // 3. Appointments
        $appointments = Appointment::where('buyer_id', $user->id)->with(['property', 'agent'])->latest()->get();

        // 4. Reservations
        $reservations = Reservation::where('buyer_id', $user->id)->with(['property', 'payment'])->latest()->get();

        return view('dashboard.buyer', compact('user', 'favorites', 'inquiries', 'appointments', 'reservations'));
    }
}