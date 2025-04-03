<?php
/**
 * Main Application Page
 * Shows analysis form for logged-in users
 * Shows login prompt for guests
 */
require __DIR__ . '/auth.php';
require __DIR__ . '/includes/header.php';
?>

<div class="container">
    <h1>Protein Sequence Analysis</h1>

    <?php if (Auth::is_logged_in()): ?>
        <!-- Analysis Form for logged-in users -->
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

        <div class="action-links">
            <a href="example_dataset.php" class="btn fixed-width">Try example dataset</a>
            <a href="history.php" class="btn fixed-width">View History</a>
        </div>
    <?php else: ?>
        <!-- Guest Message -->
        <div class="guest-notice">
            <h2>Please log in to unlock full functionality. Guests can only view the example dataset.</h2>
            <div class="auth-actions">
                <a href="login.php" class="btn fixed-width">Login/Register</a>
            </div>
            <div class="action-links">
            <a href="example_dataset.php" class="btn fixed-width">Try example dataset</a> 
            <div> 
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
