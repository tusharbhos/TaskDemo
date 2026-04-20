@extends('layouts.app')

@section('title', 'Dealer Dashboard')

@section('content')

{{-- Welcome Banner --}}
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">Welcome, {{ auth()->user()->first_name }}!</h4>
        <p class="text-muted mb-0">Manage your dealer profile and business information.</p>
    </div>
    <span class="badge fs-6 px-3 py-2"
          style="background:#7c3aed!important; border-radius:10px; color:#fff;">
        <i class="bi bi-building me-1"></i> Dealer
    </span>
</div>

{{-- Profile Completion Alert --}}
@if(!$profile)
    <div class="alert alert-warning d-flex align-items-center gap-2 mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
        <div>
            Your dealer profile is <strong>incomplete</strong>.
            <a href="{{ route('dealer.profile') }}" class="alert-link ms-1">Complete it now →</a>
        </div>
    </div>
@endif

<div class="row g-4">
    {{-- Profile Card --}}
    <div class="col-md-5">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center"
                         style="width:56px;height:56px;background:#7c3aed;font-size:1.3rem;font-weight:700;">
                        {{ strtoupper(substr(auth()->user()->first_name,0,1) . substr(auth()->user()->last_name,0,1)) }}
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ auth()->user()->full_name }}</h5>
                        <small class="text-muted">{{ auth()->user()->email }}</small>
                    </div>
                </div>

                <hr>

                @if($profile)
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bi bi-building text-primary me-2"></i>
                            <strong>Company:</strong> {{ $profile->company_name }}
                        </li>
                        @if($profile->phone)
                        <li class="mb-2">
                            <i class="bi bi-telephone text-primary me-2"></i>
                            <strong>Phone:</strong> {{ $profile->phone }}
                        </li>
                        @endif
                        <li class="mb-2">
                            <i class="bi bi-geo-alt text-primary me-2"></i>
                            <strong>City:</strong> {{ $profile->city }}
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-map text-primary me-2"></i>
                            <strong>State:</strong> {{ $profile->state }}
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-mailbox text-primary me-2"></i>
                            <strong>ZIP:</strong>
                            <span class="badge bg-light text-dark border">{{ $profile->zip }}</span>
                        </li>
                    </ul>
                @else
                    <p class="text-muted text-center py-3">
                        <i class="bi bi-file-earmark-x fs-2 d-block mb-2"></i>
                        No profile details yet.
                    </p>
                @endif

                <div class="mt-4">
                    <a href="{{ route('dealer.profile') }}" class="btn btn-primary w-100">
                        <i class="bi bi-pencil-square me-1"></i>
                        {{ $profile ? 'Edit Profile' : 'Complete Profile' }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Info / Stats --}}
    <div class="col-md-7">
        <div class="card border-0 shadow-sm mb-3" style="border-radius:14px;">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3"><i class="bi bi-info-circle text-primary me-2"></i>Account Overview</h6>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="rounded-3 p-3 text-center" style="background:#f0fdf4;">
                            <div class="fw-bold fs-4 text-success">
                                {{ auth()->user()->is_active ? 'Active' : 'Inactive' }}
                            </div>
                            <div class="small text-muted">Account Status</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="rounded-3 p-3 text-center" style="background:#eff6ff;">
                            <div class="fw-bold fs-4 text-primary">Dealer</div>
                            <div class="small text-muted">Role</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="rounded-3 p-3" style="background:#faf5ff;">
                            <div class="small text-muted mb-1">Member Since</div>
                            <div class="fw-semibold">{{ auth()->user()->created_at->format('F d, Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius:14px;">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3">
                    <i class="bi bi-lightning-charge text-warning me-2"></i>Quick Actions
                </h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('dealer.profile') }}" class="btn btn-outline-primary">
                        <i class="bi bi-person-gear me-1"></i> Update Business Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
