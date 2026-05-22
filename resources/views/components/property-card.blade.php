@props(['property', 'isFavorited' => false])

<div class="card h-100 shadow-sm border-0 overflow-hidden hover-card transition-all" id="prop-card-{{ $property->id }}" style="transition: transform 0.2s, box-shadow 0.2s">
    <!-- Property Thumbnail Box -->
    <div class="position-relative overflow-hidden" style="height: 210px;">
        <img src="{{ $property->featured_image }}" alt="{{ $property->title }}" class="card-img-top h-100 w-100" style="object-fit: cover; transition: transform 0.4s" onmouseenter="this.style.transform='scale(1.05)'" onmouseleave="this.style.transform='scale(1)'" referrerPolicy="no-referrer" />

        <!-- Top-aligned Floating Badges -->
        <div class="position-absolute top-0 start-0 m-3 z-3 d-flex flex-column gap-2">
            @switch($property->status)
                @case('available')
                    <span class="badge bg-success shadow-sm">Available</span>
                    @break
                @case('reserved')
                    <span class="badge bg-warning text-dark shadow-sm">Reserved</span>
                    @break
                @case('sold')
                    <span class="badge bg-danger shadow-sm">Sold Out</span>
                    @break
                @default
                    <span class="badge bg-secondary shadow-sm">{{ $property->status }}</span>
            @endswitch
            <span class="badge bg-dark bg-opacity-75">{{ $property->property_type }}</span>
        </div>

        <!-- Wishlist Toggle Button (Buyer Only) -->
        @if(auth()->user()?->role === 'buyer')
            <form action="{{ route('favorites.toggle', $property->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-light rounded-circle position-absolute top-0 end-0 m-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 36px; height: 36px; z-index: 10" title="{{ $isFavorited ? 'Remove from wishlist' : 'Add to wishlist' }}">
                    <i class="bi {{ $isFavorited ? 'bi-heart-fill text-danger' : 'bi-heart text-secondary' }} fs-5"></i>
                </button>
            </form>
        @endif
    </div>

    <!-- Card Details Body -->
    <div class="card-body d-flex flex-column justify-content-between p-4">
        <div>
            <!-- Price Label -->
            <h4 class="text-primary fw-bold mb-2">USD ${{ number_format($property->price, 0) }}</h4>

            <!-- Title Details -->
            <h5 class="card-title text-dark fw-bold mb-1 text-truncate" title="{{ $property->title }}">
                {{ $property->title }}
            </h5>

            <!-- Location details -->
            <p class="text-muted small mb-3">
                <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                {{ $property->address }}, <span class="fw-medium text-dark">{{ $property->city }}</span>
            </p>

            <!-- Area Index & Layout Specs Grid -->
            <div class="row text-center py-2 bg-light rounded mb-3 g-0 border border-light">
                <div class="col-4 border-end">
                    <div class="text-secondary small fw-medium mb-1"><i class="bi bi-door-open-fill text-warning"></i> Beds</div>
                    <span class="fw-bold text-dark">{{ $property->bedrooms }}</span>
                </div>
                <div class="col-4 border-end">
                    <div class="text-secondary small fw-medium mb-1"><i class="bi bi-water text-info"></i> Baths</div>
                    <span class="fw-bold text-dark">{{ $property->bathrooms }}</span>
                </div>
                <div class="col-4">
                    <div class="text-secondary small fw-medium mb-1"><i class="bi bi-aspect-ratio text-success"></i> Area</div>
                    <span class="fw-bold text-dark">{{ $property->floor_area }} <span class="text-muted" style="font-size: 10px;">m²</span></span>
                </div>
            </div>
        </div>

        <!-- View Details Call to Action -->
        <div class="d-grid mt-2">
            <a href="{{ route('properties.show', $property->id) }}" class="btn btn-outline-primary d-flex align-items-center justify-content-center gap-2 fw-semibold btn-sm py-2">
                <i class="bi bi-eye"></i> View Property Specs
            </a>
        </div>
    </div>
</div>