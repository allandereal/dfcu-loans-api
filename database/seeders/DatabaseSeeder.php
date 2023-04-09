<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account;
use App\Models\ApiRequest;
use App\Models\FailedValidation;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)->create([
            'email' => 'admin@api.dfcubank.com',
            'name' => 'ApiAdmin User'
        ]);

        //models for API testing
        //account with outstanding loans
        Account::factory()->has(Loan::factory()->count(2), 'outstandingLoans')
            ->create([
                'number' => 1000000001
            ]);
        //account with no outstanding loans
        Account::factory()->has(Loan::factory()->paidOff()->count(2), 'outstandingLoans')
            ->create([
                'number' => 1000000002
            ]);
        //account with no loans
        Account::factory()->create([
            'number' => 1000000003
        ]);

        //other factories
        User::factory(2)->create();
        Account::factory(10)->create();

        Loan::factory(10)->create();
        Loan::factory(10)->paidOff()->create();

        ApiRequest::factory(5)->create();
        ApiRequest::factory(5)->positive()->create();
        ApiRequest::factory(5)->negative()->create();
        ApiRequest::factory(5)->invalid()->create();

        FailedValidation::factory(10)->create();
    }
}
