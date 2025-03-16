<?php include 'includes/header.php'; ?>

<div class="container">
    <h1>Example Dataset</h1>

    <?php
    // Define file paths for the example dataset
    $example_plot_file = "example/conservation_plot.1.png";
    $example_motifs_file = "example/motif_results.txt";
    $example_sequences_file = "example/sequences.fasta";
    $example_aligned_file = "example/aligned_sequences.fasta";
    $example_report_file = "example/bioinformatics_report.csv";
    $example_pepstats_file = "example/pepstats_results.txt";

    // Check if all required example files exist
    if (file_exists($example_plot_file) && file_exists($example_pepstats_file) && file_exists($example_motifs_file) && file_exists($example_sequences_file) && file_exists($example_aligned_file) && file_exists($example_report_file)) {
        // Display the example dataset
        echo "<p>Using glucose-6-phosphatase proteins from Aves.</p>";

        // Display example sequences.fasta
        echo "<h3>Example Protein Sequences</h3>";
        echo "<pre>" . htmlspecialchars(file_get_contents($example_sequences_file)) . "</pre>";
        echo "<p><a href='$example_sequences_file' download>Download Example Sequences</a></p>";

        // Display example aligned_sequences.fasta
        echo "<h3>Example Aligned Sequences</h3>";
        echo "<pre>" . htmlspecialchars(file_get_contents($example_aligned_file)) . "</pre>";
        echo "<p><a href='$example_aligned_file' download>Download Example Aligned Sequences</a></p>";

        // Display example conservation plot
        echo "<h3>Example Conservation Plot</h3>";
        echo "<img src='$example_plot_file' alt='Example Conservation Plot'>";
        echo "<p><a href='$example_plot_file' download>Download Example Conservation Plot</a></p>";

        // Display example motifs results
        echo "<h3>Example Motif Analysis Results</h3>";
        echo "<pre>" . htmlspecialchars(file_get_contents($example_motifs_file)) . "</pre>";
        echo "<p><a href='$example_motifs_file' download>Download Example Motif Analysis Results</a></p>";

        // Display example PEPSTATS results
        echo "<h3>Example Protein Properties Analysis</h3>";
        echo "<pre>" . htmlspecialchars(file_get_contents($example_pepstats_file)) . "</pre>";
        echo "<p><a href='$example_pepstats_file' download>Download Example Protein Properties Analysis</a></p>";

        // Display example bioinformatics_report.csv
        echo "<h3>Example Analysis Report</h3>";
        // Open the CSV file
        if (($handle = fopen($example_report_file, "r")) !== FALSE) {
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
        // Provide a download link
        echo "<p><a href='$example_report_file' download>Download Example Analysis Report</a></p>";
    } else {
        // If any example file is missing, show "No example dataset found."
        echo "<p>No example dataset found.</p>";
    }
    ?>

</div>

<?php include 'includes/footer.php'; ?>
