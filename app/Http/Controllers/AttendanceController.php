<?php

namespace App\Http\Controllers;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

use Carbon\Carbon;


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
    
  /*   public function store(Request $request)
{
    // Validate input to ensure correct format
    $request->validate([
        'employee_id' => 'required',
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
        $employee = Employee::where('employee_id', $request['employee_id'])->first();
        // Handle file uploads if supporting_documents exist
      
        // Create the attendance record
        $attendance = Attendance::create([
            'employee_id' => $employee->id,
            'date' => $request->input('date'),
            'clock_in_time' => $request->input('clock_in_time'),
            'clock_out_time' => $request->input('clock_out_time'),
            'total_work_hours' => $totalWorkSeconds,
            'overtime_seconds' => $overtimeSeconds,
            'late_by_seconds' => $lateBySeconds,
            'status' => 'present', // Default status
        ]);
    
        return redirect()->route('attendance.management')->with('success', 'Attendance record added successfully!');
    } catch (\Illuminate\Database\QueryException $e) {
        // Log the error and display a message
        \Log::error('Query Exception: ' . $e->getMessage());
        return redirect()->route('attendance.management')->with('error', 'Failed to add attendance record.'.$e->getMessage());
    } catch (\Exception $e) {
        // Catch any other exceptions
        \Log::error('Exception: ' . $e->getMessage());
        return redirect()->route('attendance.management')->with('error', 'An error occurred while adding the attendance record.'.$e->getMessage());
    }
}
 */


 public function store(Request $request)
 {
     // Decode JSON input
     $data = $request->json()->all();
 // Log the received data to a file
file_put_contents(storage_path('logs/attendance_payload.log'), now() . ' - ' . json_encode($data, JSON_PRETTY_PRINT).'request received  end' . PHP_EOL, FILE_APPEND);

     // Ensure $data is always an array
     if (!is_array($data)) {
        file_put_contents(storage_path('logs/error_attendance_payload.log'), now() . 'error - ' . json_encode($data, JSON_PRETTY_PRINT).'date format error end' . PHP_EOL, FILE_APPEND);

         return response()->json(['error' => 'Invalid data format'], 400);
     }
 
     // If $data is a single object, wrap it in an array
     if (isset($data['EmpId'])) {
         $data = [$data];
     }
 
     // Process each record
     foreach ($data as $entry) {
         // Validate required fields
         if (!isset($entry['EmpId']) || !isset($entry['AttTime'])) {
            file_put_contents(storage_path('logs/error_attendance_payload.log'), now() . 'Missing required fields: EmpId or AttTime -' . json_encode($data, JSON_PRETTY_PRINT).'missing feilds error end' . PHP_EOL, FILE_APPEND);

             return response()->json(['error' => 'Missing required fields: EmpId or AttTime'], 400);
         }
 
         // Extract fields
         $employeeId = $entry['EmpId'];
         $attFullData = $entry['AttTime'];
 
         // Ensure employee exists
         $employee = Employee::where('id', $employeeId)->first();
         if (!$employee) {
            file_put_contents(storage_path('logs/error_attendance_payload.log'), now() . 'Employee ID not present -' . json_encode($data, JSON_PRETTY_PRINT).'missing employee ID error end' . PHP_EOL, FILE_APPEND);


           
             return response()->json(['error' => "Employee ID {$employeeId} not found"], 404);
         }
 
         // Split AttFullData into date and time
         [$attDate, $attTime] = explode(" ", $attFullData);
 
         // Convert to Carbon objects
         $attTimeCarbon = Carbon::parse($attFullData); // Marked attendance time
         $lateThreshold = Carbon::createFromTime(8, 45, 0);
         $overtimeThreshold = Carbon::createFromTime(16, 45, 0);
         $workHoursThreshold = 8*3600; // Standard working hours
         // Check if attendance already exists for the day
         $attendanceRecord = Attendance::where('employee_id', $employeeId)
             ->where('date', $attDate)
             ->first();
 
         if (!$attendanceRecord) {
             // First entry of the day - set as clock-in
             $lateBySeconds = $attTimeCarbon->greaterThan($lateThreshold)
                 ? $attTimeCarbon->diffInSeconds($lateThreshold)
                 : 0;
 
             Attendance::create([
                 'employee_id' => $employeeId,
                 'date' => $attDate,
                 'clock_in_time' => $attTime,
                 'clock_out_time' => null,
                 'status' => 1,
                 'total_work_hours' => null,
                 'overtime_seconds' => null,
                 'late_by_seconds' => $lateBySeconds,
             ]);
         } else {
             // Update clock-out time with the latest timestamp
             $clockInTimeCarbon = Carbon::parse($attendanceRecord->clock_in_time);
             $clockOutTimeCarbon = $attTimeCarbon; // Latest clock-out time
 
             // Calculate total work hours
             $totalWorkHours = $clockInTimeCarbon->diffInSeconds($clockOutTimeCarbon); // Convert to hours

             // Calculate overtime only if total work hours exceed 8
             $overtimeSeconds = 0;
             if ($totalWorkHours > $workHoursThreshold) {
                 $overtimeSeconds = ($totalWorkHours - $workHoursThreshold); // Convert excess hours to seconds
             }
 
 
             // Update existing record
             $attendanceRecord->update([
                 'clock_out_time' => $attTime,
                 'status' => 1,
                 'total_work_hours' => $totalWorkHours, // No rounding off
                 'overtime_seconds' => $overtimeSeconds,
             ]);
         }
     }
     file_put_contents(storage_path('logs/success_attendance_payload.log'), now() . ' - ' . json_encode($data, JSON_PRETTY_PRINT).'request successfully processed  end' . PHP_EOL, FILE_APPEND);

     return response()->json(['message' => 'Records processed successfully'], 201);
 }

 public function destroy($id)
{
    try {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('attendance.management')->with('success', 'Attendance record deleted successfully!');
    } catch (\Exception $e) {
        \Log::error('Attendance Delete Error: ' . $e->getMessage());
        return redirect()->route('attendance.management')->with('error', 'Failed to delete attendance record. ' . $e->getMessage());
    }
}


 public function update(Request $request, $id)
{
    $attendance = Attendance::findOrFail($id);

    // Validate input
    $request->validate([
        'employee_id' => 'required|numeric',
        'clock_in_time' => 'required',
        'clock_out_time' => 'required',
        'date' => 'required|date',
    ]);

    $date = $request->input('date');
    $clockIn = Carbon::parse($date . ' ' . $request->input('clock_in_time'));
    $clockOut = Carbon::parse($date . ' ' . $request->input('clock_out_time'));

    if ($clockOut->lessThan($clockIn)) {
        $clockOut->addDay();
    }

    // Thresholds
    $eightThirty = Carbon::parse($date . ' 08:30:00');
    $tenAM = Carbon::parse($date . ' 10:00:00');
    $lateThreshold = Carbon::parse($date . ' 08:45:00');

    if ($clockIn->greaterThanOrEqualTo($tenAM)) {
        // After 10:00 AM – OT after 4 hours
        $workStart = $clockIn->copy();
        $otThreshold = 4 * 3600;
    } else {
        // Before 10:00 AM – Start at 8:30 AM if earlier
        $workStart = $clockIn->lessThan($eightThirty) ? $eightThirty->copy() : $clockIn->copy();
        $otThreshold = 8 * 3600;
    }

    // Work time in seconds
    $totalWorkSeconds = $workStart->diffInSeconds($clockOut);

    // Overtime calculation
    $overtimeSeconds = $totalWorkSeconds > $otThreshold
        ? $totalWorkSeconds - $otThreshold
        : 0;

    // Late time calculation
    $lateBySeconds = $clockIn->greaterThan($lateThreshold)
        ? $clockIn->diffInSeconds($lateThreshold)
        : 0;

    try {
        $employee = Employee::where('employee_id', $request->employee_id)->first();

        $isUpdated = $attendance->update([
            'employee_id' => $employee->id,
            'clock_in_time' => $request->input('clock_in_time'),
            'clock_out_time' => $request->input('clock_out_time'),
            'total_work_hours' => $totalWorkSeconds,
            'overtime_seconds' => $overtimeSeconds,
            'late_by_seconds' => $lateBySeconds,
            'date' => $date,
        ]);

        return redirect()->route('attendance.management')->with(
            $isUpdated ? 'success' : 'error',
            $isUpdated ? 'Attendance updated successfully!' : 'Failed to update attendance record.'
        );
    } catch (\Illuminate\Database\QueryException $e) {
        \Log::error('Query Exception: ' . $e->getMessage());
        return redirect()->route('attendance.management')->with('error', 'Database error: ' . $e->getMessage());
    } catch (\Exception $e) {
        \Log::error('Exception: ' . $e->getMessage());
        return redirect()->route('attendance.management')->with('error', 'Unexpected error: ' . $e->getMessage());
    }
}

 public function storeManual(Request $request)
 {
     $request->validate([
         'employee_id' => 'required|numeric|exists:employees,employee_id',
         'clock_in_time' => 'required',
         'clock_out_time' => 'required',
         'date' => 'required|date',
     ]);
 
     try {
       $employee = Employee::where('employee_id', $request->employee_id)->first(); 

$clockIn = Carbon::parse($request->date . ' ' . $request->clock_in_time);
$clockOut = Carbon::parse($request->date . ' ' . $request->clock_out_time);

// Handle clockOut on next day
if ($clockOut->lessThan($clockIn)) {
    $clockOut->addDay();
}

// Define time thresholds
$eightThirty = Carbon::parse($request->date . ' 08:30:00');
$tenAM = Carbon::parse($request->date . ' 10:00:00');
$lateThreshold = Carbon::parse($request->date . ' 08:45:00');

if ($clockIn->greaterThanOrEqualTo($tenAM)) {
    // Came after 10:00 AM – Work from actual clock-in, OT after 4 hours
    $workStart = $clockIn->copy();
    $otThreshold = 4 * 3600;
} else {
    // Came before 10:00 AM – Work from 8:30 AM or actual clock-in (whichever is later)
    $workStart = $clockIn->lessThan($eightThirty) ? $eightThirty->copy() : $clockIn->copy();
    $otThreshold = 8 * 3600;
}

// Calculate total work seconds
$totalWorkSeconds = $workStart->diffInSeconds($clockOut);

// Calculate OT
$overtimeSeconds = $totalWorkSeconds > $otThreshold
    ? $totalWorkSeconds - $otThreshold
    : 0;

// Calculate Late By
$lateBySeconds = $clockIn->greaterThan($lateThreshold)
    ? $clockIn->diffInSeconds($lateThreshold)
    : 0;

 
         Attendance::create([
             'employee_id' => $employee->id,
             'date' => $request->date,
             'clock_in_time' => $request->clock_in_time,
             'clock_out_time' => $request->clock_out_time,
             'status' => 'present',
             'total_work_hours' => $totalWorkSeconds,
             'overtime_seconds' => $overtimeSeconds,
             'late_by_seconds' => $lateBySeconds,
         ]);
 
         return redirect()->route('attendance.management')->with('success', 'Attendance added successfully!');
     } catch (\Exception $e) {
         \Log::error('Attendance Store Manual Error: ' . $e->getMessage());
         return redirect()->route('attendance.management')->with('error', 'Error saving attendance. ' . $e->getMessage());
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
