<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'amount_disbursed',
        'outstanding_amount',
        'date_disbursed',
        'due_date'
    ];

    protected $hidden = ['account_id'];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function scopeOutstanding(Builder $query): Builder
    {
        return $query->where('outstanding_amount', '>', 0);
    }
}
