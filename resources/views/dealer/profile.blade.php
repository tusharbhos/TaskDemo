@extends('layouts.app')

@section('title', 'Edit Dealer Profile')

@section('content')

<div class="mb-4">
    <a href="{{ route('dealer.dashboard') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
    </a>
    <h4 class="fw-bold mt-2 mb-0">Edit Business Profile</h4>
    <p class="text-muted small">Keep your dealer information up to date.</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm" style="border-radius:14px;">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('dealer.profile.update') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="company_name">Company Name</label>
                        <input type="text" id="company_name" name="company_name"
                               class="form-control @error('company_name') is-invalid @enderror"
                               value="{{ old('company_name', $profile?->company_name) }}"
                               placeholder="Acme Corp" required>
                        @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="phone">Phone <span class="text-muted">(optional)</span></label>
                        <input type="text" id="phone" name="phone"
                               class="form-control"
                               value="{{ old('phone', $profile?->phone) }}"
                               placeholder="+1 555 0100">
                    </div>

                    <div class="row mb-3">
                        <div class="col-5">
                            <label class="form-label" for="city">City</label>
                            <input type="text" id="city" name="city"
                                   class="form-control @error('city') is-invalid @enderror"
                                   value="{{ old('city', $profile?->city) }}"
                                   placeholder="New York" required>
                            @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-4">
                            <label class="form-label" for="state">State</label>
                            <input type="text" id="state" name="state"
                                   class="form-control @error('state') is-invalid @enderror"
                                   value="{{ old('state', $profile?->state) }}"
                                   placeholder="NY" required>
                            @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-3">
                            <label class="form-label" for="zip">ZIP Code</label>
                            <input type="text" id="zip" name="zip"
                                   class="form-control @error('zip') is-invalid @enderror"
                                   value="{{ old('zip', $profile?->zip) }}"
                                   placeholder="10001" required>
                            @error('zip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="bi bi-save me-1"></i> Save Profile
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
