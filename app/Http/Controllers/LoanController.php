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
     * Outstanding Loans
     *
     * This endpoint allows you to fetch all outstanding Loans attached to an account number.
     *
     * Check that the service is up. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with an error code such as 400, 402, 500 and a response listing the error message.
     *
     * @response 200 scenario="Found outstanding Loans" [
            {
            "amount_disbursed": 9007000,
            "outstanding_amount": 8976000,
            "date_disbursed": "2018-05-09 10:10:57",
            "due_date": "2031-07-09 10:10:57",
            "created_at": "2023-04-09T10:10:57.000000Z",
            "updated_at": "2023-04-09T10:10:57.000000Z",
            "account_number": 9185407623
            }
        ]
     * @response 422 scenario="Account Number Validation errors" {
            "message": "The account number field must be 10 digits.",
            "errors": {"account_number": ["The account number field must be 10 digits."]}
        }
     * @responseField amount_disbursed The loan amount that was disbursed.
     * @responseField outstanding_amount The amount pending to complete loan payment.
     * @responseField date_disbursed The date when the loan was disbursed.
     * @responseField due_date The date when the loan is supposed to have been paid off.
     * @responseField created_at The date when the loan was disbursed.
     * @responseField updated_at The date when the loan was updated.
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
