<?php
$error = '';
if (isset($_GET['error'])) $error = 'Invalid email or password.';
if (isset($_GET['registered'])) $error = 'Account created successfully. Please login.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Careerflow</title>

    <link rel="stylesheet" href="css/login.css">
</head>

<body>

    <!-- ================= NAVBAR ================= -->

    <nav class="navbar">

        <a href="index.php" class="logo">
            <span>Career</span>flow
        </a>

        <div class="nav-right">
            <span>Don't have an account?</span>
            <a href="register.php" class="signup-btn">
                Sign Up
            </a>
        </div>

    </nav>


    <!-- ================= LOGIN ================= -->

    <main class="login-page">

        <div class="login-container">

            <div class="login-header">

                <h1>Welcome Back</h1>

                <p>
                    Login to continue managing your job applications.
                </p>

            </div>


            <?php if ($error): ?><p style="color:<?php echo isset($_GET['registered']) ? '#16a34a' : '#dc2626'; ?>;text-align:center;margin-bottom:16px;"><?php echo $error; ?></p><?php endif; ?>
            <form class="login-form" action="actions/login_process.php" method="post">

                <!-- Email -->

                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your email"
                        required
                    >

                </div>


                <!-- Password -->

                <div class="form-group">

                    <div class="password-label">

                        <label for="password">
                            Password
                        </label>

                        <a href="#">
                            Forgot Password?
                        </a>

                    </div>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >

                </div>


                <!-- Remember -->

                <div class="remember">

                    <label>
                        <input
                            type="checkbox"
                            name="remember"
                        >

                        Remember me
                    </label>

                </div>


                <!-- Login Button -->

                <button type="submit" class="login-btn">
                    Login
                </button>

            </form>


            <!-- Register -->

            <div class="register-text">

                <span>Don't have an account?</span>

                <a href="register.php">
                    Create an account
                </a>

            </div>


            <!-- Back Home -->

            <a href="index.php" class="back-home">
                ← Back to Home
            </a>

        </div>

    </main>


    <!-- ================= FOOTER ================= -->

    <footer>

        <p>
            © 2026 Careerflow. All Rights Reserved.
        </p>

    </footer>

</body>
</html>