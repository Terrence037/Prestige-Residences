@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center text-start">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <i class="bi bi-envelope-check text-warning" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="fw-bold">Verify Your Email</h3>
                    <p class="text-muted mb-4">
                        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                    </p>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success small mb-4">
                            A new verification link has been sent to the email address you provided during registration.
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-warning fw-bold px-4">
                                Resend Email
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link text-muted small text-decoration-none">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection