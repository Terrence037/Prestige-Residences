@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center text-start">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white p-3">
                    <h5 class="mb-0"><i class="bi bi-building-add me-2"></i> List New Property</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('properties.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold small">PROPERTY TITLE</label>
                                <input type="text" name="title" class="form-control bg-light" placeholder="e.g. Modern Sky Penthouse" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">TYPE</label>
                                <select name="property_type" class="form-select bg-light">
                                    <option value="House">House</option>
                                    <option value="Condo">Condo</option>
                                    <option value="Apartment">Apartment</option>
                                    <option value="Land">Land</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">DESCRIPTION</label>
                            <textarea name="description" rows="4" class="form-control bg-light" required></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">PRICE (USD)</label>
                                <input type="number" name="price" class="form-control bg-light" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">BEDROOMS</label>
                                <input type="number" name="bedrooms" class="form-control bg-light" value="1">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">BATHROOMS</label>
                                <input type="number" step="0.5" name="bathrooms" class="form-control bg-light" value="1">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">FLOOR AREA (SQM)</label>
                                <input type="number" name="floor_area" class="form-control bg-light" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">LOT AREA (SQM)</label>
                                <input type="number" name="lot_area" class="form-control bg-light" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">ADDRESS</label>
                                <input type="text" name="address" class="form-control bg-light" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">CITY</label>
                                <input type="text" name="city" class="form-control bg-light" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">FEATURED IMAGE URL</label>
                            <input type="url" name="featured_image" class="form-control bg-light" placeholder="https://images.unsplash.com/..." required>
                        </div>

                        <div class="d-flex justify-content-between border-top pt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-5 fw-bold">Publish Listing</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection