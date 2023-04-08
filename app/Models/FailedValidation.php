<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedValidation extends Model
{
    use HasFactory;

    protected $fillable = ['api_request_id', 'messages'];
}
