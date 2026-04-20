<?php

namespace App\Repositories;

use App\Models\DealerProfile;

class DealerRepository
{
    public function createOrUpdate(int $userId, array $data): DealerProfile
    {
        return DealerProfile::updateOrCreate(
            ['user_id' => $userId],
            $data
        );
    }

    public function findByUserId(int $userId): ?DealerProfile
    {
        return DealerProfile::where('user_id', $userId)->first();
    }

    public function findByZip(string $zip)
    {
        return DealerProfile::where('zip', $zip)->with('user')->get();
    }

    public function getAll()
    {
        return DealerProfile::with('user')->get();
    }
}
