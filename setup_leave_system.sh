#!/bin/bash

echo "Running Leave Management System Migrations..."

# Run the migrations
php artisan migrate

echo "Migrations completed successfully!"

echo "Leave Management System Implementation Complete!"
echo ""
echo "Summary of Changes:"
echo "✅ Added leave balance tracking to employees table"
echo "✅ Enhanced leaves table with categories, times, and no-pay tracking"  
echo "✅ Created auto_short_leaves table for late attendance tracking"
echo "✅ Updated Employee model with balance calculation methods"
echo "✅ Enhanced Leave model with balance update functionality"
echo "✅ Updated LeaveController with comprehensive leave management"
echo "✅ Created new leave application form with real-time balance display"
echo "✅ Added API routes for employee data fetching"
echo "✅ Integrated leave no-pay deductions into payroll generation"
echo ""
echo "Features Implemented:"
echo "• Annual leave quota: 21 days per year"
echo "• Short leave quota: 36 per year"
echo "• Monthly limits: 2 full leaves, 1 half leave, 3 short leaves"
echo "• Half day leaves: Morning (8:30 AM - 1:00 PM), Evening (1:00 PM - 5:00 PM)"
echo "• Short leaves: Morning (8:30 AM - 10:00 AM), Evening (3:30 PM - 5:00 PM)"
echo "• Automatic short leave for late arrival (after 9:00 AM)"
echo "• No-pay calculation for excess leaves"
echo "• Real-time balance display in leave form"
echo "• Leave history tracking"
echo "• Payroll integration with no-pay deductions"
echo ""
echo "Next Steps:"
echo "1. Test the leave application form at /dashboard/leaves/leave/create"
echo "2. Verify employee balance tracking works correctly"
echo "3. Test payroll generation includes leave deductions"
echo "4. Update attendance controller to trigger auto short leaves"