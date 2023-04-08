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
        User::factory(1)->admin()->create();
        User::factory(2)->create();

        Account::factory(10)->create();

        Loan::factory(10)->create();
        Loan::factory(10)->paidOff()->create();

        ApiRequest::factory(5)->create();
        ApiRequest::factory(5)->positive()->create();
        ApiRequest::factory(5)->negative()->create();

        FailedValidation::factory(10)->create();
    }
}
