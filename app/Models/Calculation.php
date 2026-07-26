<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calculation extends Model
{
    protected $fillable = [
        'company_id',
        'title',
        'input',
        'result',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'input' => 'array',
            'result' => 'array',
            'expires_at' => 'datetime',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
