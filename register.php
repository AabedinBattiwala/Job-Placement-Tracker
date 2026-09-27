<?php
$error = '';
if (isset($_GET['error'])) $error = htmlspecialchars($_GET['error']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign Up - Careerflow</title>

    <link rel="stylesheet" href="css/register.css">
</head>

<body>

    <!-- =========================
         NAVBAR
         ========================= -->

    <nav class="navbar">

        <a href="index.php" class="logo">
            <span>Career</span>flow
        </a>

        <div class="nav-right">

            <span>Already have an account?</span>

            <a href="login.php" class="login-link">
                Login
            </a>

        </div>

    </nav>


    <!-- =========================
         SIGNUP PAGE
         ========================= -->

    <main class="signup-page">

        <div class="signup-container">


            <!-- HEADER -->

            <div class="signup-header">

                <h1>Create an Account</h1>

                <p>
                    Start managing your job applications with Careerflow.
                </p>

            </div>


            <!-- =========================
                 GOOGLE SIGNUP
                 ========================= -->

            <div class="google-login">

                <button type="button" class="google-btn">

                    <span class="google-icon">
                        G
                    </span>

                    <span>
                        Sign up with Google
                    </span>

                </button>

            </div>


            <!-- DIVIDER -->

            <div class="divider">

                <span>or</span>

            </div>


            <!-- =========================
                 SIGNUP FORM
                 ========================= -->

            <?php if ($error): ?><p style="color:#dc2626;text-align:center;margin-bottom:16px;"><?php echo $error; ?></p><?php endif; ?>
            <form class="signup-form" action="actions/register_process.php" method="post">


                <!-- FULL NAME -->

                <div class="form-group">

                    <label for="name">
                        Full Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Enter your full name"
                        required
                    >

                </div>


                <!-- EMAIL -->

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


                <!-- PASSWORD -->

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Create a password"
                        required
                    >

                </div>


                <!-- CONFIRM PASSWORD -->

                <div class="form-group">

                    <label for="confirm-password">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        id="confirm-password"
                        name="confirm_password"
                        placeholder="Confirm your password"
                        required
                    >

                </div>


                <!-- TERMS -->

                <div class="terms">

                    <label>

                        <input
                            type="checkbox"
                            name="terms"
                            required
                        >

                        <span>
                            I agree to the Terms & Conditions
                        </span>

                    </label>

                </div>


                <!-- CREATE ACCOUNT BUTTON -->

                <button
                    type="submit"
                    class="signup-btn"
                >
                    Create Account
                </button>


            </form>


            <!-- LOGIN TEXT -->

            <div class="login-text">

                <span>
                    Already have an account?
                </span>

                <a href="login.php">
                    Login
                </a>

            </div>


            <!-- BACK HOME -->

            <a href="index.php" class="back-home">
                ← Back to Home
            </a>


        </div>

    </main>


    <!-- =========================
         FOOTER
         ========================= -->

    <footer>

        <p>
            © 2026 Careerflow. All Rights Reserved.
        </p>

    </footer>


</body>

</html>