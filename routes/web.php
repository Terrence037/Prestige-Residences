<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Models\Property;
use App\Models\Payment;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Inquiry;
use App\Models\Appointment;

/*
|--------------------------------------------------------------------------
| 1. Public Routes (Accessible by everyone)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    // We fetch properties that are EITHER available OR reserved
    $properties = Property::with(['agent', 'images'])
        ->whereIn('status', ['available', 'reserved']) 
        ->latest()
        ->take(6) // Increase this to see more data
        ->get();

    return view('landing', compact('properties'));
})->name('home');

Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
// We define 'show' at the bottom to avoid blocking 'create'

/*
|--------------------------------------------------------------------------
| 2. Authenticated Routes (Login Required)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // --- CRITICAL: Define 'create' BEFORE 'show' to avoid 404 ---
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');

    // --- The Dashboard (Logic for Admin, Agent, and Buyer) ---
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return view('dashboard.admin', [
                'stats' => [
                    'totalRevenue' => Payment::where('payment_status', 'verified')->sum('amount'),
                    'soldProperties' => Property::where('status', 'sold')->count(),
                ],
                'payments' => Payment::with(['buyer', 'reservation'])->latest()->get(),
                'users' => User::latest()->get(),
                'properties' => Property::latest()->get(),
                'recentReservations' => Reservation::with(['property', 'buyer'])->latest()->take(5)->get(),
            ]);
        }

        if ($user->role === 'agent') {
            $properties = Property::where('agent_id', $user->id)->latest()->get();
            $inquiries = Inquiry::whereHas('property', fn($q) => $q->where('agent_id', $user->id))->with(['property', 'user'])->get();
            $appointments = Appointment::where('agent_id', $user->id)->with(['property', 'buyer'])->get();
            $reservations = Reservation::whereHas('property', fn($q) => $q->where('agent_id', $user->id))->with(['property', 'buyer', 'payment'])->get();
            return view('dashboard.agent', compact('properties', 'inquiries', 'appointments', 'reservations'));
        }

        if ($user->role === 'buyer') {
            $favorites = $user->favorites()->with('property')->get();
            $inquiries = $user->inquiries()->with('property')->get();
            $appointments = Appointment::where('buyer_id', $user->id)->with(['property', 'agent'])->get();
            $reservations = Reservation::where('buyer_id', $user->id)->with(['property', 'payment'])->get();
            return view('dashboard.buyer', compact('user', 'favorites', 'inquiries', 'appointments', 'reservations'));
        }
    })->name('dashboard');

    // --- Other Resources ---
    Route::resource('inquiries', InquiryController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::patch('appointments/{id}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status');
    Route::resource('reservations', ReservationController::class);
    Route::patch('reservations/{id}/status', [ReservationController::class, 'updateStatus'])->name('reservations.status');
    Route::resource('payments', PaymentController::class);
    Route::patch('payments/{id}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
    Route::post('favorites/{id}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    
    // --- Profile Management ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Fallback Public Show ---
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

require __DIR__ . '/auth.php';