<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    // ── Registration ──────────────────────────────────────────────────────────

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = $this->authService->register($request->validated());

        // Auto-login after registration
        auth()->login($user);
        $request->session()->regenerate();

        return $this->redirectByRole($user->role->name);
    }

    // ── Login ─────────────────────────────────────────────────────────────────

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $user = $this->authService->login(
            $request->email,
            $request->password,
            $request->boolean('remember')
        );

        if (!$user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'These credentials do not match our records.']);
        }

        $request->session()->regenerate();

        return $this->redirectByRole($user->role->name);
    }

    // ── Logout ────────────────────────────────────────────────────────────────

    public function logout(): RedirectResponse
    {
        $this->authService->logout();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function redirectByRole(string $role): RedirectResponse
    {
        return match ($role) {
            'dealer'   => redirect()->route('dealer.dashboard'),
            'employee' => redirect()->route('employee.dashboard'),
            default    => redirect()->route('login'),
        };
    }
}
