<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg overflow-hidden">
            
            <!-- Modal Header -->
            <div class="modal-header bg-dark text-white p-4 border-0">
                <h5 class="modal-title fw-bold" id="authModalLabel">
                    <i class="bi bi-shield-lock-fill text-warning me-2"></i> Member Portal
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-0">
                <!-- Tabs for switching between Login and Register -->
                <ul class="nav nav-tabs nav-fill bg-light" id="authTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active py-3 fw-bold border-0" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-panel" type="button" role="tab">SIGN IN</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link py-3 fw-bold border-0" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-panel" type="button" role="tab">JOIN NOW</button>
                    </li>
                </ul>

                <div class="tab-content p-4">
                    <!-- Global Error Display -->
                    @if ($errors->any())
                        <div class="alert alert-danger py-2 small mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- LOGIN PANEL (Follows Breeze Template Logic) -->
                    <div class="tab-pane fade show active" id="login-panel" role="tabpanel">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">EMAIL ADDRESS</label>
                                <input type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control bg-light border-0 py-2" placeholder="name@email.com">
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">PASSWORD</label>
                                <input type="password" name="password" required autocomplete="current-password" class="form-control bg-light border-0 py-2" placeholder="••••••••">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember_me">
                                <label class="form-check-label small text-muted" for="remember_me">Keep me signed in</label>
                            </div>
                            <div class="d-grid shadow-sm">
                                <button type="submit" class="btn btn-warning py-2 fw-bold text-dark text-uppercase">Authenticate Account</button>
                            </div>
                            @if (Route::has('password.request'))
                                <div class="text-center mt-3">
                                    <a class="text-decoration-none small text-muted" href="{{ route('password.request') }}">Forgot password?</a>
                                </div>
                            @endif
                        </form>
                    </div>

                    <!-- REGISTER PANEL (Follows Breeze Template Logic) -->
                    <div class="tab-pane fade" id="register-panel" role="tabpanel">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">FULL NAME</label>
                                <input type="text" name="name" value="{{ old('name') }}" required class="form-control bg-light border-0 py-2" placeholder="e.g. Derrick Cole">
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">EMAIL ADDRESS</label>
                                <input type="email" name="email" value="{{ old('email') }}" required class="form-control bg-light border-0 py-2" placeholder="buyer@realestate.com">
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">MEMBERSHIP ROLE</label>
                                <select name="role" class="form-select bg-light border-0 py-2">
                                    <option value="buyer">Home Buyer</option>
                                    <option value="agent">Real Estate Agent</option>
                                </select>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold">PASSWORD</label>
                                    <input type="password" name="password" required class="form-control bg-light border-0 py-2">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold">CONFIRM</label>
                                    <input type="password" name="password_confirmation" required class="form-control bg-light border-0 py-2">
                                </div>
                            </div>
                            <div class="d-grid shadow-sm">
                                <button type="submit" class="btn btn-warning py-2 fw-bold text-dark text-uppercase">Create Platform Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 justify-content-center p-3">
                <p class="small text-muted mb-0">Powered by Prestige Secure Auth Engine</p>
            </div>
        </div>
    </div>
</div>