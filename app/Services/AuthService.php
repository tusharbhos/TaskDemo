<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\DealerRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(
        private UserRepository  $userRepo,
        private DealerRepository $dealerRepo
    ) {}

    /**
     * Register a new user and optionally create their dealer profile.
     */
    public function register(array $data): User
    {
        $role = $this->userRepo->getRoleByName($data['role']);

        if (!$role) {
            throw new \RuntimeException("Role '{$data['role']}' not found.");
        }

        $user = $this->userRepo->create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
            'role_id'    => $role->id,
        ]);

        // If registering as a dealer, create the dealer profile
        if ($data['role'] === 'dealer') {
            $this->dealerRepo->createOrUpdate($user->id, [
                'company_name' => $data['company_name'] ?? '',
                'phone'        => $data['phone'] ?? null,
                'city'         => $data['city'] ?? '',
                'state'        => $data['state'] ?? '',
                'zip'          => $data['zip'] ?? '',
            ]);
        }

        return $user;
    }

    /**
     * Attempt login and return user on success, null on failure.
     */
    public function login(string $email, string $password, bool $remember): ?User
    {
        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            return Auth::user();
        }

        return null;
    }

    public function logout(): void
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }
}
