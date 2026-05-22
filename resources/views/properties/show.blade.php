@extends('layouts.app')

@section('content')
<div class="container py-4" id="property-details-view">
    <!-- Breadcrumb / Header Navigation -->
    <nav class="mb-4 d-flex justify-content-between align-items-center text-start">
        <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
            <i class="bi bi-arrow-left"></i> Return to Listing Database
        </a>
        
        @auth
            @if(auth()->user()->role === 'buyer')
                <form action="{{ route('favorites.toggle', $property->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm {{ $isFavorited ? 'btn-danger' : 'btn-outline-danger' }} d-flex align-items-center gap-1">
                        <i class="bi {{ $isFavorited ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                        {{ $isFavorited ? 'Wishlisted' : 'Save to Favorites' }}
                    </button>
                </form>
            @endif
        @endauth
    </nav>

    <div class="row text-start">
        <!-- LEFT COLUMN: GALLERY & DESCRIPTION -->
        <div class="col-lg-8">
            <div class="card border-0 bg-white p-4 shadow-sm mb-4">
                <!-- Primary Display image -->
                <div class="position-relative mb-3" style="height: 450px; border-radius: 10px; overflow: hidden;">
                    <img id="main-property-image" src="{{ $property->featured_image }}" class="w-100 h-100" style="object-fit: cover;">
                    
                    <span class="badge bg-primary fs-6 py-2 px-3 position-absolute bottom-0 start-0 m-3 shadow-lg">
                        USD ${{ number_format($property->price, 0) }}
                    </span>
                    
                    <span class="badge fs-6 py-2 px-3 position-absolute bottom-0 end-0 m-3 shadow-lg 
                        {{ $property->status === 'available' ? 'bg-success' : ($property->status === 'reserved' ? 'bg-warning text-dark' : 'bg-danger') }}">
                        {{ strtoupper($property->status) }}
                    </span>
                </div>

                <!-- Thumbnail Carousel Strip -->
                <div class="d-flex gap-2 overflow-x-auto pb-2 mb-3">
                    <img src="{{ $property->featured_image }}" class="border rounded p-1 cursor-pointer" 
                         style="width: 90px; height: 64px; object-fit: cover; cursor: pointer;"
                         onclick="changeMainImage(this.src)">
                    @foreach($property->images as $img)
                        <img src="{{ $img->image_path }}" class="border rounded p-1 cursor-pointer" 
                             style="width: 90px; height: 64px; object-fit: cover; cursor: pointer;"
                             onclick="changeMainImage(this.src)">
                    @endforeach
                </div>

                <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                    <div>
                        <span class="badge bg-secondary mb-2">{{ $property->property_type }}</span>
                        <h3 class="fw-bold text-dark mb-1">{{ $property->title }}</h3>
                        <p class="text-muted mb-0"><i class="bi bi-geo-alt-fill text-danger"></i> {{ $property->address }}, {{ $property->city }}</p>
                    </div>
                </div>

                <!-- Dimensional Metrics Grid -->
                <div class="row text-center bg-light rounded p-3 mb-4 g-2 border border-secondary-subtle">
                    <div class="col-md-3 col-6 border-md-end">
                        <p class="text-muted mb-1 small"><i class="bi bi-door-open-fill text-warning me-1"></i> Bedrooms</p>
                        <h5 class="fw-bold m-0 text-dark">{{ $property->bedrooms }} Beds</h5>
                    </div>
                    <div class="col-md-3 col-6 border-md-end">
                        <p class="text-muted mb-1 small"><i class="bi bi-water text-info me-1"></i> Bathrooms</p>
                        <h5 class="fw-bold m-0 text-dark">{{ $property->bathrooms }} Baths</h5>
                    </div>
                    <div class="col-md-3 col-6 border-md-end">
                        <p class="text-muted mb-1 small"><i class="bi bi-aspect-ratio text-success me-1"></i> Floor Area</p>
                        <h5 class="fw-bold m-0 text-dark">{{ $property->floor_area }} sqm</h5>
                    </div>
                    <div class="col-md-3 col-6">
                        <p class="text-muted mb-1 small"><i class="bi bi-bounding-box-circles text-primary me-1"></i> Lot Area</p>
                        <h5 class="fw-bold m-0 text-dark">{{ $property->lot_area }} sqm</h5>
                    </div>
                </div>

                <h5 class="fw-bold mb-3">Listing Overview</h5>
                <p class="text-muted lh-base" style="text-align: justify;">{{ $property->description }}</p>

                <h5 class="fw-bold mt-4 mb-3">Building Amenities</h5>
                <div class="row g-2">
                    @foreach(["High-speed Fiber", "Secure Garages", "Air Conditions", "24/7 Security", "Private Balconies", "Trash Services"] as $amenity)
                    <div class="col-md-6 d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span class="text-muted small fw-medium">{{ $amenity }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: SIDEBAR FORMS -->
        <div class="col-lg-4">
            <!-- 1. AGENT CARD -->
            <div class="card border-0 bg-white p-4 shadow-sm mb-4">
                <h5 class="fw-bold text-dark mb-3">Assigned Broker</h5>
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ $property->agent->profile_image }}" class="rounded-circle border border-warning" style="width: 64px; height: 64px; object-fit: cover;">
                    <div>
                        <h6 class="fw-bold m-0">{{ $property->agent->name }}</h6>
                        <p class="text-muted small mb-0">Estate Specialist</p>
                        <p class="text-warning small fw-bold mb-0"><i class="bi bi-star-fill"></i> Top Performer</p>
                    </div>
                </div>
                <div class="border-top mt-3 pt-3">
                    <p class="text-muted small mb-2"><i class="bi bi-phone-fill me-2"></i> {{ $property->agent->phone }}</p>
                    <p class="text-muted small mb-0"><i class="bi bi-envelope-at-fill me-2"></i> {{ $property->agent->email }}</p>
                </div>
            </div>

            @auth
                <!-- 2. RESERVATION BOX -->
                @if($property->status === 'available')
                    <div class="card border-0 bg-warning bg-opacity-20 p-4 shadow-sm mb-4 text-center">
                        <h5 class="fw-bold text-warning-emphasis mb-2"><i class="bi bi-bookmark-star-fill"></i> Hold This Property</h5>
                        <div class="bg-white p-3 rounded border border-warning border-opacity-50 mb-3 text-center">
                            <span class="text-muted d-block small">RESERVATION FEE</span>
                            <h4 class="fw-bold text-warning-emphasis m-0">${{ number_format($reservationFee, 0) }}</h4>
                        </div>
                        <form action="{{ route('reservations.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                            <input type="hidden" name="reservation_fee" value="{{ $reservationFee }}">
                            <button type="submit" class="btn btn-warning w-100 fw-bold shadow-sm" onclick="return confirm('Initiate reservation?')">
                                Submit Reservation Requisition
                            </button>
                        </form>
                    </div>
                @endif

                <!-- 3. SCHEDULE TOUR FORM -->
                <div class="card border-0 bg-white p-4 shadow-sm mb-4">
                    <h5 class="fw-bold text-dark mb-2"><i class="bi bi-calendar-event text-primary me-2"></i>Schedule a Tour</h5>
                    <form action="{{ route('appointments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">VISIT DATE & TIME</label>
                            <input type="datetime-local" name="appointment_date" required class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Submit Appointment</button>
                    </form>
                </div>

                <!-- 4. INQUIRY FORM -->
                <div class="card border-0 bg-white p-4 shadow-sm">
                    <h5 class="fw-bold text-dark mb-2"><i class="bi bi-chat-dots text-success me-2"></i>Need More Details?</h5>
                    <form action="{{ route('inquiries.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                        <div class="mb-3">
                            <textarea name="message" rows="3" required class="form-control" placeholder="Ask about the property..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-outline-success w-100 fw-bold">Dispatch Message</button>
                    </form>
                </div>
            @else
                <!-- GUEST CTA -->
                <div class="card border-0 bg-dark text-white p-4 shadow-lg text-center">
                    <i class="bi bi-lock-fill fs-1 text-warning mb-3"></i>
                    <h5 class="fw-bold">Member Access Required</h5>
                    <p class="small text-white-50">Please sign in to your buyer account to inquire or reserve this property.</p>
                    <a href="{{ route('login') }}" class="btn btn-warning fw-bold w-100">Sign In to Continue</a>
                </div>
            @endauth
        </div>
    </div>
</div>

<!-- Vanilla JS for Image Gallery (Replaces React State) -->
<script>
    function changeMainImage(newSrc) {
        document.getElementById('main-property-image').src = newSrc;
    }
</script>
@endsection