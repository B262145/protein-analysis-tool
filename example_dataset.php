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

    echo "<p>Using glucose-6-phosphatase proteins from Aves.</p>";

    // Display each file individually, report if not found
    // Display example sequences.fasta
    if (file_exists($example_sequences_file)) {
        echo "<h3>Example Protein Sequences</h3>";
        echo "<pre>" . htmlspecialchars(file_get_contents($example_sequences_file)) . "</pre>";
        echo "<p><a href='$example_sequences_file' download>Download Example Sequences</a></p>";
    } else {
        echo "<p>Example Protein Sequences file not found.</p>";
    }

    // Display example aligned_sequences.fasta
    if (file_exists($example_aligned_file)) {
        echo "<h3>Example Aligned Sequences</h3>";
        echo "<pre>" . htmlspecialchars(file_get_contents($example_aligned_file)) . "</pre>";
        echo "<p><a href='$example_aligned_file' download>Download Example Aligned Sequences</a></p>";
    } else {
        echo "<p>Example Aligned Sequences file not found.</p>";
    }

    // Display example conservation plot
    if (file_exists($example_plot_file)) {
        echo "<h3>Example Conservation Plot</h3>";
        echo "<img src='$example_plot_file' alt='Example Conservation Plot'>";
        echo "<p><a href='$example_plot_file' download>Download Example Conservation Plot</a></p>";
    } else {
        echo "<p>Example Conservation Plot file not found.</p>";
    }

    // Display example motifs results
    if (file_exists($example_motifs_file)) {
        echo "<h3>Example Motif Analysis Results</h3>";
        echo "<pre>" . htmlspecialchars(file_get_contents($example_motifs_file)) . "</pre>";
        echo "<p><a href='$example_motifs_file' download>Download Example Motif Analysis Results</a></p>";
    } else {
        echo "<p>Example Motif Analysis Results file not found.</p>";
    }

    // Display example PEPSTATS results
    if (file_exists($example_pepstats_file)) {
        echo "<h3>Example Protein Properties Analysis</h3>";
        echo "<pre>" . htmlspecialchars(file_get_contents($example_pepstats_file)) . "</pre>";
        echo "<p><a href='$example_pepstats_file' download>Download Example Protein Properties Analysis</a></p>";
    } else {
        echo "<p>Example Protein Properties Analysis file not found.</p>";
    }

    // Display example bioinformatics_report.csv
    if (file_exists($example_report_file)) {
        echo "<h3>Example Analysis Report</h3>";
        if (($handle = fopen($example_report_file, "r")) !== FALSE) {
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
        echo "<p><a href='$example_report_file' download>Download Example Analysis Report</a></p>";
    } else {
        echo "<p>Example Analysis Report file not found.</p>";
    }
    ?>

</div>

<?php include 'includes/footer.php'; ?>
