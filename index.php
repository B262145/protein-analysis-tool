<?php include 'includes/header.php'; ?>

<div class="container">
    <h1>Protein Sequence Analysis</h1>
    <form action="process.php" method="post">
        <div class="form-group">
            <label for="protein_family">Protein Family:</label>
            <input type="text" id="protein_family" name="protein_family" required>
        </div>
        <div class="form-group">
            <label for="taxonomic_group">Taxonomic Group:</label>
            <input type="text" id="taxonomic_group" name="taxonomic_group" required>
        </div>
        <button type="submit" class="btn">Analyze</button>
    </form>

    <p><a href="example_dataset.php" class="btn fixed-width">Try with example dataset</a></p>

    <!-- Link to View History -->
    <p><a href="history.php" class="btn fixed-width">View Analysis History</a></p>
</div>

<?php include 'includes/footer.php'; ?>
