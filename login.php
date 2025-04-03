<?php
include 'includes/session.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username && $password) {
        // Check if the user exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // User exists: verify password
            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit();
            } else {
                $message = "Incorrect password.";
            }
        } else {
            // User does not exist: register
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)");
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $hash, PDO::PARAM_STR);
            $stmt->execute();

            $new_user_id = $conn->lastInsertId();
            $_SESSION['user_id'] = $new_user_id;
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container">
    <h1>Login or Register</h1>
    <?php if ($message): ?>
        <p style="color: red;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" required />
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required />
        </div>
        <button type="submit" class="btn">Submit</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
