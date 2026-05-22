@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-start">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white p-3">
                    <h5 class="mb-0">Edit Property: {{ $property->title }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('properties.update', $property->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Property Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $property->title }}" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Price (USD)</label>
                                <input type="number" name="price" class="form-control" value="{{ $property->price }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="available" {{ $property->status == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="reserved" {{ $property->status == 'reserved' ? 'selected' : '' }}>Reserved</option>
                                    <option value="sold" {{ $property->status == 'sold' ? 'selected' : '' }}>Sold</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control" rows="5">{{ $property->description }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Update Listing</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection