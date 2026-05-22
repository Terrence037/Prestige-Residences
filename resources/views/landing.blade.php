@extends('layouts.app')

@section('content')
<div id="landing-page-container">
    
    <!-- 1. HERO SECTION & INTEGRATED SEARCH BAR -->
    <div class="position-relative text-white py-5 px-3 mb-5" 
        style="background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.8)), url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1920&q=80') center center; background-size: cover; border-radius: 0 0 1.5rem 1.5rem; min-height: 480px">
        
        <div class="container py-4 text-center text-md-start">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-4 mb-lg-0 text-start">
                    <span class="badge bg-warning text-dark fw-bold px-3 py-2 text-uppercase mb-3 shadow">Exclusive Real Estate</span>
                    <h1 class="display-3 fw-extrabold tracking-tight mb-3 text-white">
                        Discover Your <span class="text-warning">Dream Residence</span>
                    </h1>
                    <p class="lead text-white-50 fs-5 mb-4">
                        Prestige Residences brings you an elite selection of premium listings, gorgeous sky penthouses, and industrial lofts. Fully verified listings with transparent digital reservation, flexible visits and legal backing.
                    </p>
                    <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                        <a href="#about-us" class="btn btn-warning btn-lg fw-semibold px-4 py-2 text-dark">
                            <i class="bi bi-info-circle me-1"></i> Learn More
                        </a>
                        <a href="#categories-section" class="btn btn-outline-light btn-lg px-4 py-2">
                            <i class="bi bi-grid-fill me-1"></i> Browse Categories
                        </a>
                    </div>
                </div>

                <!-- Quick Search Card -->
                <div class="col-lg-5">
                    <div class="card bg-white text-dark p-4 rounded shadow-lg border-0 text-start">
                        <h4 class="fw-bold text-dark mb-3"><i class="bi bi-search text-warning me-2"></i>Find Property</h4>
                        <form action="{{ route('properties.index') }}" method="GET">
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">LOCATION OR CITY</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" name="location" class="form-control bg-light border-0" placeholder="e.g. Beverly Hills, Manhattan...">
                                </div>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold">PROPERTY TYPE</label>
                                    <select name="type" class="form-select bg-light border-0">
                                        <option value="">All Types</option>
                                        <option value="House">House</option>
                                        <option value="Condo">Condo</option>
                                        <option value="Apartment">Apartment</option>
                                        <option value="Land">Land</option>
                                        <option value="Commercial">Commercial</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold">BEDROOMS (MIN)</label>
                                    <select name="bedrooms" class="form-select bg-light border-0">
                                        <option value="">Any</option>
                                        <option value="1">1+</option>
                                        <option value="2">2+</option>
                                        <option value="3">3+</option>
                                        <option value="4">4+</option>
                                        <option value="5">5+</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold">MAXIMUM BUDGET (USD)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-currency-dollar"></i></span>
                                    <select name="maxPrice" class="form-select bg-light border-0">
                                        <option value="">Any Price</option>
                                        <option value="300000">Below $300k</option>
                                        <option value="500000">Below $500k</option>
                                        <option value="1000000">Below $1.0M</option>
                                        <option value="2000000">Below $2.0M</option>
                                        <option value="5000000">Below $5.0M</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning py-3 fw-bold text-dark shadow-sm">
                                    <i class="bi bi-funnel-fill me-1"></i> Apply Parameters
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AUTH SYSTEM PORTAL BAR/BANNER -->
    <div class="container my-4" id="landing-auth-banner">
        @guest
            <div class="bg-dark text-white p-4 rounded-4 shadow-lg d-flex flex-wrap align-items-center justify-content-between gap-3 border border-warning border-opacity-20 text-start">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 text-warning">
                        <i class="bi bi-shield-lock-fill fs-3"></i>
                    </div>
                    <div class="text-start">
                        <h5 class="fw-bold text-white mb-1">Unlock Prestige Premium Access</h5>
                        <p class="text-white-50 mb-0 small">Sign in or register an account to bookmark listings, schedule tours, and place properties on reserve.</p>
                    </div>
                </div>
                <a href="{{ route('login') }}" class="btn btn-warning px-4 py-2 fw-semibold text-dark">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Access Portal / Sign In
                </a>
            </div>
        @else
            <div class="bg-white text-dark p-4 rounded-4 shadow-sm d-flex flex-wrap align-items-center justify-content-between gap-3 border text-start">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ auth()->user()->profile_image }}" alt="{{ auth()->user()->name }}" class="rounded-circle border border-warning" style="width: 48px; height: 48px; object-fit: cover;">
                    <div class="text-start">
                        <h5 class="fw-bold mb-1">Welcome back, {{ auth()->user()->name }}!</h5>
                        <p class="text-muted mb-0 small">
                            You are currently authenticated as the system <span class="badge bg-warning text-dark text-uppercase">{{ auth()->user()->role }}</span>.
                        </p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-dark px-4 py-2 fw-semibold">
                        <i class="bi bi-speedometer2 me-1"></i> Go to Dashboard
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger px-4 py-2 fw-semibold">
                            <i class="bi bi-box-arrow-right me-1"></i> Sign Out
                        </button>
                    </form>
                </div>
            </div>
        @endguest
    </div>

    <!-- 2. CATEGORIES SECTION -->
    <div class="container mb-5 text-center" id="categories-section">
        <span class="text-uppercase text-primary small fw-bold mb-2 d-inline-block">Curated Classes</span>
        <h2 class="fw-bold mb-4">Property Portfolios By Category</h2>
        <div class="row g-3 justify-content-center">
            @php
                $categories = [
                    ['tag' => 'House', 'title' => 'Luxury Villas', 'icon' => 'bi-house-heart', 'desc' => 'Premium estates'],
                    ['tag' => 'Condo', 'title' => 'Sky Penthouses', 'icon' => 'bi-building', 'desc' => 'Elevated units'],
                    ['tag' => 'Apartment', 'title' => 'Modern Lofts', 'icon' => 'bi-layers', 'desc' => 'Metropolitan flats'],
                    ['tag' => 'Land', 'title' => 'Acreages', 'icon' => 'bi-images', 'desc' => 'Expansive plots'],
                    ['tag' => 'Commercial', 'title' => 'Corporate', 'icon' => 'bi-briefcase', 'desc' => 'Office towers']
                ];
            @endphp
            @foreach($categories as $cat)
                <div class="col-md-2 col-sm-4 col-6">
                    <a href="{{ route('properties.index', ['type' => $cat['tag']]) }}" class="text-decoration-none">
                        <div class="card border-0 h-100 shadow-sm p-4 text-center bg-white transition-all hover-shadow">
                            <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex p-3 text-warning mb-3 mx-auto">
                                <i class="bi {{ $cat['icon'] }} fs-3"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">{{ $cat['title'] }}</h6>
                            <p class="text-muted small" style="font-size: 11px">{{ $cat['desc'] }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 3. FEATURED PROPERTIES -->
    <div class="container mb-5 text-start">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4">
            <div>
                <span class="text-uppercase text-primary small fw-bold mb-2 d-inline-block">Staff Recommendations</span>
                <h2 class="fw-bold mb-0">Featured Elite Listings</h2>
            </div>
            <a href="{{ route('properties.index') }}" class="btn btn-outline-primary mt-2">
                View All Properties <i class="bi bi-arrow-right-short ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($properties as $p)
                <div class="col-lg-4 col-md-6">
                    <x-property-card :property="$p" />
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center py-5">
                        <i class="bi bi-building-exclamation fs-1 d-block mb-3"></i>
                        No premium available properties registered.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- 4. ABOUT SECTION -->
    <div class="container py-5 mb-5 bg-white rounded-4 shadow-sm" id="about-us">
        <div class="row align-items-center px-4 text-start">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=600&q=80" class="img-fluid rounded-3 shadow" alt="About Us">
            </div>
            <div class="col-md-6 ps-md-5">
                <span class="badge bg-warning text-dark text-uppercase fw-bold px-3 py-2 mb-3">Who We Are</span>
                <h2 class="fw-bold text-dark mb-4">Pioneering Professional Client Representation</h2>
                <p class="text-muted">
                    Prestige Residences is a premium online property portal dedicated to maintaining trust and legal protection for property buyers and developers alike.
                </p>
                <div class="row mt-4">
                    <div class="col-sm-6 mb-3">
                        <h5 class="fw-bold mb-1"><i class="bi bi-shield-check text-warning me-2"></i> 100% Insured Fees</h5>
                        <p class="text-muted small">Reservation transaction limits are secure.</p>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <h5 class="fw-bold mb-1"><i class="bi bi-people-fill text-warning me-2"></i> Master Agents</h5>
                        <p class="text-muted small">Vetted real estate brokers providing assistance.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. CONTACT SECTION -->
    <div class="container py-4 mb-5" id="contact-us">
        <div class="row g-4 text-start">
            <div class="col-md-5">
                <div class="card bg-dark text-white p-5 h-100 border-0 rounded-4">
                    <h3 class="fw-bold text-warning mb-4">Get in Touch with our Care Team</h3>
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <i class="bi bi-geo-alt text-warning fs-4"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Prestige Head Office</h6>
                            <p class="text-white-50 small mb-0">100 Sunset Blvd Suite 50, Beverly Hills, CA</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <i class="bi bi-telephone text-warning fs-4"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Direct Phone Support</h6>
                            <p class="text-white-50 small mb-0">+1 (555) 102-3928</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card bg-white p-5 h-100 border-0 rounded-4 shadow-sm">
                    <h3 class="fw-bold text-dark mb-4">Send a Direct Office Message</h3>
                    <form onsubmit="alert('Message Sent!'); return false;">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="small fw-bold">YOUR NAME</label>
                                <input type="text" required class="form-control bg-light border-0 py-2" placeholder="Full Name">
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold">EMAIL ADDRESS</label>
                                <input type="email" required class="form-control bg-light border-0 py-2" placeholder="name@email.com">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="small fw-bold">MESSAGE CONTENT</label>
                            <textarea rows="4" required class="form-control bg-light border-0 py-2" placeholder="Describe your topic here..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary px-5 py-3 fw-bold text-uppercase">
                            <i class="bi bi-send me-1"></i> Deliver Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection