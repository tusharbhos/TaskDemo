@extends('layouts.guest')

@section('title', 'Register')
@section('subtitle', 'Create your account')

@section('content')
<form method="POST" action="{{ route('register') }}" id="registerForm">
    @csrf

    {{-- Name Row --}}
    <div class="row mb-3">
        <div class="col-6">
            <label class="form-label" for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name"
                   class="form-control @error('first_name') is-invalid @enderror"
                   value="{{ old('first_name') }}" placeholder="John" required>
            @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-6">
            <label class="form-label" for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name"
                   class="form-control @error('last_name') is-invalid @enderror"
                   value="{{ old('last_name') }}" placeholder="Doe" required>
            @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label" for="email">Email Address</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" id="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" placeholder="you@example.com" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label" for="password">Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" id="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Min 8 chars, A-Z, 0-9, symbol" required>
            <button class="btn btn-outline-secondary" type="button" id="togglePass">
                <i class="bi bi-eye" id="eyeIcon"></i>
            </button>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="form-text small">
            Must include uppercase, lowercase, number &amp; special character.
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label" for="password_confirmation">Confirm Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   class="form-control" placeholder="Repeat password" required>
        </div>
    </div>

    {{-- Role selection --}}
    <div class="mb-3">
        <label class="form-label">Register As</label>
        <div class="d-flex gap-3">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="role" id="roleEmployee"
                       value="employee" {{ old('role', 'employee') === 'employee' ? 'checked' : '' }}>
                <label class="form-check-label" for="roleEmployee">
                    <i class="bi bi-person-badge me-1"></i>Employee
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="role" id="roleDealer"
                       value="dealer" {{ old('role') === 'dealer' ? 'checked' : '' }}>
                <label class="form-check-label" for="roleDealer">
                    <i class="bi bi-building me-1"></i>Dealer
                </label>
            </div>
        </div>
        @error('role') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
    </div>

    {{-- Dealer-only fields (shown/hidden via JS) --}}
    <div id="dealer-fields" class="border rounded p-3 mb-3 bg-light">
        <p class="small fw-semibold text-muted mb-3">
            <i class="bi bi-building me-1"></i>Dealer Business Information
        </p>

        <div class="mb-3">
            <label class="form-label" for="company_name">Company Name</label>
            <input type="text" id="company_name" name="company_name"
                   class="form-control @error('company_name') is-invalid @enderror"
                   value="{{ old('company_name') }}" placeholder="Acme Corp">
            @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="phone">Phone <span class="text-muted">(optional)</span></label>
            <input type="text" id="phone" name="phone"
                   class="form-control" value="{{ old('phone') }}" placeholder="+1 555 0100">
        </div>

        <div class="row mb-3">
            <div class="col-5">
                <label class="form-label" for="city">City</label>
                <input type="text" id="city" name="city"
                       class="form-control @error('city') is-invalid @enderror"
                       value="{{ old('city') }}" placeholder="New York">
                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-4">
                <label class="form-label" for="state">State</label>
                <input type="text" id="state" name="state"
                       class="form-control @error('state') is-invalid @enderror"
                       value="{{ old('state') }}" placeholder="NY">
                @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-3">
                <label class="form-label" for="zip">ZIP</label>
                <input type="text" id="zip" name="zip"
                       class="form-control @error('zip') is-invalid @enderror"
                       value="{{ old('zip') }}" placeholder="10001">
                @error('zip') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
        <i class="bi bi-person-plus me-1"></i> Create Account
    </button>

    <div class="divider"></div>

    <p class="text-center small text-muted mb-0">
        Already have an account?
        <a href="{{ route('login') }}" class="text-primary fw-semibold">Sign in</a>
    </p>
</form>
@endsection

@push('scripts')
<script>
    const dealerFields  = document.getElementById('dealer-fields');
    const roleInputs    = document.querySelectorAll('input[name="role"]');

    function toggleDealerFields() {
        const isDealer = document.getElementById('roleDealer').checked;
        dealerFields.style.display = isDealer ? 'block' : 'none';

        // Toggle required on dealer fields
        ['company_name','city','state','zip'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.required = isDealer;
        });
    }

    roleInputs.forEach(r => r.addEventListener('change', toggleDealerFields));
    toggleDealerFields(); // init on page load

    // Password show/hide
    document.getElementById('togglePass').addEventListener('click', function () {
        const pw   = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (pw.type === 'password') {
            pw.type = 'text'; icon.className = 'bi bi-eye-slash';
        } else {
            pw.type = 'password'; icon.className = 'bi bi-eye';
        }
    });
</script>
@endpush
