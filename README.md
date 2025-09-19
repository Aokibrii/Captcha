<div align="center">

<h1>SecuredLogin</h1>

<p>
  <img alt="PHP" src="https://img.shields.io/badge/PHP-8%2B-777BB4?logo=php&logoColor=white" />
  <img alt="XAMPP" src="https://img.shields.io/badge/XAMPP-Apache%20%2B%20PHP-FB7A24?logo=apache&logoColor=white" />
  <img alt="License" src="https://img.shields.io/badge/License-MIT-2ea44f?logo=opensourceinitiative&logoColor=white" />
  <img alt="Status" src="https://img.shields.io/badge/Status-Active-success?logo=github" />
  <img alt="Made with JS" src="https://img.shields.io/badge/Made%20with-JavaScript-F7DF1E?logo=javascript&logoColor=000" />
</p>

<p>A front‑end enhanced PHP authentication demo with a math captcha for human verification.</p>

</div>

## ✨ Features
- **Math captcha** with multiple operations (+, −, ×, ÷, %, ^, √)
- **Modal-based verification** with dynamic multiple-choice options
- **Login and Signup** flows
- **Server-side validation** (session-backed)

## ⚙️ Requirements
- PHP 8.0+ (works with XAMPP on Windows)
- A local web server (e.g., XAMPP Apache) serving this folder

## 🚀 Getting Started
1. Copy this folder to your web root. On XAMPP (Windows), that’s typically:
   `C:\xampp\htdocs\SecuredLogin`
2. Start Apache in XAMPP.
3. Open the app in your browser:
   - Login: `http://localhost/SecuredLogin/auth/login.php`
   - Signup: `http://localhost/SecuredLogin/auth/signup.php`

## 🧮 How the Math Captcha Works
- Server generates a random math problem and stores the answer in the session:
  - File: `auth/generate_math.php`
- The UI fetches a new question and renders multiple-choice options:
  - Files: `assets/js/login.js`, `assets/js/signup.js`
  - Function used to refresh: `generateNewMathQuestion()`
- On verify:
  - If correct: success modal is shown and hidden input `math-answer` is set.
  - If incorrect: a new question is automatically fetched.
- On form POST (login/signup), the server validates the submitted `math-answer` against `$_SESSION['math_captcha_answer']`:
  - File: `includes/auth_handler.php`

## 🗂️ Key Files
- `auth/login.php`, `auth/signup.php`: Pages with the math verification modal.
- `auth/generate_math.php`: Returns JSON `{ question, answer }` and sets the session answer.
- `includes/math_questions.php`: Question/answer generation helper (session set).
- `includes/auth_handler.php`: Verifies posted math answer on submit.
- `assets/js/login.js`, `assets/js/signup.js`: Front-end logic for the modal and verification.
- `assets/css/style.css`: Styling for the UI and modals.

## 📌 Notes
- Ensure sessions are enabled; pages that depend on captcha start a session before using `$_SESSION`.
- Do not trust client-side values. The server must verify the posted `math-answer`.
- If you rename directories or move files, update fetch paths in JS (e.g., `fetch("generate_math.php")`).

## 🤝 Contributing
1. Fork and clone the repo.
2. Make changes in a feature branch.
3. Test locally via your web server.
4. Open a pull request.

## 📝 License
MIT (or your preferred license). Replace this section if different.
