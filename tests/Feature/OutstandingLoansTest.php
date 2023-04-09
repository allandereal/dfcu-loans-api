<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\FailedValidation;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OutstandingLoansTest extends TestCase
{
    use RefreshDatabase;

    public function test_outstanding_loans_endpoint_requires_authentication(): void
    {
        $endpoint = url('api/outstanding-loans');

        $response = $this->withHeaders([
                'Accept' => 'Application/json',
                'Content-Type' => 'Application/json'
            ])
            ->json('POST', $endpoint, [
                'account_number' => 1234567890,
            ]);

        $response->assertStatus(401);
    }

    public function test_outstanding_loans_endpoint_returns_errors_on_failed_validations(): void
    {
        $endpoint = url('api/outstanding-loans');

        $adminUser = User::factory()->create();
        $token = $adminUser->createToken('loan-api-token', ['loans:view'])->plainTextToken;

        $response = $this->withToken($token)
            ->withHeaders([
                'Accept' => 'Application/json',
                'Content-Type' => 'Application/json'
            ])
            ->json('POST', $endpoint, [
                //account number is 9 digits. 10 digits are required.
                'account_number' => 123456789,
            ]);

        $response->assertStatus(422);
    }

    public function test_outstanding_loans_endpoint_returns_existing_loans(): void
    {
        $endpoint = url('api/outstanding-loans');

        $adminUser = User::factory()->create();
        $token = $adminUser->createToken('loan-api-token', ['loans:view'])->plainTextToken;

        $outstandingLoan = Loan::factory()->create();

        $response = $this->withToken($token)
            ->withHeaders([
                'Accept' => 'Application/json',
                'Content-Type' => 'Application/json'
            ])
            ->json('POST', $endpoint, [
                //account number is 9 digits. 10 digits are required.
                'account_number' => $outstandingLoan->account->number,
            ]);

        $response->assertStatus(200);
    }
}
