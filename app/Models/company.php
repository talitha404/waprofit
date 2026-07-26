<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $table = 'companies';

    protected $fillable = ['name'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function templates(): HasMany
    {
        return $this->hasMany(Template::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function calculations(): HasMany
    {
        return $this->hasMany(Calculation::class);
    }
}
