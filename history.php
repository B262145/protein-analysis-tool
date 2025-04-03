<?php include 'includes/header.php'; ?>
<?php
// Ensure session started and DB connection is included
include 'db_connect.php';
?>

<div class="container">
    <h1>Your Analysis History</h1>

    <?php
    if (!isset($_SESSION['user_id'])) {
        // Not logged in
        echo "<p>Please <a href='login.php'>log in</a> to view your analysis history.</p>";
        include 'includes/footer.php';
        exit();
    }

    $user_id = $_SESSION['user_id'];

    try {
        // Fetch only the current user's analyses
        $stmt = $conn->prepare("SELECT * FROM records WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $analyses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }

    if (count($analyses) > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Protein Family</th>
                    <th>Taxonomic Group</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($analyses as $analysis): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($analysis['id']); ?></td>
                        <td><?php echo htmlspecialchars($analysis['protein_family']); ?></td>
                        <td><?php echo htmlspecialchars($analysis['taxonomic_group']); ?></td>
                        <td><?php echo htmlspecialchars($analysis['created_at']); ?></td>
                        <td>
                            <a href="view_analysis.php?id=<?php echo $analysis['id']; ?>" class="btn btn-primary">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No analyses found for your account yet.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
