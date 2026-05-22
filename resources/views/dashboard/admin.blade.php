@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="row mb-4 text-start">
        <div class="col-12">
            <span class="text-uppercase text-danger small fw-bold mb-1 d-block"><i class="bi bi-shield-lock-fill"></i> Central Command Center</span>
            <h2 class="fw-bold text-dark mb-1">Prestige System Administrator Dashboard</h2>
            <p class="text-muted small">Monitor wire proofs, verify listings, and adjust authorizations.</p>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs mb-4" id="adminDashboardTabs" role="tablist">
        <li class="nav-item"><button class="nav-link active fw-bold" data-bs-toggle="tab" data-bs-target="#stats">Performance</button></li>
        <li class="nav-item"><button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#payments">Payments ({{ $payments->where('payment_status', 'pending')->count() }})</button></li>
        <li class="nav-item"><button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#users">User Directory</button></li>
        <li class="nav-item"><button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#properties">Master Listings</button></li>
    </ul>

    <div class="tab-content text-start">
        <!-- 1. STATISTICS TAB -->
        <div class="tab-pane fade show active" id="stats">
            <div class="row g-3 mb-4">
                <div class="col-md-3"><div class="card p-3 border-0 shadow-sm border-start border-primary border-4">REVENUE<h3 class="fw-bold">${{ number_format($stats['totalRevenue']) }}</h3></div></div>
                <div class="col-md-3"><div class="card p-3 border-0 shadow-sm border-start border-success border-4">SOLD UNITS<h3 class="fw-bold">{{ $stats['soldProperties'] }}</h3></div></div>
            </div>
            <!-- Recent Reservations Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Recent Reservation Ledger</h5>
                    <table class="table align-middle">
                        <thead class="table-light"><tr><th>ID</th><th>Property</th><th>Client</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach($recentReservations as $res)
                            <tr>
                                <td>#RES-{{ $res->id }}</td>
                                <td>{{ $res->property->title }}</td>
                                <td>{{ $res->buyer->name }}</td>
                                <td><span class="badge bg-info">{{ strtoupper($res->reservation_status) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 2. PAYMENTS TAB (THE VERIFICATION ACTIONS) -->
        <div class="tab-pane fade" id="payments">
            <div class="table-responsive bg-white rounded shadow-sm">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr><th>Ref ID</th><th class="text-start">Client</th><th>Amount</th><th>Receipt</th><th>Status</th><th class="text-end pe-4">Manual Audit Action</th></tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $pay)
                        <tr>
                            <td>#TX-{{ $pay->id }}</td>
                            <td class="text-start"><strong>{{ $pay->buyer->name }}</strong></td>
                            <td class="text-success fw-bold">${{ number_format($pay->amount) }}</td>
                            <td><a href="{{ $pay->receipt_image }}" target="_blank" class="btn btn-outline-info btn-sm">View Proof</a></td>
                            <td><span class="badge {{ $pay->payment_status == 'verified' ? 'bg-success' : 'bg-warning' }}">{{ strtoupper($pay->payment_status) }}</span></td>
                            <td class="text-end pe-4">
                                @if($pay->payment_status === 'pending')
                                    <div class="d-inline-flex gap-1">
                                        <form action="{{ route('payments.verify', $pay->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="verified">
                                            <button class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                        <form action="{{ route('payments.verify', $pay->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted small">Processed</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. USERS TAB (PROMOTION/DELETION ACTIONS) -->
        <div class="tab-pane fade" id="users">
            <div class="table-responsive bg-white shadow-sm rounded">
                <table class="table align-middle text-center">
                    <thead class="table-light">
                        <tr><th>Avatar</th><th class="text-start">Name</th><th>Email</th><th>Role</th><th class="text-end pe-4">Admin Controls</th></tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        <tr>
                            <td><img src="{{ $u->profile_image }}" class="rounded-circle" width="35" height="35"></td>
                            <td class="text-start"><strong>{{ $u->name }}</strong></td>
                            <td>{{ $u->email }}</td>
                            <td><span class="badge bg-dark">{{ strtoupper($u->role) }}</span></td>
                            <td class="text-end pe-4">
                                @if($u->id !== auth()->id()) {{-- Don't allow admin to delete themselves --}}
                                <div class="d-inline-flex gap-1">
                                    {{-- Role Change --}}
                                    <form action="{{ route('profile.update', $u->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <select name="role" onchange="this.form.submit()" class="form-select form-select-sm" style="width: 110px;">
                                            <option value="buyer" {{ $u->role == 'buyer' ? 'selected' : '' }}>Buyer</option>
                                            <option value="agent" {{ $u->role == 'agent' ? 'selected' : '' }}>Agent</option>
                                        </select>
                                    </form>
                                    {{-- Delete --}}
                                    <form action="{{ route('profile.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Wipe User?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 4. PROPERTIES TAB (MASTER REMOVAL) -->
        <div class="tab-pane fade" id="properties">
            <div class="table-responsive bg-white shadow-sm rounded">
                <table class="table align-middle text-center">
                    <thead class="table-light">
                        <tr><th class="text-start">Property Title</th><th>Price</th><th>Agent</th><th>Status</th><th class="text-end pe-4">Removal</th></tr>
                    </thead>
                    <tbody>
                        @foreach($properties as $prop)
                        <tr>
                            <td class="text-start">
                                <img src="{{ $prop->featured_image }}" width="40" class="rounded me-2">
                                <strong>{{ $prop->title }}</strong>
                            </td>
                            <td>${{ number_format($prop->price) }}</td>
                            <td>ID: #{{ $prop->agent_id }}</td>
                            <td><span class="badge bg-success">{{ $prop->status }}</span></td>
                            <td class="text-end pe-4">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('properties.show', $prop->id) }}" class="btn btn-outline-info btn-sm"><i class="bi bi-eye"></i></a>
                                    <form action="{{ route('properties.destroy', $prop->id) }}" method="POST" onsubmit="return confirm('Delete Listing?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
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