<?php

namespace App\Http\Controllers;

use App\Models\ApiRequest;
use App\Models\FailedValidation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $groupedApiRequests = ApiRequest::groupedByStatus()->get();
        $failedValidations = FailedValidation::getFailedCount();

        return view(
            'admin.api-performance',
            compact('groupedApiRequests', 'failedValidations')
        );
    }

    public function token (Request $request)
    {
        $token =  $request->user()->createToken('api-access-token')->plainTextToken;

        return response()->json($token);
    }
}
