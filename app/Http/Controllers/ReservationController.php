<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display reservations.
     */
    public function index()
    {
        $user = Auth::user();

        $query = Reservation::with(['property', 'buyer']);

        if ($user->role === 'agent') {
            $query->whereHas('property', function($q) use ($user) {
                $q->where('agent_id', $user->id);
            });
        } elseif ($user->role === 'buyer') {
            $query->where('buyer_id', $user->id);
        }

        $reservations = $query->latest()->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Create a reservation holding.
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'reservation_fee' => 'required|numeric',
        ]);

        $property = Property::findOrFail($request->property_id);

        // Check if already reserved
        if ($property->status !== 'available') {
            return back()->with('error', 'This property is no longer available for reservation.');
        }

        $reservation = Reservation::create([
            'property_id' => $property->id,
            'buyer_id' => Auth::id(),
            'reservation_fee' => $request->reservation_fee,
            'reservation_status' => 'pending',
            'payment_status' => 'pending',
        ]);

        // Update property status to reserved
        $property->update(['status' => 'reserved']);

        return redirect()->route('dashboard')->with('success', 'Reservation initiated. Please proceed to payment to finalize the hold.');
    }

    /**
     * Update reservation status (Approved/Rejected).
     */
    public function updateStatus(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'reservation_status' => 'required|in:pending,approved,rejected'
        ]);

        $reservation->update(['reservation_status' => $request->reservation_status]);

        // If rejected, make property available again
        if ($request->reservation_status === 'rejected') {
            $reservation->property->update(['status' => 'available']);
        }

        return back()->with('success', 'Reservation status updated.');
    }
}