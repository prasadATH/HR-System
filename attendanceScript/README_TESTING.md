# Attendance Server Testing Guide

## Quick Start

### 1. Start Your Local Laravel Server
```bash
cd /Users/alexchamara/Documents/Work/HR-System
php artisan serve
```
This will start your server at `http://127.0.0.1:8001`

### 2. Run the Test Script
```bash
cd /Users/alexchamara/Documents/Work/HR-System/attendanceScript
php serverTest.php
```

### 3. Select Test Mode
- Option 1: Run all tests (unit + integration)
- Option 2: Run API test only (quick test)

### 4. Select API Environment
When prompted, choose:
- **Option 1**: Local (`http://127.0.0.1:8001/api/attendance/store`) - Test on your local machine
- **Option 2**: Remote (`https://hr.jaan.lk/api/attendance/store`) - Test on production server
- **Option 3**: Custom URL - Enter your own URL

### 5. Enter Test Data
You can either:
- **Manual entry**: Specify employee IDs and times
- **Quick test**: Use default test data

## Important Notes

### Employee IDs
Use the **database ID** (auto-increment primary key), not the employee_id column:
- Employee ID **1** = Thilina Prasad Athukorala
- Employee ID **11** = J.L.Alex Chamara (you!)
- Employee ID **2** = Tharani Nimansha Udugampola

To see all employee IDs:
```bash
php checkDatabase.php
```
Then select option 1.

### Checking Results

After running the test, verify the data was saved:
```bash
php checkDatabase.php
```
Then select option 2 to check recent attendance records.

### Common Issues

1. **"Employee ID not found" error**
   - Make sure you're using the correct database ID
   - Run `php checkDatabase.php` to see valid IDs

2. **Connection refused**
   - Make sure Laravel server is running: `php artisan serve`
   - Check if you selected the correct environment (local vs remote)

3. **No data in database**
   - Check Laravel logs: `tail -f storage/logs/laravel.log`
   - Check custom logs: `cat storage/logs/attendance_*.log`

## Testing Workflow

1. ✅ Start Laravel server
2. ✅ Run test script
3. ✅ Choose local environment
4. ✅ Enter valid employee ID from your database
5. ✅ Check database for saved records
6. ✅ Review API response and logs

## Files

- `serverTest.php` - Main test script
- `checkDatabase.php` - Database checker utility
- `quickTest.php` - Quick test without prompts
- `attendanceDebugger.php` - Advanced debugging tool
- `server.php` - Actual server for biometric devices
