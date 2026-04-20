@extends('layouts.app')

@section('title', 'Dealer Details')

@section('content')

<div class="mb-4">
    <a href="{{ route('employee.dashboard') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
    </a>
    <h4 class="fw-bold mt-2 mb-0">Dealer Profile</h4>
</div>

<div class="row g-4">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm" style="border-radius:14px;">
            <div class="card-body p-4 text-center">
                <div class="rounded-circle text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                     style="width:70px;height:70px;background:#4f46e5;font-size:1.6rem;font-weight:700;">
                    {{ strtoupper(substr($dealer->first_name,0,1) . substr($dealer->last_name,0,1)) }}
                </div>
                <h5 class="fw-bold mb-1">{{ $dealer->full_name }}</h5>
                <p class="text-muted small mb-3">{{ $dealer->email }}</p>
                <span class="badge bg-primary-subtle text-primary px-3 py-2">Dealer</span>
                <hr>
                <div class="text-start">
                    <div class="mb-2 small">
                        <i class="bi bi-calendar3 text-muted me-2"></i>
                        Joined {{ $dealer->created_at->format('M d, Y') }}
                    </div>
                    <div class="mb-2 small">
                        <i class="bi bi-circle-fill me-2 {{ $dealer->is_active ? 'text-success' : 'text-danger' }}" style="font-size:.5rem;"></i>
                        {{ $dealer->is_active ? 'Active' : 'Inactive' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card border-0 shadow-sm" style="border-radius:14px;">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3">
                    <i class="bi bi-building text-primary me-2"></i>Business Information
                </h6>

                @if($dealer->dealerProfile)
                    <table class="table table-sm">
                        <tr>
                            <td class="text-muted" style="width:40%">Company</td>
                            <td><strong>{{ $dealer->dealerProfile->company_name }}</strong></td>
                        </tr>
                        @if($dealer->dealerProfile->phone)
                        <tr>
                            <td class="text-muted">Phone</td>
                            <td>{{ $dealer->dealerProfile->phone }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="text-muted">City</td>
                            <td>{{ $dealer->dealerProfile->city }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">State</td>
                            <td>{{ $dealer->dealerProfile->state }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">ZIP Code</td>
                            <td><span class="badge bg-light text-dark border">{{ $dealer->dealerProfile->zip }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Profile Updated</td>
                            <td class="small">{{ $dealer->dealerProfile->updated_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </table>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-file-earmark-x fs-2 d-block mb-2"></i>
                        This dealer has not completed their profile yet.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
