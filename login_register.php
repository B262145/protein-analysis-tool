<?php
require __DIR__ . '/auth.php';

// Redirect logged-in users
if (is_logged_in()) {
    header("Location: index.php");
    exit();
}

require __DIR__ . '/includes/header.php';
?>

<div class="container">
    <h1>Welcome to Protein Analysis</h1>
    
    <!-- Tab switch for login/register -->
    <div class="auth-tabs">
        <button class="tab-btn active" data-tab="login">Login</button>
        <button class="tab-btn" data-tab="register">Register</button>
    </div>

    <!-- Error message display -->
    <?php if (isset($_SESSION['auth_error'])): ?>
        <div class="alert error">
            <?= htmlspecialchars($_SESSION['auth_error']) ?>
            <?php unset($_SESSION['auth_error']) ?>
        </div>
    <?php endif; ?>

    <!-- Login form -->
    <form id="login-form" class="auth-form" action="auth_login_register.php?action=login" method="post">
        <div class="form-group">
            <label>Username or Email:</label>
            <input type="text" name="credential" required>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn">Login</button>
    </form>

    <!-- Registration form (hidden by default) -->
    <form id="register-form" class="auth-form" action="auth_login_register.php?action=register" method="post" style="display:none">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" required minlength="3">
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required minlength="8">
        </div>
        <button type="submit" class="btn">Register</button>
    </form>

    <!-- Smart login hint -->
    <div class="smart-login-hint">
        <p>Don't remember if you have an account? Just try logging in.</p>
        <p>If the username doesn't exist, we'll create a new account automatically.</p>
    </div>
</div>

<!-- Frontend logic for tab switching -->
<script>
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        // Switch tab styles
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        
        // Toggle form visibility
        document.getElementById('login-form').style.display = 
            btn.dataset.tab === 'login' ? 'block' : 'none';
        document.getElementById('register-form').style.display = 
            btn.dataset.tab === 'register' ? 'block' : 'none';
    });
});
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
