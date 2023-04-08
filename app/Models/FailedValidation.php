<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FailedValidation extends Model
{
    use HasFactory;

    protected $fillable = ['api_request_id', 'errors'];

    public static function getFailedCount(): int
    {
        $failedRules = FailedValidation::selectRaw('sum(JSON_LENGTH(errors)) as failed')
            ->pluck('failed')
            ->first();

        return intval($failedRules);
    }
}
