<?php
// Include the header file to maintain consistent layout across pages
include 'includes/header.php';
?>

<div class="container">
    <!-- Main heading for the page -->
    <h1>Protein Sequence Analysis</h1>

    <!-- Form to collect user input for protein family and taxonomic group -->
    <form action="process.php" method="post">
        <!-- Input field for Protein Family -->
        <div class="form-group">
            <label for="protein_family">Protein Family:</label>
            <input type="text" id="protein_family" name="protein_family" required>
        </div>

        <!-- Input field for Taxonomic Group -->
        <div class="form-group">
            <label for="taxonomic_group">Taxonomic Group:</label>
            <input type="text" id="taxonomic_group" name="taxonomic_group" required>
        </div>

        <!-- Submit button to trigger the analysis -->
        <button type="submit" class="btn">Analyze</button>
    </form>

    <!-- Link to try the analysis with an example dataset -->
    <p><a href="example_dataset.php" class="btn fixed-width">Try with example dataset</a></p>

    <!-- Link to view the analysis history -->
    <p><a href="history.php" class="btn fixed-width">View Analysis History</a></p>
</div>

<?php
// Include the footer file to maintain consistent layout across pages
include 'includes/footer.php';
?>
