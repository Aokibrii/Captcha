<?php
session_start();

if (isset($_GET['show']) && $_GET['show'] === 'signup') {
    header("Location: login.php");
    exit();
}

// Handle error messages
$error_message = "";

if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'empty_fields':
            $error_message = "Please fill in all fields.";
            break;
        case 'password_mismatch':
            $error_message = "Passwords do not match.";
            break;
        case 'password_too_short':
            $error_message = "Password must be at least 8 characters long.";
            break;
        case 'email_exists':
            $error_message = "An account with this email already exists.";
            break;
        case 'registration_failed':
            $error_message = "Registration failed. Please try again.";
            break;
        case 'recaptcha_failed':
        case 'math_captcha_failed':
            $error_message = "Incorrect answer to the math question.";
            break;
        default:
            $error_message = "An error occurred. Please try again.";
    }
}

// Generate math question (addition, subtraction, or division)
$min = 1;
$max = 10;
$operators = ['+', '-', '÷'];
$operator = $operators[array_rand($operators)];

if ($operator === '+') {
    $a = rand($min, $max);
    $b = rand($min, $max);
    $answer = $a + $b;
    $question = "$a + $b = ?";
} elseif ($operator === '-') {
    $a = rand($min, $max);
    $b = rand($min, $max);
    // Ensure non-negative result
    if ($a < $b) {
        [$a, $b] = [$b, $a];
    }
    $answer = $a - $b;
    $question = "$a - $b = ?";
} else { // Division (ensure whole number)
    $b = rand($min, $max);
    $answer = rand($min, $max);
    $a = $b * $answer;
    $question = "$a ÷ $b = ?";
}

$_SESSION['math_captcha_answer'] = $answer;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up - SecuredLogin</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>" />
    <link rel="icon" href="../assets/images/lock.png">
    <script type="text/javascript" src="../assets/js/validation.js" defer></script>
</head>

<body>
    <div class="container-flex">
        <div class="wrapper">
            <h1>Sign Up</h1>
            <p id="error-message" class="<?php echo $error_message ? 'error' : ''; ?>"><?php echo htmlspecialchars($error_message); ?></p>
            <form id="form" action="../includes/auth_handler.php" method="POST">
                <div>
                    <label for="name-input">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            height="24"
                            viewBox="0 -960 960 960"
                            width="24">
                            <path
                                d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z" />
                        </svg>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name-input"
                        placeholder="Full Name" />
                </div>
                <div>
                    <label for="email-input">
                        <span>@</span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email-input"
                        placeholder="Email" />
                </div>
                <div>
                    <label for="password-input">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            height="24"
                            viewBox="0 -960 960 960"
                            width="24">
                            <path
                                d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z" />
                        </svg>
                    </label>
                    <div class="password-container">
                        <input
                            type="password"
                            name="password"
                            id="password-input"
                            placeholder="Password" />
                        <img src="/SecuredLogin/assets/icons/eye-close1.png" id="toggle-password-visibility" alt="Toggle Password Visibility">
                    </div>
                </div>
                <div>
                    <label for="repeat-password-input">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            height="24"
                            viewBox="0 -960 960 960"
                            width="24">
                            <path
                                d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z" />
                        </svg>
                    </label>
                    <div class="password-container">
                        <input
                            type="password"
                            name="repeat-password"
                            id="repeat-password-input"
                            placeholder="Repeat Password" />
                        <img src="/SecuredLogin/assets/icons/eye-close1.png" id="toggle-repeat-password-visibility" alt="Toggle Repeat Password Visibility">
                    </div>
                </div>
                <div class="checkbox-container">
                    <input type="checkbox" id="show-math-modal" name="show-math-modal">
                    <label for="show-math-modal">Click the Checkbox to Register your Account</label>
                </div>
                <input type="hidden" name="math-answer" id="math-answer-hidden" value="">
                <button type="submit" name="signup" id="signup-btn" disabled>Register</button>
            </form>
            <p>Already have an Account? <a href="login.php">login</a> </p>
        </div>
    </div>

    <!-- Math Modal -->
    <div id="math-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Math Verification</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <p>Please solve this math problem to register your account</p>
                <div class="math-question">
                    <span id="math-question" data-question="<?php echo $question; ?>" data-answer="<?php echo $answer; ?>"><?php echo $question; ?></span>
                </div>
                <div class="math-options-container" id="math-options">
                    <!-- Options will be generated by JavaScript -->
                </div>
                <input type="hidden" name="math-answer" id="math-answer" value="">
                <div class="loader" id="math-loader"></div>
                <div class="modal-buttons">
                    <button type="button" id="verify-math">Verify</button>
                    <button type="button" id="reset-math">Reset</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="confirmation-modal">
        <div class="confirmation-content">
            <h3>Reset Math Question</h3>
            <p>Are you sure you want to reset the math question? This will generate a new question.</p>
            <div class="confirmation-buttons">
                <button type="button" id="confirm-reset">Yes, Reset</button>
                <button type="button" id="cancel-reset">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="success-modal" class="success-modal">
        <div class="success-content">
            <div class="success-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                </svg>
            </div>
            <h3>Verification Successful!</h3>
            <p>Math verification completed successfully. You can now proceed with your registration.</p>
            <div class="success-buttons">
                <button type="button" id="continue-signup">Continue</button>
            </div>
        </div>
    </div>

    <script src="../assets/js/signup.js" defer></script>
</body>

</html>