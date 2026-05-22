@extends('layouts.app')

@section('content')
<div class="container py-4" id="property-listings-section">
    <!-- Title Header banner -->
    <div class="bg-dark text-white p-4 rounded-3 mb-4 d-flex flex-wrap justify-content-between align-items-center shadow-lg text-start">
        <div>
            <h2 class="fw-bold text-warning mb-1">Interactive Property Catalogue</h2>
            <p class="text-white-50 mb-0 small">Filter through hundreds of luxurious holdings and residential coordinates instantaneously.</p>
        </div>
        <div class="badge bg-primary fs-6 px-3 py-2 mt-2 mt-sm-0">
            {{ $properties->total() }} Property Matches
        </div>
    </div>

    <div class="row text-start">
        <!-- SIDE BAR SEARCH SYSTEM (Standard GET Form) -->
        <div class="col-lg-3 mb-4">
            <div class="card p-4 shadow-sm border-0 bg-white sticky-top mb-3" style="top: 20px;">
                <form action="{{ route('properties.index') }}" method="GET">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark m-0"><i class="bi bi-funnel text-warning me-1"></i> Filter Options</h5>
                        <a href="{{ route('properties.index') }}" class="small text-muted text-decoration-none">Reset All</a>
                    </div>

                    <!-- Property Type -->
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">PROPERTY CLASSIFICATION</label>
                        <select name="type" class="form-select border-secondary-subtle">
                            <option value="">All Types</option>
                            @foreach(['House', 'Condo', 'Apartment', 'Land', 'Commercial'] as $type)
                                <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Location -->
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">CITY / ADDRESS</label>
                        <input type="text" name="location" class="form-control border-secondary-subtle" placeholder="e.g. Seattle..." value="{{ request('location') }}">
                    </div>

                    <!-- Price Limits -->
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">PRICE LIMITS (USD)</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="number" name="minPrice" class="form-control form-control-sm border-secondary-subtle" placeholder="Min" value="{{ request('minPrice') }}">
                            </div>
                            <div class="col-6">
                                <input type="number" name="maxPrice" class="form-control form-control-sm border-secondary-subtle" placeholder="Max" value="{{ request('maxPrice') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Bedrooms -->
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">MIN BEDROOMS</label>
                        <select name="bedrooms" class="form-select border-secondary-subtle">
                            <option value="">Any</option>
                            @for($i=1; $i<=5; $i++)
                                <option value="{{ $i }}" {{ request('bedrooms') == $i ? 'selected' : '' }}>{{ $i }}+ Bedrooms</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">AVAILABILITY</label>
                        <select name="status" class="form-select border-secondary-subtle">
                            <option value="">All Listings</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                            <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold Out</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-warning w-100 fw-bold">Apply Parameters</button>
                </form>
            </div>
        </div>

        <!-- PROPERTY LISTINGS GRID -->
        <div class="col-lg-9">
            @if($properties->isEmpty())
                <div class="card p-5 text-center border-0 bg-white shadow-sm rounded-3">
                    <i class="bi bi-search-heart text-warning fs-1 mb-3"></i>
                    <h4 class="fw-bold">No Properties Match Your Query</h4>
                    <p class="text-muted">Try removing some filter limits or adjusting your search.</p>
                    <a href="{{ route('properties.index') }}" class="btn btn-warning px-4 py-2 mt-2">Clear All Filters</a>
                </div>
            @else
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 mb-4">
                    @foreach($properties as $prop)
                        <div class="col">
                            <!-- Using the Property Card Component -->
                            <x-property-card :property="$prop" />
                        </div>
                    @endforeach
                </div>

                <!-- Laravel Native Pagination (Bootstrap 5 Styles) -->
                <div class="d-flex justify-content-center">
                    {{ $properties->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection