<?php
// Set the maximum execution time for the script to 600 seconds (10 minutes)
ini_set('max_execution_time', 600);

include 'db_connect.php';

// Get user input from the form
$protein_family = $_POST['protein_family'];
$taxonomic_group = $_POST['taxonomic_group'];

// Insert the analysis into the database and get the ID
try {
    $stmt = $conn->prepare("INSERT INTO records (protein_family, taxonomic_group) VALUES (:protein_family, :taxonomic_group)");
    $stmt->bindValue(':protein_family', $protein_family, PDO::PARAM_STR);
    $stmt->bindValue(':taxonomic_group', $taxonomic_group, PDO::PARAM_STR);
    $stmt->execute();

    // Get the last inserted ID
    $analysis_id = $conn->lastInsertId();

    // Execute the Python pipeline with the analysis ID
    $command = "python3 pipeline.py " . escapeshellarg($protein_family) . " " . escapeshellarg($taxonomic_group) . " " . escapeshellarg($analysis_id);
    $output = exec($command);

    // Redirect to the results page
    header("Location: results.php?id=" . $analysis_id);
    exit();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
