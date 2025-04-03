<?php
/**
 * Handles both login and registration
 * Auto-registers new users
 */
require __DIR__ . '/auth.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

try {
    // Check if user exists
    $stmt = db()->prepare("SELECT id, password_hash FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        // Existing user - verify password
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            header("Location: " . ($_SESSION['redirect_url'] ?? 'index.php'));
            exit();
        } else {
            $_SESSION['auth_error'] = "Incorrect password";
            header("Location: login.php");
            exit();
        }
    } else {
        // New user - auto register
        $stmt = db()->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
        $stmt->execute([
            $username,
            password_hash($password, PASSWORD_BCRYPT)
        ]);
        
        $_SESSION['user_id'] = db()->lastInsertId();
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    }
} catch (PDOException $e) {
    error_log("Auth error: " . $e->getMessage());
    $_SESSION['auth_error'] = "System error. Please try again.";
    header("Location: login.php");
    exit();
}
?>
