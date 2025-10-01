<?php
/**
 * Configuration for Attendance Testing
 * 
 * Update the API_URL based on where you want to test:
 * - Local development: http://localhost/api/attendance/store or http://127.0.0.1:8001/api/attendance/store
 * - Remote server: https://hr.jaan.lk/api/attendance/store
 */

// Change this to your testing environment
define('API_ENVIRONMENT', 'local'); // Options: 'local' or 'remote'

// API URLs
define('LOCAL_API_URL', 'http://127.0.0.1:8001/api/attendance/store');
define('REMOTE_API_URL', 'https://hr.jaan.lk/api/attendance/store');

// Get the appropriate API URL based on environment
function getAPIUrl() {
    if (API_ENVIRONMENT === 'local') {
        return LOCAL_API_URL;
    } else {
        return REMOTE_API_URL;
    }
}

// Display current configuration
function showConfig() {
    echo "📋 Current Configuration:\n";
    echo "------------------------\n";
    echo "Environment: " . API_ENVIRONMENT . "\n";
    echo "API URL: " . getAPIUrl() . "\n";
    echo "------------------------\n\n";
}
