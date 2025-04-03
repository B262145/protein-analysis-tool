<?php
/**
 * Authentication and Database Core
 * Handles:
 * - Session management
 * - Database connection
 * - User authentication
 */

session_start();

class Auth {
    private static $db;
    
    /**
     * Get database connection (singleton pattern)
     */
    public static function get_db() {
        if (!self::$db) {
            self::$db = new PDO(
                'mysql:host=127.0.0.1;dbname=s2673561_ProteinAnalysis;unix_socket=/var/run/mysqld/mysqld.sock',
                's2673561',
                'Fyh923713!',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        }
        return self::$db;
    }

    /**
     * Check if user is logged in
     */
    public static function is_logged_in() {
        return isset($_SESSION['user_id']);
    }

    /**
     * Redirect to login if not authenticated
     */
    public static function require_login() {
        if (!self::is_logged_in()) {
            $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
            header("Location: login.php");
            exit();
        }
    }
}

// Shortcut function for database access
function db() {
    return Auth::get_db();
}
?>
