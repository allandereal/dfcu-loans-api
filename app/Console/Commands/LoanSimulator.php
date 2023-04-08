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

        $token = User::firstWhere('is_admin', true)->createToken('api-simulator-token', ['loans:view'])->plainTextToken;
        $reportFile = fopen(public_path('loans-api-'.time().'.txt'), 'a');

        foreach ($accounts as $account){
            $response = Http::withToken($token)->withHeaders([
                'Accept' => 'Application/json',
                'Content-Type' => 'Application/json',
            ])->get(url('api/outstanding-loans'), [
                'account_number' => trim($account)
            ]);

            fwrite($reportFile, $account . " : ".$response->body()."\n");
        }

        fclose($reportFile);

        $this->info('Loan Fetch Simulation Completed!');
    }
}
