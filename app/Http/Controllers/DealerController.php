<?php

namespace App\Http\Controllers;

use App\Http\Requests\DealerProfileRequest;
use App\Repositories\DealerRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DealerController extends Controller
{
    public function __construct(private DealerRepository $dealerRepo) {}

    public function dashboard(): View
    {
        $user    = auth()->user()->load('dealerProfile');
        $profile = $user->dealerProfile;

        return view('dashboard.dealer', compact('user', 'profile'));
    }

    public function editProfile(): View
    {
        $user    = auth()->user()->load('dealerProfile');
        $profile = $user->dealerProfile;

        return view('dealer.profile', compact('user', 'profile'));
    }

    public function updateProfile(DealerProfileRequest $request): RedirectResponse
    {
        $this->dealerRepo->createOrUpdate(auth()->id(), $request->validated());

        return redirect()->route('dealer.dashboard')
            ->with('success', 'Profile updated successfully.');
    }
}
