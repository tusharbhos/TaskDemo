<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Role;

class UserRepository
{
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->with('role')->first();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function findById(int $id): ?User
    {
        return User::with(['role', 'dealerProfile'])->find($id);
    }

    public function getAllByRole(string $roleName)
    {
        return User::whereHas('role', fn($q) => $q->where('name', $roleName))
            ->with(['role', 'dealerProfile'])
            ->get();
    }

    public function getRoleByName(string $name): ?Role
    {
        return Role::where('name', $name)->first();
    }
}
