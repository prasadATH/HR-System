<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;

class InitializeLeaveBalances extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'leave:initialize-balances';

    /**
     * The console command description.
     */
    protected $description = 'Initialize leave balances for existing employees';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $employees = Employee::all();
        $count = 0;

        foreach ($employees as $employee) {
            // Only update if balances are not set (0 or null)
            if ($employee->annual_leave_balance == 0 || is_null($employee->annual_leave_balance)) {
                $employee->update([
                    'annual_leave_balance' => 21,
                    'annual_leave_used' => 0,
                    'short_leave_balance' => 36,
                    'short_leave_used' => 0,
                    'monthly_leaves_used' => 0,
                    'monthly_half_leaves_used' => 0,
                    'monthly_short_leaves_used' => 0,
                    'last_monthly_reset' => now()->format('Y-m'),
                    'leave_year_start' => now()->startOfYear()->toDateString()
                ]);
                $count++;
            }
        }

        $this->info("Initialized leave balances for {$count} employees.");
        return 0;
    }
}