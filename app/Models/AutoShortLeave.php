<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoShortLeave extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'attendance_id',
        'date',
        'actual_clock_in',
        'short_leave_type',
        'is_deducted'
    ];

    protected $dates = ['date'];

    /**
     * Relationship: Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Relationship: Attendance
     */
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}