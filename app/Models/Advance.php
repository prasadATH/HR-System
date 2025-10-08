<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employment_ID',
        'advance_amount',
        'advance_date',
        'status',
        'description',
        'advance_documents'
    ];

    protected $casts = [
        'advance_documents' => 'array',
        'advance_date' => 'date',
        'advance_amount' => 'decimal:2'
    ];

    /**
     * Get the employee that owns the advance.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employment_ID', 'employee_id');
    }

    /**
     * Get the employee name attribute.
     */
    public function getEmployeeNameAttribute()
    {
        return $this->employee ? $this->employee->full_name : 'N/A';
    }
}