<?php
// Database Configuration
if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1') {
    // Localhost settings (XAMPP)
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'protec_db');
} else {
    // Live Server settings (protecins.com)
    define('DB_HOST', 'localhost'); // Usually localhost on cPanel
    define('DB_USER', 'your_live_db_user'); // Change this in cPanel
    define('DB_PASS', 'your_live_db_pass'); // Change this in cPanel
    define('DB_NAME', 'your_live_db_name'); // Change this in cPanel
}
