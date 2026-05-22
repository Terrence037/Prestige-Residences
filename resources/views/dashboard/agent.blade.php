@extends('layouts.app')

@section('content')
<div class="container py-4">
    
    <!-- 1. EXECUTIVE AGENT PANEL (Stats Header) -->
    <div class="row mb-4">
        <div class="col-12 text-start">
            <div class="card bg-dark text-white p-4 border-0 rounded-4 shadow-lg d-flex flex-wrap justify-content-between align-items-center flex-row">
                <div>
                    <span class="text-warning text-uppercase small fw-bold">Executive Agent Panel</span>
                    <h2 class="fw-bold m-0 mt-1">Hello, {{ auth()->user()->name }}!</h2>
                    <p class="text-white-50 m-0 small">Welcome to your property control center.</p>
                </div>
                <div class="d-flex gap-4">
                    <div class="border-start border-warning border-2 ps-3">
                        <span class="text-white-50 small d-block mb-1">TOTAL LISTINGS</span>
                        <h4 class="fw-bold text-white m-0">{{ $properties->count() }} Units</h4>
                    </div>
                    <div class="border-start border-info border-2 ps-3">
                        <span class="text-white-50 small d-block mb-1">ACTIVE RESERVES</span>
                        <h4 class="fw-bold text-info m-0">{{ $reservations->count() }} Blocks</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. NAVIGATION PILLS (Standard Bootstrap Logic) -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills gap-2 border-bottom pb-3" id="agentDashboardTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active fw-bold px-4" id="listings-tab" data-bs-toggle="tab" data-bs-target="#listings-panel" type="button" role="tab">
                        <i class="bi bi-house-gear me-1"></i> My Listings
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold px-4" id="inquiries-tab" data-bs-toggle="tab" data-bs-target="#inquiries-panel" type="button" role="tab">
                        Inquiries <span class="badge bg-danger ms-1">{{ $inquiries->count() }}</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold px-4" id="appointments-tab" data-bs-toggle="tab" data-bs-target="#appointments-panel" type="button" role="tab">
                        Visits <span class="badge bg-warning text-dark ms-1">{{ $appointments->count() }}</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold px-4" id="reservations-tab" data-bs-toggle="tab" data-bs-target="#reservations-panel" type="button" role="tab">
                        Reservations
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- 3. TAB CONTENT REGION -->
    <div class="tab-content text-start" id="agentDashboardTabsContent">
        
        <!-- A. MY LISTINGS PANEL -->
        <div class="tab-pane fade show active" id="listings-panel" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-dark m-0">Properties Collection</h4>
                <a href="{{ route('properties.create') }}" class="btn btn-primary btn-sm">+ Create Listing</a>
            </div>
            <div class="table-responsive bg-white rounded shadow-sm">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr><th class="text-start ps-4">Property</th><th>Price</th><th>Status</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        @foreach($properties as $prop)
                        <tr>
                            <td class="text-start ps-4"><strong>{{ $prop->title }}</strong></td>
                            <td>${{ number_format($prop->price) }}</td>
                            <td><span class="badge bg-success">{{ $prop->status }}</span></td>
                            <td><a href="{{ route('properties.edit', $prop->id) }}" class="btn btn-outline-warning btn-sm">Edit</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- B. INQUIRIES PANEL -->
        <div class="tab-pane fade" id="inquiries-panel" role="tabpanel">
            <h4 class="fw-bold mb-4">Customer Messages</h4>
            @forelse($inquiries as $inq)
                <div class="card p-3 mb-2 shadow-sm border-0 border-start border-4 border-warning">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-light text-dark border mb-1">{{ $inq->property->title }}</span>
                            <p class="mb-0 text-dark">"{{ $inq->message }}"</p>
                            <small class="text-muted">From: <strong>{{ $inq->user->name }}</strong></small>
                        </div>
                        <form action="{{ route('inquiries.update', $inq->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="responded">
                            <button class="btn btn-sm btn-success">Resolve</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-muted">No messages yet.</p>
            @endforelse
        </div>

        <!-- C. APPOINTMENTS PANEL -->
        <div class="tab-pane fade" id="appointments-panel" role="tabpanel">
            <h4 class="fw-bold mb-4">Visit Appointments</h4>
            <div class="table-responsive bg-white rounded shadow-sm">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr><th>Buyer</th><th>Property</th><th>Date</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appt)
                        <tr>
                            <td>{{ $appt->buyer->name }}</td>
                            <td>{{ $appt->property->title }}</td>
                            <td>{{ $appt->appointment_date->format('M d, Y') }}</td>
                            <td><span class="badge bg-info">{{ strtoupper($appt->status) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- D. RESERVATIONS PANEL -->
        <div class="tab-pane fade" id="reservations-panel" role="tabpanel">
            <h4 class="fw-bold mb-4">Property Reservations</h4>
            <div class="table-responsive bg-white rounded shadow-sm">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr><th class="text-start ps-4">Property</th><th>Buyer</th><th>Wire Status</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $res)
                        <tr>
                            <td class="text-start ps-4"><strong>{{ $res->property->title }}</strong></td>
                            <td>{{ $res->buyer->name }}</td>
                            <td><span class="badge bg-primary">{{ strtoupper($res->payment_status) }}</span></td>
                            <td>
                                @if($res->reservation_status === 'pending')
                                <form action="{{ route('reservations.status', $res->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button class="btn btn-sm btn-success">Approve Hold</button>
                                </form>
                                @else
                                <span class="text-muted small">Confirmed</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection