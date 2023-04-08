<?php

namespace App\Http\Controllers;

use App\Models\ApiRequest;
use App\Models\FailedValidation;
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
}
