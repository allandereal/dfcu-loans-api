<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class LoanSimulator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loan:simulate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulate the outstanding loans fetching API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $accounts = $this->ask('Enter account numbers seperated by commas');
        $accounts = explode(',', $accounts);

        if (!$accounts){
            $this->error('No account numbers have been provided!');
        }

        $adminUser = User::factory()->create();
        $token = $adminUser->createToken('api-simulator-token', ['loans:view'])->plainTextToken;

        $fileName = 'loans-api-simulation-'.time().'.txt';
        $reportFile = fopen(public_path($fileName), 'a');

        foreach ($accounts as $account){
            $response = Http::withToken($token)->withHeaders([
                'Accept' => 'Application/json',
                'Content-Type' => 'Application/json',
            ])->post(url('api/outstanding-loans'), [
                'account_number' => trim($account)
            ]);

            fwrite($reportFile, "ACCOUNT #: {$account} => RESPONSE : ".$response->body()."\n");
        }

        fclose($reportFile);

        $this->info("Loan Fetch Simulation Completed ans saved in public/{$fileName}");
    }
}
