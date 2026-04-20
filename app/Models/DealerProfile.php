<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'phone',
        'city',
        'state',
        'zip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
