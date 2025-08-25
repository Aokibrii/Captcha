<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../auth/login.php");
    exit();
}

$name = $_SESSION['name'] ?? 'User';
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SecuredLogin</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Welcome, <?php echo htmlspecialchars($name); ?>!</h1>
            <p>You have successfully logged into your secure account.</p>
        </div>

        <div class="dashboard-content">
            <h2>Account Information</h2>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
            <p><strong>Login Time:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>

            <h3>Security Features</h3>
            <ul>
                <li>✅ Math verification completed</li>
                <li>✅ Password securely hashed</li>
                <li>✅ Session management active</li>
                <li>✅ SQL injection protection</li>
            </ul>

            <a href="../includes/logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</body>

</html>