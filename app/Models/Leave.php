<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $table = 'leaves';
    protected $fillable = [
        'employee_id',
        'employee_name',
        'employment_ID',
        'leave_type',
        'leave_category',
        'half_day_type',
        'short_leave_type',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'duration',
        'approved_person',
        'status',
        'supporting_documents',
        'description',
        'is_no_pay',
        'no_pay_amount'
    ];
    

    /**
     * Relationship: Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Update employee leave balances after approval
     */
    public function updateEmployeeBalances()
    {
        if ($this->status !== 'approved') {
            return;
        }

        $employee = $this->employee;
        $employee->checkMonthlyReset();

        switch ($this->leave_category) {
            case 'full_day':
                $employee->increment('annual_leave_used', $this->duration);
                $employee->increment('monthly_leaves_used', $this->duration);
                break;
                
            case 'half_day':
                $employee->increment('annual_leave_used', $this->duration);
                $employee->increment('monthly_half_leaves_used', $this->duration);
                break;
                
            case 'short_leave':
                $employee->increment('short_leave_used', $this->duration);
                $employee->increment('monthly_short_leaves_used', $this->duration);
                break;
        }
    }
}
