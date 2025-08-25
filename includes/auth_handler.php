<?php
require_once 'config.php';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Math CAPTCHA validation
    session_start();
    $user_math_answer = isset($_POST['math-answer']) ? trim($_POST['math-answer']) : '';
    $expected_math_answer = isset($_SESSION['math_captcha_answer']) ? $_SESSION['math_captcha_answer'] : null;
    if ($expected_math_answer === null || $user_math_answer !== strval($expected_math_answer)) {
        // Determine redirect target
        if (isset($_POST['login'])) {
            header("Location: ../auth/login.php?error=math_captcha_failed");
        } else {
            header("Location: ../auth/signup.php?error=math_captcha_failed");
        }
        exit();
    }

    // Handle Login
    if (isset($_POST['login'])) {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            header("Location: ../auth/login.php?error=empty_fields");
            exit();
        }

        // Prepare SQL statement to prevent SQL injection
        $stmt = $connection->prepare("SELECT id, email, password, name FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Start session and store user data
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['name'] = $user['name'];

                header("Location: ../dashboard/index.php");
                exit();
            } else {
                header("Location: ../auth/login.php?error=invalid_credentials");
                exit();
            }
        } else {
            header("Location: ../auth/login.php?error=invalid_credentials");
            exit();
        }

        $stmt->close();
    }

    // Handle Signup
    if (isset($_POST['signup'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $repeat_password = $_POST['repeat-password'];

        // Validation
        if (empty($name) || empty($email) || empty($password) || empty($repeat_password)) {
            header("Location: ../auth/signup.php?error=empty_fields");
            exit();
        }

        if ($password !== $repeat_password) {
            header("Location: ../auth/signup.php?error=password_mismatch");
            exit();
        }

        if (strlen($password) < 8) {
            header("Location: ../auth/signup.php?error=password_too_short");
            exit();
        }

        // Check if email already exists
        $stmt = $connection->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header("Location: ../auth/signup.php?error=email_exists");
            exit();
        }
        $stmt->close();

        // Hash password and insert user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $connection->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed_password);

        if ($stmt->execute()) {
            header("Location: ../auth/login.php?success=account_created");
            exit();
        } else {
            header("Location: ../auth/signup.php?error=registration_failed");
            exit();
        }

        $stmt->close();
    }
}

$connection->close();
