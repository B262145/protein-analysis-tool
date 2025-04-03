<?php
/**
 * Analysis Processing Script
 * Allows both logged-in and guest users
 */
ini_set('max_execution_time', 600);

// Start session and connect to DB
session_start();
include 'db_connect.php';

// Get user input from form
$protein_family = $_POST['protein_family'] ?? '';
$taxonomic_group = $_POST['taxonomic_group'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;

try {
    // Insert analysis into database
    $stmt = $conn->prepare("INSERT INTO records (protein_family, taxonomic_group, user_id) 
                            VALUES (:protein_family, :taxonomic_group, :user_id)");
    $stmt->bindValue(':protein_family', $protein_family, PDO::PARAM_STR);
    $stmt->bindValue(':taxonomic_group', $taxonomic_group, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT); // Will be null for guests
    $stmt->execute();

    // Get inserted ID
    $analysis_id = $conn->lastInsertId();

    // Run the pipeline script with provided inputs
    $command = "python3 pipeline.py " . 
               escapeshellarg($protein_family) . " " . 
               escapeshellarg($taxonomic_group) . " " . 
               escapeshellarg($analysis_id);
    exec($command);

    // Redirect to results
    header("Location: results.php?id=" . $analysis_id);
    exit();
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    die("Something went wrong while processing your request.");
}
?>
