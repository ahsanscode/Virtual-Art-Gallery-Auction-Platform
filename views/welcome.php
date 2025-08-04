<?php include 'header.php'; ?>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</h2>
    <p>
        You are logged in as <b><?php echo htmlspecialchars($_SESSION['user']['role']); ?></b>.<br>
        <a href="index.php?action=logout">Logout</a>
    </p>
<?php include 'footer.php'; ?>