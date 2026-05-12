<?php
session_start();
// Redirect to login if not logged in
if (isset($_SESSION['logged_in'])) {
    header('Location: dashboard.php');
    exit();
}
include('includes/db.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if user exists
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['logged_in'] = true;  // Set session for login status
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];  // Store user role (admin or user)
        $_SESSION['user_id'] = $user['id'];    
        // Redirect to dashboard or default page
        header('Location: dashboard.php');  // Redirect to the dashboard page
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CrazyNaters</title>
    <link rel="icon" type="image/png" href="assets/images/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../assets/images/favicon.svg" />
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png" />
    <link rel="manifest" href="assets/images/site.webmanifest" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #020617;
            --panel: rgba(7,18,45,.78);
            --panel-strong: rgba(10,24,58,.92);
            --border: rgba(0,217,255,.25);
            --border-strong: rgba(0,217,255,.48);
            --text: #eef6ff;
            --muted: #94a8cc;
            --cyan: #00d9ff;
            --blue: #1677ff;
            --purple: #7c3cff;
            --green: #00ffc8;
            --danger: #ff4d6d;
            --shadow: 0 24px 80px rgba(0,0,0,.42);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 82% 0%, rgba(124,60,255,.42), transparent 34%),
                radial-gradient(circle at 0% 15%, rgba(0,217,255,.26), transparent 28%),
                radial-gradient(circle at 50% 100%, rgba(22,119,255,.18), transparent 34%),
                linear-gradient(135deg, #020617 0%, #06122d 52%, #17075a 100%);
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(255,255,255,.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.035) 1px, transparent 1px);
            background-size: 44px 44px;
            mask-image: linear-gradient(to bottom, rgba(0,0,0,.55), transparent 82%);
        }

        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 34px;
            position: relative;
            z-index: 1;
        }

        .login-box {
            width: min(1120px, 100%);
            min-height: 680px;
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            border: 1px solid var(--border);
            border-radius: 30px;
            overflow: hidden;
            background: rgba(2,9,29,.72);
            box-shadow: var(--shadow);
            backdrop-filter: blur(22px);
            position: relative;
        }

        .login-box::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            border-radius: 30px;
            box-shadow: inset 0 1px 0 rgba(255,255,255,.08);
        }

        .column2 {
            position: relative;
            min-height: 100%;
            background-image:
                linear-gradient(135deg, rgba(2,6,23,.18), rgba(23,7,90,.2)),
                url('https://lightgrey-owl-201683.hostingersite.com/assets/images/login.png');
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }

        .column2::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 25% 20%, rgba(0,217,255,.35), transparent 26%),
                linear-gradient(180deg, rgba(2,6,23,.34), rgba(2,6,23,.82));
        }

        .column2::after {
            content: "";
            position: absolute;
            inset: 22px;
            border-radius: 24px;
            border: 1px solid rgba(255,255,255,.12);
            background: linear-gradient(180deg, rgba(255,255,255,.055), rgba(255,255,255,.015));
            backdrop-filter: blur(1px);
        }

        .visual-content {
            position: absolute;
            left: 44px;
            right: 44px;
            bottom: 46px;
            z-index: 2;
        }

        .visual-badge {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 9px 13px;
            border-radius: 999px;
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
            background: rgba(2,12,36,.66);
            border: 1px solid rgba(0,217,255,.32);
            box-shadow: 0 0 26px rgba(0,217,255,.16);
        }

        .visual-badge span {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: var(--green);
            box-shadow: 0 0 18px rgba(0,255,200,.78);
        }

        .visual-content h1 {
            margin: 18px 0 12px;
            color: #fff;
            font-size: clamp(34px, 4vw, 54px);
            line-height: .96;
            font-weight: 900;
            letter-spacing: -.06em;
        }

        .visual-content p {
            max-width: 420px;
            color: #c8d8f5;
            font-size: 15px;
            line-height: 1.7;
            margin: 0;
        }

        .column1 {
            position: relative;
            padding: 72px clamp(34px, 5vw, 76px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            background:
                radial-gradient(circle at 100% 0%, rgba(0,217,255,.14), transparent 26%),
                linear-gradient(180deg, var(--panel-strong), rgba(2,9,29,.92));
        }

        .column1::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--cyan), transparent);
            opacity: .7;
        }

        .login-logo {
            width: 68px;
            height: 68px;
            margin: 0 auto 20px;
            border-radius: 22px;
            padding: 13px;
            background: linear-gradient(135deg, var(--cyan), var(--purple));
            box-shadow: 0 0 34px rgba(0,217,255,.35), 0 16px 38px rgba(0,0,0,.28);
            object-fit: contain;
        }

        .login-eyebrow {
            color: var(--cyan);
            text-align: center;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .18em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .login-box h2 {
            margin: 0 0 10px;
            text-align: center;
            color: #fff;
            font-size: clamp(31px, 4vw, 42px);
            line-height: 1;
            font-weight: 900;
            letter-spacing: -.055em;
        }

        .login-intro {
            text-align: center;
            color: var(--muted);
            font-size: 15px;
            line-height: 1.6;
            margin: 0 auto 34px;
            max-width: 360px;
        }

        form {
            width: 100%;
        }

        .form-label {
            color: #dbeafe;
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .form-control {
            min-height: 54px;
            border-radius: 16px;
            border: 1px solid var(--border);
            background: rgba(2,12,36,.72);
            color: #fff;
            padding: 14px 16px;
            font-size: 15px;
            box-shadow: inset 0 1px 0 rgba(255,255,255,.04);
        }

        .form-control::placeholder {
            color: #7890bb;
        }

        .form-control:focus {
            background: rgba(2,12,36,.88);
            border-color: var(--cyan);
            color: #fff;
            box-shadow: 0 0 0 .22rem rgba(0,217,255,.13), 0 0 24px rgba(0,217,255,.11);
        }

        .btn-block {
            width: 100%;
            min-height: 54px;
            border-radius: 16px;
            margin-top: 8px;
            font-size: 15px;
            font-weight: 900;
            letter-spacing: .02em;
        }

        .btn-primary {
            border: 0;
            background: linear-gradient(135deg, var(--purple), var(--cyan));
            color: #fff;
            box-shadow: 0 16px 34px rgba(0,0,0,.32), 0 0 28px rgba(0,217,255,.2);
            transition: .22s ease;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            transform: translateY(-1px);
            filter: brightness(1.08);
            background: linear-gradient(135deg, var(--blue), var(--cyan));
            box-shadow: 0 18px 38px rgba(0,0,0,.36), 0 0 34px rgba(0,217,255,.28);
        }

        .alert {
            border-radius: 15px;
            border: 1px solid rgba(255,77,109,.38);
            background: rgba(255,77,109,.12);
            color: #ffd7de;
            text-align: center;
            font-weight: 700;
        }

        .secure-note {
            margin-top: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
        }

        .secure-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--green);
            box-shadow: 0 0 15px rgba(0,255,200,.7);
        }

        @media only screen and (max-width: 991px) {
            .login-page {
                padding: 22px;
            }

            .login-box {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .column2 {
                min-height: 280px;
                order: 1;
            }

            .column1 {
                order: 2;
                padding: 42px 26px;
            }

            .visual-content {
                left: 30px;
                right: 30px;
                bottom: 30px;
            }
        }

        @media only screen and (max-width: 576px) {
            .login-page {
                padding: 14px;
            }

            .login-box {
                border-radius: 22px;
            }

            .column2 {
                display: none;
            }

            .column1 {
                min-height: calc(100vh - 28px);
                padding: 36px 20px;
            }
        }
    </style>
</head>
<body>
    <main class="login-page">
        <div class="login-box">
            <div class="column2">
                <div class="visual-content">
                    <div class="visual-badge"><span></span> Admin Access</div>
                    <h1>Control your dashboard beautifully.</h1>
                    
                </div>
            </div>

            <div class="column1">
                <img src="./assets/images/logo.png" class="login-logo" alt="Guesty Login">
                <div class="login-eyebrow">CrazyNaters</div>
                <h2>Welcome Back</h2>
                <p class="login-intro">Enter your account details to continue to your dashboard.</p>

                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                    <?php if (isset($error)) { echo '<div class="alert alert-danger mt-3">'.$error.'</div>'; } ?>
                </form>

                <div class="secure-note"><span class="secure-dot"></span> Secure admin login</div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
