<?php
/**
 * Database connection handler with PDO
 * Includes connection settings for MySQL
 */
$servername = "127.0.0.1";
$username = "s2673561";
$password = "Fyh923713!";
$dbname = "s2673561_ProteinAnalysis";
$socket = "/var/run/mysqld/mysqld.sock";

try {
    // Create PDO instance with error handling
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;unix_socket=$socket", $username, $password);
    
    // Set error mode to exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to associative array
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // Log error and terminate (avoid exposing sensitive info in production)
    error_log("Database connection failed: " . $e->getMessage());
    die("Connection failed. Please try again later.");
}
?>
