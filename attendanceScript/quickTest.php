<?php
/**
 * Quick Attendance Test - Sends data directly to your API
 * This will help verify if the controller saves data correctly
 */

function sendAttendanceData($employeeId, $dateTime) {
    $data = [
        [
            'EmpId' => $employeeId,
            'AttTime' => $dateTime
        ]
    ];
    
    $jsonData = json_encode($data);
    $apiUrl = "https://hr.jaan.lk/api/attendance/store";
    
    echo "\n" . str_repeat("=", 60) . "\n";
    echo "📤 Sending Attendance Data\n";
    echo str_repeat("=", 60) . "\n";
    echo "Employee ID: $employeeId\n";
    echo "Date & Time: $dateTime\n";
    echo "JSON Payload: $jsonData\n\n";
    
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    echo "📥 Response:\n";
    echo str_repeat("-", 60) . "\n";
    echo "HTTP Status: $httpCode\n";
    
    if ($curlError) {
        echo "❌ CURL Error: $curlError\n";
        return false;
    }
    
    echo "Response Body: $response\n";
    echo str_repeat("=", 60) . "\n";
    
    // Analyze response
    if ($httpCode == 200 || $httpCode == 201) {
        if (strpos($response, 'success') !== false || 
            strpos($response, 'Records processed successfully') !== false) {
            echo "✅ SUCCESS! Data should be in database.\n";
            return true;
        } else {
            echo "⚠️ HTTP OK but unclear if saved. Check response above.\n";
            return null;
        }
    } elseif ($httpCode == 404) {
        if (strpos($response, 'not found') !== false) {
            echo "❌ Employee ID not found in database!\n";
            echo "💡 The employee_id field in employees table doesn't match.\n";
        } else {
            echo "❌ API endpoint not found.\n";
        }
        return false;
    } elseif ($httpCode == 400) {
        echo "❌ Bad Request - Check the error message above.\n";
        return false;
    } else {
        echo "❌ Unexpected response code: $httpCode\n";
        return false;
    }
}

// Main execution
echo "🧪 Quick Attendance API Test\n";
echo "============================\n\n";

echo "⚠️ IMPORTANT: This test uses the PRIMARY KEY (id) from employees table\n";
echo "   Your controller looks for: Employee::where('id', \$employeeId)\n";
echo "   This means you need to use the database ID (1, 2, 3...), NOT employee_id (EMP001, etc.)\n\n";

echo "What would you like to test?\n";
echo "1. Test with employee database ID (recommended)\n";
echo "2. Manual entry\n";
echo "3. Test check-in and check-out sequence\n";
echo "4. Exit\n\n";
echo "Choice (1-4): ";

$choice = trim(fgets(STDIN));

switch ($choice) {
    case '1':
        echo "\n📋 Enter the employee's database ID (the 'id' column, usually 1, 2, 3, etc.)\n";
        echo "💡 To find this, run: SELECT id, employee_id, full_name FROM employees LIMIT 10;\n\n";
        echo "Employee ID (database primary key): ";
        $empId = trim(fgets(STDIN));
        
        if (!is_numeric($empId)) {
            echo "❌ Must be numeric!\n";
            exit;
        }
        
        $now = date('Y-m-d H:i:s');
        echo "\nSending check-in with current time: $now\n";
        $result = sendAttendanceData($empId, $now);
        
        if ($result === true || $result === null) {
            echo "\n🔍 Verification Steps:\n";
            echo "1. Check your database:\n";
            echo "   SELECT * FROM attendances WHERE employee_id = $empId ORDER BY id DESC LIMIT 1;\n\n";
            echo "2. Check Laravel logs:\n";
            echo "   tail -f storage/logs/attendance_payload.log\n";
            echo "   tail -f storage/logs/success_attendance_payload.log\n\n";
            
            echo "Do you want to send a check-out now? (y/n): ";
            if (trim(strtolower(fgets(STDIN))) === 'y') {
                echo "⏱️ Waiting 2 seconds...\n";
                sleep(2);
                $checkOutTime = date('Y-m-d H:i:s');
                echo "Sending check-out with time: $checkOutTime\n";
                sendAttendanceData($empId, $checkOutTime);
                
                echo "\n🔍 Now check database again:\n";
                echo "   SELECT * FROM attendances WHERE employee_id = $empId ORDER BY id DESC LIMIT 1;\n";
                echo "   The record should now have both clock_in_time and clock_out_time!\n";
            }
        }
        break;
        
    case '2':
        echo "\nEmployee ID: ";
        $empId = trim(fgets(STDIN));
        echo "Date & Time (YYYY-MM-DD HH:MM:SS) or press Enter for now: ";
        $dateTime = trim(fgets(STDIN));
        
        if (empty($dateTime)) {
            $dateTime = date('Y-m-d H:i:s');
        }
        
        sendAttendanceData($empId, $dateTime);
        break;
        
    case '3':
        echo "\nEmployee ID: ";
        $empId = trim(fgets(STDIN));
        
        if (!is_numeric($empId)) {
            echo "❌ Must be numeric!\n";
            exit;
        }
        
        $date = date('Y-m-d');
        $checkIn = "$date 08:30:00";
        $checkOut = "$date 17:00:00";
        
        echo "\n📍 Step 1: Sending Check-In ($checkIn)\n";
        sendAttendanceData($empId, $checkIn);
        
        echo "\n⏱️ Waiting 3 seconds...\n";
        sleep(3);
        
        echo "\n📍 Step 2: Sending Check-Out ($checkOut)\n";
        sendAttendanceData($empId, $checkOut);
        
        echo "\n🔍 Verification Query:\n";
        echo "SELECT * FROM attendances WHERE employee_id = $empId AND date = '$date';\n";
        break;
        
    case '4':
        echo "Goodbye!\n";
        exit;
        
    default:
        echo "Invalid choice!\n";
}

echo "\n\n📊 Summary of what to check:\n";
echo "1. Database: SELECT * FROM attendances ORDER BY id DESC LIMIT 5;\n";
echo "2. Success log: cat storage/logs/success_attendance_payload.log\n";
echo "3. Error log: cat storage/logs/error_attendance_payload.log\n";
echo "4. Laravel log: tail storage/logs/laravel.log\n";
echo "\n✨ Test complete!\n";
?>
