<?php
$servername = "127.0.0.1";
$username = "s2673561";
$password = "Fyh923713!";
$dbname = "s2673561_ProteinAnalysis";
$socket = "/var/run/mysqld/mysqld.sock";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;unix_socket=$socket", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
