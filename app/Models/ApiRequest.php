<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ApiRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_ip',
        'type',
        'parameters',
        'status',
    ];

    public static function addNew($status)
    {
        return ApiRequest::create([
            'source_ip' => request()->ip(),
            'type' => request()->method(),
            'parameters' => json_encode(request()->all()),
            'status' => $status,
        ]);
    }

    public function failedValidation(): HasOne
    {
        return $this->hasOne(FailedValidation::class);
    }
}
