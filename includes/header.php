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
                <li><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>">Home</a></li>
                <li><a href="history.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'history.php' ? 'active' : ''; ?>">History</a></li>
                <li><a href="example_dataset.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'example_dataset.php' ? 'active' : ''; ?>">Example Dataset</a></li>
                <li><a href="statement_of_credits.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'statement_of_credits.php' ? 'active' : ''; ?>">Credits</a></li>
                <li><a href="help_context.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'help_context.php' ? 'active' : ''; ?>">Help</a></li>
                <li><a href="about.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'about.php' ? 'active' : ''; ?>">About</a></li>
            </ul>
        </nav>
    </header>
