<?php

namespace App\Http\Controllers;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function create()
{
    // Fetch all employees to associate with the attendance record
    //$employees = Employee::all();

    // Return the view to create a new attendance record
    return view('management.attendance.attendance-create');
}
    public function edit($id)
    {
        // Find the attendance record by ID
        $attendance = Attendance::findOrFail($id);
    
        // Retrieve the employee associated with this attendance record
        $employee = Employee::findOrFail($attendance->employee_id); // Assuming `employee_id` exists in the attendance table
      //  dd($employee);
        // Return the edit view with both attendance and employee data
        return view('management.attendance.attendance-edit', compact('attendance', 'employee'));
    }
    
    public function store(Request $request)
{
    // Validate input to ensure correct format
    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'date' => 'required|date',

        'total_work_hours' => ['nullable', 'regex:/^([0-9]+):([0-5][0-9]):([0-5][0-9])$/'],
        'overtime_hours' => ['nullable', 'regex:/^([0-9]+):([0-5][0-9]):([0-5][0-9])$/'],
        'late_by' => ['nullable', 'regex:/^([0-9]+):([0-5][0-9]):([0-5][0-9])$/'],
    ]);

    // Convert HH:MM:SS to seconds
    $totalWorkSeconds = $this->convertToSeconds($request->input('total_work_hours'));
    $overtimeSeconds = $this->convertToSeconds($request->input('overtime_hours'));
    $lateBySeconds = $this->convertToSeconds($request->input('late_by'));

    try {
        // Create the attendance record
        $attendance = Attendance::create([
            'employee_id' => $request->input('employee_id'),
            'date' => $request->input('date'),
            'clock_in_time' => $request->input('clock_in_time'),
            'clock_out_time' => $request->input('clock_out_time'),
            'total_work_hours' => $totalWorkSeconds,
            'overtime_seconds' => $overtimeSeconds,
            'late_by_seconds' => $lateBySeconds,
            'status' => 'present', // Default status
        ]);

        return redirect()->route('attendance.management')->with('success', 'Attendance added successfully!');
    } catch (\Illuminate\Database\QueryException $e) {
        // Log the error and display a message
        \Log::error('Query Exception: ' . $e->getMessage());
        return redirect()->route('attendance.management')->with('error', 'Failed to add attendance record.');
    } catch (\Exception $e) {
        // Catch any other exceptions
        \Log::error('Exception: ' . $e->getMessage());
        return redirect()->route('attendance.management')->with('error', 'An error occurred while adding the attendance record.');
    }
}


    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
    
        // Validate input to ensure correct format
        $request->validate([
            'total_work_hours' => ['nullable', 'regex:/^([0-9]+):([0-5][0-9]):([0-5][0-9])$/'],
            'overtime_hours' => ['nullable', 'regex:/^([0-9]+):([0-5][0-9]):([0-5][0-9])$/'],
            'late_by' => ['nullable', 'regex:/^([0-9]+):([0-5][0-9]):([0-5][0-9])$/'],
        ]);
    
        // Convert HH:MM:SS to seconds
        $totalWorkSeconds = $this->convertToSeconds($request->input('total_work_hours'));
        $overtimeSeconds = $this->convertToSeconds($request->input('overtime_hours'));
        $lateBySeconds = $this->convertToSeconds($request->input('late_by'));
    
        try {
            // Update the attendance record
            $isUpdated = $attendance->update([
                'clock_in_time' => $request->input('clock_in_time'),
                'clock_out_time' => $request->input('clock_out_time'),
                'total_work_hours' => $totalWorkSeconds,
                'overtime_seconds' => $overtimeSeconds,
                'late_by_seconds' => $lateBySeconds,
                'date' => $request->input('date'),
            ]);
    //dd($attendance,"overtime",$overtimeSeconds);
            // Check if the update was successful
            if ($isUpdated) {
                return redirect()->route('attendance.management')->with('success', 'Attendance updated successfully!');
            } else {
                return redirect()->route('attendance.management')->with('error', 'Failed to update attendance record.');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            // Log the error and display a message
            \Log::error('Query Exception: ' . $e->getMessage());
            dd('Database Error: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Catch any other exceptions
            \Log::error('Exception: ' . $e->getMessage());
            dd('Error: ' . $e->getMessage());
        }
    }
    
    
    
    /**
     * Convert HH:MM:SS format to seconds.
     *
     * @param string|null $time
     * @return int
     */
    private function convertToSeconds($time)
    {
        if (!$time) {
            return 0;
        }
    
        [$hours, $minutes, $seconds] = explode(':', $time);
        return ($hours * 3600) + ($minutes * 60) + $seconds;
    }

}
