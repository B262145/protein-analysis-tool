<?php include 'includes/header.php'; ?>

<div class="container">
    <h1>Analysis Results</h1>
    <?php
    include 'db_connect.php';

    try {
        // Prepare the SQL statement to fetch the latest analysis result
        $stmt = $conn->prepare("SELECT * FROM records ORDER BY id DESC LIMIT 1");
        $stmt->execute();

        // Fetch the result as an associative array
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Define file paths
            $plot_file = "conservation_plot.1.png";
            $motifs_file = "motif_results.txt";
            $sequences_file = "sequences.fasta";
            $aligned_file = "aligned_sequences.fasta";
            $report_file = "bioinformatics_report.csv";
            $pepstats_file = "pepstats_results.txt"; 

            // Check if all required files exist
            if (file_exists($plot_file) && file_exists($motifs_file) && file_exists($sequences_file) && file_exists($aligned_file) && file_exists($report_file) && file_exists($pepstats_file)) {
                // Display the results
                echo "<p>Protein Family: " . htmlspecialchars($row['protein_family']) . "</p>";
                echo "<p>Taxonomic Group: " . htmlspecialchars($row['taxonomic_group']) . "</p>";

                // Display sequences.fasta
                echo "<h3>Protein Sequences</h3>";
                echo "<pre>" . htmlspecialchars(file_get_contents($sequences_file)) . "</pre>";
                echo "<p><a href='$sequences_file' download>Download Sequences</a></p>";

                // Display aligned_sequences.fasta
                echo "<h3>Aligned Sequences</h3>";
                echo "<pre>" . htmlspecialchars(file_get_contents($aligned_file)) . "</pre>";
                echo "<p><a href='$aligned_file' download>Download Aligned Sequences</a></p>";

                // Display conservation plot
                echo "<h3>Conservation Plot</h3>";
                echo "<img src='$plot_file' alt='Conservation Plot'>";
                echo "<p><a href='$plot_file' download>Download Conservation Plot</a></p>"; 

                // Display motifs results
                echo "<h3>Motif Analysis Results</h3>";
                echo "<pre>" . htmlspecialchars(file_get_contents($motifs_file)) . "</pre>";
                echo "<p><a href='$motifs_file' download>Download Motif Analysis Results</a></p>";

                // Display PEPSTATS results
                echo "<h3>Protein Properties Analysis</h3>";
                echo "<pre>" . htmlspecialchars(file_get_contents($pepstats_file)) . "</pre>";
                echo "<p><a href='$pepstats_file' download>Download Protein Properties Analysis</a></p>";

                // Display bioinformatics_report.csv
                echo "<h3>Analysis Report</h3>";
                // Open the CSV file
                if (($handle = fopen($report_file, "r")) !== FALSE) {
                    echo "<table border='1' cellspacing='0' cellpadding='5'>";
                    // Read and display each row
                    $header = true;
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        echo "<tr>";
                        foreach ($data as $cell) {
                            echo $header ? "<th>" . htmlspecialchars($cell) . "</th>" : "<td>" . htmlspecialchars($cell) . "</td>";
                        }
                        echo "</tr>";
                        $header = false; // Switch to <td> after the first row
                    }
                    echo "</table>";
                    fclose($handle);
                }
                echo "<p><a href='$report_file' download>Download Analysis Report</a></p>";
            } else {
                // If any file is missing, show "No analysis results found."
                echo "<p>No analysis results found.</p>";
            }
        } else {
            echo "<p>No analysis results found.</p>";
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo "<p>Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    ?>
</div>

<?php include 'includes/footer.php'; ?>
