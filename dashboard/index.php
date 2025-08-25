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
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .dashboard-header {
            background: linear-gradient(135deg, var(--accent-color), var(--hover-color));
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .dashboard-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .logout-btn {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #c82333, #bd2130);
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Welcome, <?php echo htmlspecialchars($firstname); ?>!</h1>
            <p>You have successfully logged into your secure account.</p>
        </div>

        <div class="dashboard-content">
            <h2>Account Information</h2>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($firstname); ?></p>
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