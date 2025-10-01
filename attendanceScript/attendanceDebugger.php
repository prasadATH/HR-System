<?php
/**
 * Attendance System Debugger & Tester
 * This script helps debug why attendance data isn't being saved to the database
 */

// Include only the functions we need from server.php
function formatPunchData($punchData)
{
    $entries = explode("\n", $punchData);
    $formattedEntries = [];

    foreach ($entries as $entry) {
        $entry = trim($entry);
        if (!empty($entry)) {
            // Assume format: "EmpId=12345,AttTime=2025-02-15 08:30:00"
            parse_str(str_replace(",", "&", $entry), $data);

            if (isset($data['EmpId']) && isset($data['AttTime'])) {
                $formattedEntries[] = [
                    'EmpId' => $data['EmpId'],
                    'AttTime' => $data['AttTime']
                ];
            }
        }
    }

    return !empty($formattedEntries) ? json_encode($formattedEntries) : null;
}

function sendToAPI($url, $jsonData)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    
    // Add more debugging info
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    $verbose = fopen('php://temp', 'w+');
    curl_setopt($ch, CURLOPT_STDERR, $verbose);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        $response = 'Curl error: ' . curl_error($ch);
    }
    
    // Get verbose info
    rewind($verbose);
    $verboseLog = stream_get_contents($verbose);
    
    curl_close($ch);
    fclose($verbose);

    return [
        'response' => $response,
        'http_code' => $httpCode,
        'verbose' => $verboseLog
    ];
}

class AttendanceDebugger {
    
    public function run() {
        echo "🔍 Attendance System Debugger & Tester\n";
        echo "=====================================\n\n";
        
        echo "This tool will help diagnose why attendance data isn't saving to your database.\n\n";
        
        $this->showMenu();
    }
    
    private function showMenu() {
        while (true) {
            echo "\n📋 Select an option:\n";
            echo "1. Test with real employee ID (recommended)\n";
            echo "2. Test with dummy employee ID\n";
            echo "3. Test check-in only\n";
            echo "4. Test check-in and check-out sequence\n";
            echo "5. Debug controller expectations\n";
            echo "6. Exit\n\n";
            echo "Choice (1-6): ";
            
            $choice = trim(fgets(STDIN));
            
            switch ($choice) {
                case '1':
                    $this->testWithRealEmployee();
                    break;
                case '2':
                    $this->testWithDummyEmployee();
                    break;
                case '3':
                    $this->testCheckInOnly();
                    break;
                case '4':
                    $this->testCheckInOutSequence();
                    break;
                case '5':
                    $this->debugController();
                    break;
                case '6':
                    echo "👋 Goodbye!\n";
                    return;
                default:
                    echo "❌ Invalid choice. Please select 1-6.\n";
            }
        }
    }
    
    private function testWithRealEmployee() {
        echo "\n🧪 Test with Real Employee ID\n";
        echo "=============================\n";
        echo "💡 This will use an actual employee ID from your database.\n";
        echo "Make sure the employee exists in your 'employees' table!\n\n";
        
        echo "Enter Employee ID (must exist in database): ";
        $empId = trim(fgets(STDIN));
        
        if (empty($empId) || !is_numeric($empId)) {
            echo "❌ Invalid employee ID. Must be numeric.\n";
            return;
        }
        
        echo "Enter date (YYYY-MM-DD) or press Enter for today: ";
        $date = trim(fgets(STDIN));
        if (empty($date)) {
            $date = date('Y-m-d');
        }
        
        echo "Enter check-in time (HH:MM:SS) or press Enter for 08:30:00: ";
        $checkIn = trim(fgets(STDIN));
        if (empty($checkIn)) {
            $checkIn = '08:30:00';
        }
        
        $this->sendSingleAttendance($empId, $date, $checkIn, 'Check-In');
        
        echo "\nDo you want to send a check-out for the same employee? (y/n): ";
        if (trim(strtolower(fgets(STDIN))) === 'y') {
            echo "Enter check-out time (HH:MM:SS) or press Enter for 17:00:00: ";
            $checkOut = trim(fgets(STDIN));
            if (empty($checkOut)) {
                $checkOut = '17:00:00';
            }
            
            echo "⏱️ Waiting 2 seconds to simulate real device timing...\n";
            sleep(2);
            
            $this->sendSingleAttendance($empId, $date, $checkOut, 'Check-Out');
        }
    }
    
    private function testWithDummyEmployee() {
        echo "\n🧪 Test with Dummy Employee ID\n";
        echo "==============================\n";
        echo "⚠️ This will likely fail since the employee won't exist in your database.\n";
        echo "Use this to see the error response from your controller.\n\n";
        
        $this->sendSingleAttendance('99999', date('Y-m-d'), '08:30:00', 'Check-In (Dummy)');
    }
    
    private function testCheckInOnly() {
        echo "\n🧪 Test Check-In Only\n";
        echo "====================\n";
        
        echo "Enter Employee ID: ";
        $empId = trim(fgets(STDIN));
        
        $this->sendSingleAttendance($empId, date('Y-m-d'), date('H:i:s'), 'Check-In Only');
    }
    
    private function testCheckInOutSequence() {
        echo "\n🧪 Test Check-In/Out Sequence\n";
        echo "=============================\n";
        echo "This simulates how a real biometric device works:\n";
        echo "1. Employee checks in (creates new attendance record)\n";
        echo "2. Employee checks out (updates the same record)\n\n";
        
        echo "Enter Employee ID: ";
        $empId = trim(fgets(STDIN));
        
        if (empty($empId) || !is_numeric($empId)) {
            echo "❌ Invalid employee ID\n";
            return;
        }
        
        $date = date('Y-m-d');
        $checkInTime = '08:30:00';
        $checkOutTime = '17:00:00';
        
        echo "\n📍 Step 1: Sending Check-In\n";
        $this->sendSingleAttendance($empId, $date, $checkInTime, 'Check-In');
        
        echo "\n⏱️ Waiting 3 seconds...\n";
        sleep(3);
        
        echo "\n📍 Step 2: Sending Check-Out\n";
        $this->sendSingleAttendance($empId, $date, $checkOutTime, 'Check-Out');
    }
    
