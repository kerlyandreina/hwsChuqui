<?php
session_start();
$error = '';

// If there is an active session, redirect to the corresponding panel
if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
    if ($role === 'administrator') {
        header('Location: ./views/php/administrator.php');
        exit;
    } elseif ($role === 'dentist') {
        header('Location: ./views/php/dentist.php');
        exit;
    } elseif ($role === 'receptionist') {
        header('Location: ./views/php/receptionist.php');
        exit;
    }
}

$logoutMsg = '';
if (isset($_GET['logout']) && $_GET['logout'] == '1') {
    $logoutMsg = 'You have successfully logged out.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Please enter your username and password.';
    } else {
        if ($username === 'admin' && $password === 'Admin12!') {
            $_SESSION['user'] = $username;
            $_SESSION['role'] = 'administrator';
            header('Location: ./views/php/administrator.php');
            exit;
        } elseif ($username === 'dentist' && $password === 'Denti12!') {
            $_SESSION['user'] = $username;
            $_SESSION['role'] = 'dentist';
            header('Location: ./views/php/dentist.php');
            exit;
        } elseif ($username === 'reception' && $password === 'Recep12!') {
            $_SESSION['user'] = $username;
            $_SESSION['role'] = 'receptionist';
            header('Location: ./views/php/receptionist.php');
            exit;
        } else {
            $error = 'Incorrect username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Fábula Dental</title>
    <link rel="stylesheet" href="views/css/login.css">
</head>

<body>
    <header class="header">
        <ul class="nav-links">
            <li><a href="index.php">HOME</a></li>
            <li><a href="views/html/treatment.html">TREATMENTS</a></li>
        </ul>
        <div class="nav-buttons">
            <a href="index.php" class="active">SIGN IN</a>
        </div>
    </header>

    <main class="main-content">
        <img src="https://fabuladental.com/wp-content/uploads/2023/08/EMPH-42_websize.jpg" alt="Fábula Dental Background" class="bg-image">

        <div class="login-container">
            <h2>Sign In</h2>
            
            <?php if (!empty($logoutMsg)): ?>
                <div class="error-msg" style="background:#d4edda;color:#155724;border-color:#c3e6cb;"><?php echo htmlspecialchars($logoutMsg); ?></div>
            <?php endif; ?>
            
            <?php if (!empty($error)): ?>
                <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            
            <form name="loginForm" id="loginForm" method="POST" action="index.php">
                <div class="input-group">
                    <input type="text" name="username" placeholder="Username" required maxlength="20">
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required maxlength="8">
                </div>
                <button type="submit" class="login-btn">SIGN IN</button>
            </form>

            <!-- OAuth Divider -->
            <div class="oauth-divider">
                <span>or continue with</span>
            </div>

            <!-- Google OAuth Button -->
            <a href="auth/google-login.php" class="google-btn" id="googleLoginBtn">
                <svg class="google-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Continue with Google
            </a>
        </div>
    </main>

    <script src="./views/js/login-validation.js"></script>
</body>

</html>