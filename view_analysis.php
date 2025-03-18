<?php include 'includes/header.php'; ?>

<div class="container">
    <h1>Analysis Details</h1>
    <?php
    include 'db_connect.php';

    // Get analysis ID from URL
    $id = $_GET['id'] ?? null;

    if ($id) {
        try {
            // Fetch the analysis from the database
            $stmt = $conn->prepare("SELECT * FROM records WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $analysis = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }

        if ($analysis):
            $protein_family = $analysis['protein_family'];
            $taxonomic_group = $analysis['taxonomic_group'];
            $results_dir = "analysis_{$id}";

            // Define file paths
            $plot_file = "$results_dir/conservation_plot.1.png";
            $motifs_file = "$results_dir/motif_results.txt";
            $sequences_file = "$results_dir/sequences.fasta";
            $aligned_file = "$results_dir/aligned_sequences.fasta";
            $report_file = "$results_dir/bioinformatics_report.csv";
            $pepstats_file = "$results_dir/pepstats_results.txt";

            // Check if all required files exist
            if (file_exists($plot_file) && file_exists($motifs_file) && file_exists($sequences_file) && file_exists($aligned_file) && file_exists($report_file) && file_exists($pepstats_file)) {
                // Display the results
                echo "<h2>Protein Family: " . htmlspecialchars($protein_family) . "</h2>";
                echo "<h2>Taxonomic Group: " . htmlspecialchars($taxonomic_group) . "</h2>";

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
                if (($handle = fopen($report_file, "r")) !== FALSE) {
                    echo "<table border='1' cellspacing='0' cellpadding='5'>";
                    $header = true;
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        echo "<tr>";
                        foreach ($data as $cell) {
                            echo $header ? "<th>" . htmlspecialchars($cell) . "</th>" : "<td>" . htmlspecialchars($cell) . "</td>";
                        }
                        echo "</tr>";
                        $header = false;
                    }
                    echo "</table>";
                    fclose($handle);
                }
                echo "<p><a href='$report_file' download>Download Analysis Report</a></p>";
            } else {
                echo "<p>No analysis results found.</p>";
            }
        else:
            echo "<p>Analysis not found.</p>";
        endif;
    } else {
        echo "<p>Invalid analysis ID.</p>";
    }
    ?>

    <!-- Back to History Link -->
    <p><a href="history.php" class="btn">Back to History</a></p>
</div>

<?php include 'includes/footer.php'; ?>
