<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InquiryController extends Controller
{
    /**
     * Show inquiries based on user role.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $inquiries = Inquiry::with(['property', 'user'])->latest()->paginate(10);
        } elseif ($user->role === 'agent') {
            // Get inquiries for properties owned by this agent
            $inquiries = Inquiry::whereHas('property', function($q) use ($user) {
                $q->where('agent_id', $user->id);
            })->with(['property', 'user'])->latest()->paginate(10);
        } else {
            // Buyer sees their own sent inquiries
            $inquiries = Inquiry::where('user_id', $user->id)->with('property')->latest()->paginate(10);
        }

        return view('inquiries.index', compact('inquiries'));
    }

    /**
     * Submit a new inquiry from the property page.
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'message' => 'required|string|min:10',
        ]);

        Inquiry::create([
            'property_id' => $request->property_id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your inquiry has been sent to the agent.');
    }

    /**
     * Update inquiry status (e.g., mark as Responded).
     */
    public function update(Request $request, $id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->update(['status' => $request->status]);

        return back()->with('success', 'Inquiry status updated.');
    }
}