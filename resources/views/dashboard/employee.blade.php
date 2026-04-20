@extends('layouts.app')

@section('title', 'Employee Dashboard')

@section('content')

{{-- Welcome Banner --}}
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">Welcome back, {{ auth()->user()->first_name }}!</h4>
        <p class="text-muted mb-0">Here's what's happening in the system today.</p>
    </div>
    <span class="badge bg-indigo text-white fs-6 px-3 py-2"
          style="background:#4f46e5!important; border-radius:10px;">
        <i class="bi bi-person-badge me-1"></i> Employee
    </span>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-4">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-3" style="background:#e0e7ff;">
                    <i class="bi bi-people-fill fs-3 text-primary"></i>
                </div>
                <div>
                    <div class="fs-3 fw-bold">{{ $dealers->count() }}</div>
                    <div class="text-muted small">Total Dealers</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-3" style="background:#dcfce7;">
                    <i class="bi bi-person-check-fill fs-3 text-success"></i>
                </div>
                <div>
                    <div class="fs-3 fw-bold">{{ $totalUsers }}</div>
                    <div class="text-muted small">Total Users</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-3" style="background:#fef9c3;">
                    <i class="bi bi-building fs-3 text-warning"></i>
                </div>
                <div>
                    <div class="fs-3 fw-bold">
                        {{ $dealers->filter(fn($d) => $d->dealerProfile)->count() }}
                    </div>
                    <div class="text-muted small">Profiles Completed</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Dealers Table --}}
<div class="card border-0 shadow-sm" style="border-radius:14px; overflow:hidden;">
    <div class="card-header bg-white border-0 py-3 px-4 d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-semibold"><i class="bi bi-table me-2 text-primary"></i>All Dealers</h6>
        <span class="badge bg-primary-subtle text-primary">{{ $dealers->count() }} records</span>
    </div>
    <div class="card-body p-0">
        @if($dealers->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                No dealers registered yet.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Company</th>
                            <th>Location</th>
                            <th>ZIP</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dealers as $i => $dealer)
                        <tr>
                            <td class="text-muted small">{{ $i + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center"
                                         style="width:34px;height:34px;background:#4f46e5;font-size:.8rem;font-weight:600;">
                                        {{ strtoupper(substr($dealer->first_name,0,1) . substr($dealer->last_name,0,1)) }}
                                    </div>
                                    <span>{{ $dealer->full_name }}</span>
                                </div>
                            </td>
                            <td class="small text-muted">{{ $dealer->email }}</td>
                            <td>{{ $dealer->dealerProfile?->company_name ?? '—' }}</td>
                            <td>{{ $dealer->dealerProfile ? $dealer->dealerProfile->city . ', ' . $dealer->dealerProfile->state : '—' }}</td>
                            <td>
                                @if($dealer->dealerProfile)
                                    <span class="badge bg-light text-dark border">{{ $dealer->dealerProfile->zip }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('employee.dealer.view', $dealer->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection
