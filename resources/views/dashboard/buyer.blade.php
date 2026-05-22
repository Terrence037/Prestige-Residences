@extends('layouts.app')

@section('content')
<div class="container py-4 text-start">
    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="col-md-3 mb-4">
            <div class="card p-4 border-0 shadow-sm bg-white text-center mb-4">
                <img src="{{ $user->profile_image }}" class="rounded-circle border border-warning shadow mx-auto mb-3" width="100" height="100">
                <h5 class="fw-bold">{{ $user->name }}</h5>
                <span class="badge bg-primary">BUYER ACCOUNT</span>
            </div>
            <div class="list-group list-group-flush shadow-sm rounded border-0 bg-white">
                <button class="list-group-item list-group-item-action active py-3" data-bs-toggle="tab" data-bs-target="#wishlist"><i class="bi bi-heart-fill me-2"></i> Wishlist</button>
                <button class="list-group-item list-group-item-action py-3" data-bs-toggle="tab" data-bs-target="#buyer-appointments"><i class="bi bi-calendar-event me-2"></i> Tours</button>
                <button class="list-group-item list-group-item-action py-3" data-bs-toggle="tab" data-bs-target="#buyer-reservations"><i class="bi bi-bookmark-check me-2"></i> Reservations</button>
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-md-9">
            <div class="tab-content bg-white p-4 rounded shadow-sm">
                
                <!-- 1. WISHLIST -->
                <div class="tab-pane fade show active" id="wishlist">
                    <h4 class="fw-bold border-bottom pb-3 mb-4">Saved Properties</h4>
                    <div class="row g-4">
                        @forelse($favorites as $fav)
                            <div class="col-md-6"><x-property-card :property="$fav->property" /></div>
                        @empty
                            <p class="text-muted text-center py-5">No saved properties.</p>
                        @endforelse
                    </div>
                </div>

                <!-- 2. APPOINTMENTS -->
                <div class="tab-pane fade" id="buyer-appointments">
                    <h4 class="fw-bold mb-4">My Scheduled Tours</h4>
                    <table class="table align-middle">
                        <thead><tr><th>Property</th><th>Agent</th><th>Date</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach($appointments as $appt)
                            <tr>
                                <td>{{ $appt->property->title }}</td>
                                <td>{{ $appt->agent->name }}</td>
                                <td>{{ $appt->appointment_date->format('M d, Y') }}</td>
                                <td><span class="badge bg-info">{{ strtoupper($appt->status) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- 3. RESERVATIONS & PAYMENTS -->
                <div class="tab-pane fade" id="buyer-reservations">
                    <h4 class="fw-bold mb-4">Property Reservations</h4>
                    @foreach($reservations as $res)
                    <div class="card p-3 mb-3 border-0 bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1">{{ $res->property->title }}</h6>
                                <p class="small text-muted mb-0">Fee: ${{ number_format($res->reservation_fee) }} | Payment: <strong>{{ strtoupper($res->payment_status) }}</strong></p>
                            </div>
                            @if($res->payment_status === 'pending')
                                <button class="btn btn-warning btn-sm" data-bs-toggle="collapse" data-bs-target="#pay-{{ $res->id }}">Submit Receipt</button>
                            @else
                                <span class="badge bg-success">SECURED</span>
                            @endif
                        </div>
                        
                        <!-- PAYMENT SUBMISSION FORM (Collapsed) -->
                        <div class="collapse mt-3" id="pay-{{ $res->id }}">
                            <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-3 rounded shadow-sm border">
                                @csrf
                                <input type="hidden" name="reservation_id" value="{{ $res->id }}">
                                <input type="hidden" name="amount" value="{{ $res->reservation_fee }}">
                                <div class="mb-2">
                                    <label class="small fw-bold">RECEIPT IMAGE</label>
                                    <input type="file" name="receipt_image" class="form-control form-control-sm" required>
                                </div>
                                <button type="submit" class="btn btn-dark btn-sm w-100">Upload Bank Proof</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection