<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetLoansRequest;
use App\Http\Resources\LoanResource;
use App\Models\Account;
use App\Models\ApiRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetLoansRequest $request): AnonymousResourceCollection|JsonResponse
    {
        $account = Account::whereHas('outstandingLoans')->with('outstandingLoans')
            ->firstWhere('number', '=', $request->validated('account_number'));

        if ($account){
            ApiRequest::addNew('positive');
            return LoanResource::collection($account->outstandingLoans);
        }

        ApiRequest::addNew('negative');

        return response()->json('no loan found', Response::HTTP_OK);
    }
}
