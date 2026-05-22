<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display appointments based on the user's role.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $appointments = Appointment::with(['property', 'buyer', 'agent'])->latest()->paginate(10);
        } elseif ($user->role === 'agent') {
            // Appointments for properties this agent manages
            $appointments = Appointment::where('agent_id', $user->id)
                ->with(['property', 'buyer'])
                ->latest()
                ->paginate(10);
        } else {
            // Appointments the buyer has booked
            $appointments = Appointment::where('buyer_id', $user->id)
                ->with(['property', 'agent'])
                ->latest()
                ->paginate(10);
        }

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Store a new appointment (Tour Request).
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'appointment_date' => 'required|date|after:now',
        ]);

        $property = Property::findOrFail($request->property_id);

        Appointment::create([
            'property_id' => $property->id,
            'buyer_id' => Auth::id(),
            'agent_id' => $property->agent_id,
            'appointment_date' => $request->appointment_date,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Tour appointment requested. The agent will review it shortly.');
    }

    /**
     * Update status (Approved/Cancelled/Completed).
     */
    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // Security: Only the assigned agent or admin can change status
        if (Auth::id() !== $appointment->agent_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,approved,cancelled,completed'
        ]);

        $appointment->update(['status' => $request->status]);

        return back()->with('success', 'Appointment status updated to ' . ucfirst($request->status));
    }
}