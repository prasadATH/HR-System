<?php
/**
 * Database Checker - Connects to your database and shows employee data
 * This helps you find the correct employee IDs to use for testing
 */

// Load Laravel environment
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\Attendance;

echo "🔍 Database Checker for Attendance Testing\n";
echo str_repeat("=", 70) . "\n\n";

echo "What would you like to check?\n";
echo "1. List all employees (with their database IDs)\n";
echo "2. Check recent attendance records\n";
echo "3. Search for specific employee\n";
echo "4. Test database connection\n";
echo "5. Exit\n\n";
echo "Choice (1-5): ";

$choice = trim(fgets(STDIN));

try {
    switch ($choice) {
        case '1':
            echo "\n📋 Employees in Database:\n";
            echo str_repeat("-", 70) . "\n";
            printf("%-5s | %-15s | %-30s | %-15s\n", "ID", "Employee ID", "Name", "Department");
            echo str_repeat("-", 70) . "\n";
            
            $employees = Employee::with('department')->limit(20)->get();
            
            if ($employees->isEmpty()) {
                echo "❌ No employees found in database!\n";
                echo "💡 You need to add employees first before testing attendance.\n";
            } else {
                foreach ($employees as $emp) {
                    printf(
                        "%-5s | %-15s | %-30s | %-15s\n",
                        $emp->id,
                        $emp->employee_id ?? 'N/A',
                        substr($emp->full_name, 0, 30),
                        $emp->department->name ?? 'N/A'
                    );
                }
                
                echo "\n💡 Use the 'ID' column (first column) for your attendance tests!\n";
                echo "   Your controller uses: Employee::where('id', \$employeeId)\n";
            }
            break;
            
        case '2':
            echo "\n📋 Recent Attendance Records:\n";
            echo str_repeat("-", 90) . "\n";
            printf("%-5s | %-8s | %-12s | %-10s | %-10s | %-12s\n", 
                "ID", "Emp ID", "Date", "Clock In", "Clock Out", "Work Hours");
            echo str_repeat("-", 90) . "\n";
            
            $attendances = Attendance::with('employee')->orderBy('id', 'desc')->limit(10)->get();
            
            if ($attendances->isEmpty()) {
                echo "❌ No attendance records found!\n";
                echo "💡 This is normal if you haven't tested yet.\n";
            } else {
                foreach ($attendances as $att) {
                    $workHours = $att->total_work_hours ? gmdate('H:i:s', $att->total_work_hours) : 'N/A';
                    printf(
                        "%-5s | %-8s | %-12s | %-10s | %-10s | %-12s\n",
                        $att->id,
                        $att->employee_id,
                        $att->date,
                        $att->clock_in_time ?? 'N/A',
                        $att->clock_out_time ?? 'N/A',
                        $workHours
                    );
                }
            }
            break;
            
        case '3':
            echo "\nEnter employee name or ID to search: ";
            $search = trim(fgets(STDIN));
            
            $employees = Employee::where('full_name', 'LIKE', "%$search%")
                ->orWhere('employee_id', 'LIKE', "%$search%")
                ->orWhere('id', $search)
                ->get();
            
            if ($employees->isEmpty()) {
                echo "❌ No employees found matching '$search'\n";
            } else {
                echo "\n📋 Search Results:\n";
                echo str_repeat("-", 70) . "\n";
                printf("%-5s | %-15s | %-30s | %-15s\n", "ID", "Employee ID", "Name", "Email");
                echo str_repeat("-", 70) . "\n";
                
                foreach ($employees as $emp) {
                    printf(
                        "%-5s | %-15s | %-30s | %-15s\n",
                        $emp->id,
                        $emp->employee_id ?? 'N/A',
                        substr($emp->full_name, 0, 30),
                        substr($emp->email ?? 'N/A', 0, 15)
                    );
                }
                
                echo "\n💡 Use the 'ID' column for attendance testing.\n";
            }
            break;
            
        case '4':
            echo "\n🔌 Testing Database Connection...\n";
            
            try {
                DB::connection()->getPdo();
                $dbName = DB::connection()->getDatabaseName();
                echo "✅ Connected to database: $dbName\n";
                
                $employeeCount = Employee::count();
                $attendanceCount = Attendance::count();
                
                echo "\n📊 Database Statistics:\n";
                echo "   Employees: $employeeCount\n";
                echo "   Attendance Records: $attendanceCount\n";
                
                if ($employeeCount == 0) {
                    echo "\n⚠️ Warning: No employees in database!\n";
                    echo "   Add employees before testing attendance.\n";
                }
                
            } catch (\Exception $e) {
                echo "❌ Database connection failed!\n";
                echo "Error: " . $e->getMessage() . "\n";
            }
            break;
            
        case '5':
            echo "Goodbye!\n";
            exit;
            
        default:
            echo "Invalid choice!\n";
    }
    
    echo "\n\n🎯 Next Steps:\n";
    echo "1. Run: php quickTest.php\n";
    echo "2. Use an employee ID from the list above\n";
    echo "3. Check if data is saved in attendances table\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\n💡 Make sure you're running this from the attendanceScript directory.\n";
}
?>
