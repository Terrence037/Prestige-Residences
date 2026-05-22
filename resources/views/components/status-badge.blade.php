@props(['type', 'value'])

@php
    $classes = [
        // Property Statuses
        'available' => 'bg-success',
        'reserved' => 'bg-warning text-dark',
        'sold' => 'bg-danger',
        
        // Roles
        'admin' => 'bg-dark',
        'agent' => 'bg-info text-dark',
        'buyer' => 'bg-secondary',

        // Payment/Reservation Statuses
        'pending' => 'bg-warning text-dark',
        'verified' => 'bg-success',
        'paid' => 'bg-primary',
        'failed' => 'bg-danger',
        'rejected' => 'bg-danger',
        'approved' => 'bg-success',
        'cancelled' => 'bg-secondary',
    ];

    $badgeClass = $classes[strtolower($value)] ?? 'bg-secondary';
@endphp

<span {{ $attributes->merge(['class' => "badge $badgeClass shadow-sm"]) }}>
    {{ strtoupper($value) }}
</span>