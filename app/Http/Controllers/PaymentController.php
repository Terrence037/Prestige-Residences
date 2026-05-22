<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $payments = Payment::with(['reservation.property', 'buyer'])->latest()->paginate(10);
        } elseif ($user->role === 'agent') {
            // Payments for properties this agent manages
            $payments = Payment::whereHas('reservation.property', function($q) use ($user) {
                $q->where('agent_id', $user->id);
            })->with(['reservation.property', 'buyer'])->latest()->paginate(10);
        } else {
            $payments = Payment::where('buyer_id', $user->id)->with('reservation.property')->latest()->paginate(10);
        }

        return view('payments.index', compact('payments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'receipt_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle File Upload
        $path = $request->file('receipt_image')->store('receipts', 'public');

        Payment::create([
            'reservation_id' => $request->reservation_id,
            'buyer_id' => Auth::id(),
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'receipt_image' => '/storage/' . $path,
            'payment_status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Payment proof uploaded. Awaiting verification.');
    }

    public function verify(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        
        $request->validate(['status' => 'required|in:verified,rejected']);

        $payment->update(['payment_status' => $request->status]);

        // If verified, update the associated reservation as well
        if ($request->status === 'verified') {
            $payment->reservation->update(['payment_status' => 'verified']);
        }

        return back()->with('success', 'Payment marked as ' . $request->status);
    }
}