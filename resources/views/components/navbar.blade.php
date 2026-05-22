<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow" id="main-system-navbar">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <i class="bi bi-building-fill text-warning me-2 fs-4"></i>
            <span class="fw-bold tracking-tight">PRESTIGE RESIDENCES</span>
        </a>

        <!-- Hamburger Toggler (Standard Bootstrap) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible Content -->
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active fw-semibold text-warning' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('properties.*') ? 'active fw-semibold text-warning' : '' }}" href="{{ route('properties.index') }}">Properties</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-semibold text-warning' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>
                @endauth
            </ul>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                @auth
                    <!-- User Dropdown (Standard Bootstrap) -->
                    <div class="dropdown">
                        <button class="btn btn-dark d-flex align-items-center gap-2 border-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ auth()->user()->profile_image }}" class="rounded-circle border border-warning" style="width: 28px; height: 28px; object-fit: cover;" referrerPolicy="no-referrer" />
                            <div class="text-start d-none d-sm-inline-block">
                                <div class="lh-1 text-white-50 small" style="font-size: 10px;">{{ strtoupper(auth()->user()->role) }}</div>
                                <div class="fw-semibold text-white small" style="font-size: 13px;">{{ auth()->user()->name }}</div>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('dashboard') }}"><i class="bi bi-person-circle text-primary"></i> View Profile</a></li>
                            <li><a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile.edit') }}"><i class="bi bi-gear-fill text-secondary"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                                        <i class="bi bi-box-arrow-right"></i> Log Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- TRIGGER MODAL instead of linking to /login -->
                    <button type="button" class="btn btn-warning px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#authModal">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In / Join
                    </button>
                @endauth
            </div>
        </div>
    </div>
</nav>