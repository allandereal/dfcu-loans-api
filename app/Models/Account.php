<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['number'];

    public function outstandingLoans(): HasMany
    {
        return $this->hasMany(Loan::class)->outstanding();
    }
}
