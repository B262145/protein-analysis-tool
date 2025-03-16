<?php include 'includes/header.php'; ?>

<div class="container">
    <h1>Your Analysis History</h1>

    <?php
    include 'db_connect.php';

    // Fetch all analyses from the database
    try {
        $stmt = $conn->query("SELECT * FROM records ORDER BY created_at DESC");
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
        <p>No analyses found.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