    private function sendSingleAttendance($empId, $date, $time, $type) {
        echo "\n" . str_repeat("=", 50) . "\n";
        echo "🔄 Processing: $type\n";
        echo "Employee ID: $empId\n";
        echo "Date & Time: $date $time\n";
        echo str_repeat("=", 50) . "\n";
        
        // Create punch data as it would come from the device
        $punchData = "EmpId=$empId,AttTime=$date $time";
        echo "📄 Raw punch data: $punchData\n";
        
        // Format the data
        $formattedData = formatPunchData($punchData);
        echo "📄 Formatted JSON: $formattedData\n\n";
        
        if (empty($formattedData)) {
            echo "❌ Failed to format data!\n";
            return;
        }
        
        // Send to API
        echo "🚀 Sending to API: https://hr.jaan.lk/api/attendance/store\n";
        $result = sendToAPI("https://hr.jaan.lk/api/attendance/store", $formattedData);
        
        echo "\n📥 HTTP Status Code: " . $result['http_code'] . "\n";
        echo "📥 API Response:\n";
        echo $result['response'] . "\n";
        
        // Analyze the response
        $this->analyzeResponse($result);
    }
    
    private function analyzeResponse($result) {
        $response = $result['response'];
        $httpCode = $result['http_code'];
        
        echo "\n🔍 Response Analysis:\n";
        echo "-------------------\n";
        
        if ($httpCode == 200 || $httpCode == 201) {
            echo "✅ HTTP Status: SUCCESS ($httpCode)\n";
            
            if (strpos($response, 'success') !== false || 
                strpos($response, 'Records processed successfully') !== false) {
                echo "✅ Response indicates SUCCESS\n";
                echo "🎉 Data should be saved to database!\n";
                echo "\n💡 Check your database attendance table to confirm.\n";
            } else {
                echo "⚠️ HTTP OK but response doesn't indicate clear success\n";
                echo "📋 Check the response content above for details\n";
            }
        } elseif ($httpCode == 400) {
            echo "❌ HTTP Status: BAD REQUEST (400)\n";
            if (strpos($response, 'Employee ID') !== false && strpos($response, 'not found') !== false) {
                echo "🔍 Issue: Employee ID doesn't exist in database\n";
                echo "💡 Solution: Use a valid employee ID from your employees table\n";
            } elseif (strpos($response, 'Missing required fields') !== false) {
                echo "🔍 Issue: Data format problem\n";
                echo "💡 Solution: Check EmpId and AttTime fields\n";
            } else {
                echo "🔍 Issue: Other validation error\n";
            }
        } elseif ($httpCode == 404) {
            echo "❌ HTTP Status: NOT FOUND (404)\n";
            echo "🔍 Issue: API endpoint not found or employee not found\n";
            echo "💡 Check: Is https://hr.jaan.lk/api/attendance/store accessible?\n";
        } elseif ($httpCode == 500) {
            echo "❌ HTTP Status: SERVER ERROR (500)\n";
            echo "🔍 Issue: Something went wrong in your Laravel controller\n";
            echo "💡 Check: Your Laravel logs for detailed error information\n";
        } else {
            echo "❌ HTTP Status: $httpCode\n";
            echo "🔍 Unexpected response code\n";
        }
        
        echo "\n📝 Debugging Tips:\n";
        echo "- Check Laravel logs: storage/logs/laravel.log\n";
        echo "- Check attendance logs: storage/logs/attendance_payload.log\n";
        echo "- Verify employee exists: SELECT * FROM employees WHERE id = [YOUR_EMPLOYEE_ID]\n";
        echo "- Check database connection in Laravel\n";
    }
    
    private function debugController() {
        echo "\n🔍 Controller Debug Information\n";
        echo "==============================\n";
        echo "Based on your AttendanceController code:\n\n";
        
        echo "📋 What your controller expects:\n";
        echo "1. JSON data with EmpId and AttTime fields\n";
        echo "2. Employee must exist: Employee::where('id', \$employeeId)->first()\n";
        echo "3. Date format: YYYY-MM-DD HH:MM:SS\n\n";
        
        echo "📋 Controller behavior:\n";
        echo "1. First punch of the day → Creates new record with clock_in_time\n";
        echo "2. Second punch of same day → Updates record with clock_out_time\n";
        echo "3. Calculates: total_work_hours, overtime_seconds, late_by_seconds\n\n";
        
        echo "📋 Common issues:\n";
        echo "1. ❌ Employee ID doesn't exist in database\n";
        echo "2. ❌ Wrong date/time format\n";
        echo "3. ❌ Database connection issues\n";
        echo "4. ❌ Laravel validation failures\n\n";
        
        echo "📋 Logs to check:\n";
        echo "- storage/logs/attendance_payload.log (all requests)\n";
        echo "- storage/logs/success_attendance_payload.log (successful)\n";
        echo "- storage/logs/error_attendance_payload.log (errors)\n";
        echo "- storage/logs/laravel.log (Laravel errors)\n\n";
        
        echo "💡 To verify an employee exists, run this SQL:\n";
        echo "   SELECT id, employee_id, name FROM employees LIMIT 10;\n";
    }
}

// Run the debugger
$debugger = new AttendanceDebugger();
$debugger->run();