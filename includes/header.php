<?php include_once 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protein Analysis</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>

<div class="header-image">
    <img src="images/Credit_iStock.png" alt="Credit iStock">
</div>

<header>
    <nav>
        <a href="index.php" class="logo">Protein Analysis</a>
        <ul>
            <?php
            $current = basename($_SERVER['PHP_SELF']);
            function nav_link($file, $label) {
                global $current;
                $active = $current === $file ? 'active' : '';
                echo "<li><a href=\"$file\" class=\"$active\">$label</a></li>";
            }

            nav_link("index.php", "Home");
            nav_link("history.php", "History");
            nav_link("example_dataset.php", "Example");
            nav_link("statement_of_credits.php", "Credits");
            nav_link("help_context.php", "Help");
            nav_link("about.php", "About");

            if (isset($_SESSION['user_id'])) {
                echo "<li><a href=\"#\">Welcome, " . htmlspecialchars($_SESSION['username']) . "</a></li>";
                echo "<li><a href=\"logout.php\">Logout</a></li>";
            } else {
                nav_link("login.php", "Login");
            }
            ?>
        </ul>
    </nav>
</header>
