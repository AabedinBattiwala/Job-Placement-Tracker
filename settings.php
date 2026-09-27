<?php
require_once 'includes/auth.php'; require_once 'db.php'; require_once 'includes/functions.php';
$userId=(int)$_SESSION['user_id'];
$stmt=$conn->prepare('SELECT u.name,u.email,p.phone FROM users u LEFT JOIN profiles p ON p.user_id=u.id WHERE u.id=?'); $stmt->bind_param('i',$userId); $stmt->execute(); $account=$stmt->get_result()->fetch_assoc(); $stmt->close();
$stmt=$conn->prepare('SELECT email_notifications,application_updates,weekly_summary FROM settings WHERE user_id=?'); $stmt->bind_param('i',$userId); $stmt->execute(); $settings=$stmt->get_result()->fetch_assoc() ?: ['email_notifications'=>1,'application_updates'=>1,'weekly_summary'=>1]; $stmt->close();
?>
<?php
// Frontend-only settings page.
// Your friend can connect these controls to the database later.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - CareerFlow</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/settings.css">
</head>
<body>

<div class="app-container">

<aside class="sidebar">

    <div class="logo">
        <div class="logo-icon">
            <i class="fa-solid fa-chart-line"></i>
        </div>

        <span>
            Career<span>Flow</span>
        </span>
    </div>

    <div class="menu-section">
        <p class="menu-title">MAIN</p>

        <a href="dashboard.php" class="menu-item">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
        </a>

        <a href="applications.php" class="menu-item ">
            <i class="fa-solid fa-briefcase"></i>
            <span>Applications</span>
        </a>

        <a href="companies.php" class="menu-item ">
            <i class="fa-solid fa-building"></i>
            <span>Companies</span>
        </a>
    </div>

    <div class="menu-section account-section">
        <p class="menu-title">ACCOUNT</p>

        <a href="profile.php" class="menu-item ">
            <i class="fa-regular fa-user"></i>
            <span>Profile</span>
        </a>

        <a href="settings.php" class="menu-item active">
            <i class="fa-solid fa-gear"></i>
            <span>Settings</span>
        </a>
    </div>

    <div class="sidebar-bottom">
        <div class="help-box">
            <div class="help-icon">
                <i class="fa-solid fa-question"></i>
            </div>

            <div>
                <strong>Need help?</strong>
                <p>We're here for you.</p>
            </div>
        </div>

        <button type="button" class="logout" onclick="openLogout()">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
        </button>
    </div>
</aside>

<main class="main-content">

    <header class="page-header">
        <div>
            <p class="date">Tuesday, August 18, 2026</p>
            <h1>Settings</h1>
            <p class="subtitle">
                Manage your account preferences and settings.
            </p>
        </div>
    </header>

    <section class="settings-layout">

        <div class="settings-menu">

            <button type="button" class="settings-tab active">
                <i class="fa-regular fa-user"></i>

                <div>
                    <strong>Account</strong>
                    <span>Personal information</span>
                </div>
            </button>

            <button type="button" class="settings-tab">
                <i class="fa-solid fa-bell"></i>

                <div>
                    <strong>Notifications</strong>
                    <span>Manage notifications</span>
                </div>
            </button>

            <button type="button" class="settings-tab">
                <i class="fa-solid fa-lock"></i>

                <div>
                    <strong>Security</strong>
                    <span>Password and security</span>
                </div>
            </button>

            <button type="button" class="settings-tab">
                <i class="fa-solid fa-sliders"></i>

                <div>
                    <strong>Preferences</strong>
                    <span>Customize your experience</span>
                </div>
            </button>

        </div>

        <form class="settings-content" action="actions/settings_save.php" method="post">

            <div class="settings-card">

                <div class="settings-card-header">
                    <div>
                        <h2>Account Settings</h2>
                        <p>Update your account information.</p>
                    </div>

                    <i class="fa-regular fa-user"></i>
                </div>

                <div class="form-grid">

                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input
                            type="text"
                            id="firstName"
                            name="name"
                            value="<?php echo e($account['name']); ?>"
                            placeholder="Enter your first name"
                        >
                    </div>

                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input
                            type="text"
                            id="lastName"
                            placeholder="Enter your last name"
                        >
                    </div>

                    <div class="form-group full">
                        <label for="email">Email Address</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?php echo e($account['email']); ?>"
                            placeholder="Enter your email"
                        >
                    </div>

                    <div class="form-group full">
                        <label for="phone">Phone Number</label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            value="<?php echo e($account['phone'] ?? ""); ?>" placeholder="+91 XXXXX XXXXX"
                        >
                    </div>

                </div>

                <div class="card-footer">
                    <button type="button" class="cancel-btn">
                        Cancel
                    </button>

                    <button type="submit" class="save-btn">
                        <i class="fa-solid fa-check"></i>
                        Save Changes
                    </button>
                </div>

            </div>

            <div class="settings-card">

                <div class="settings-card-header">
                    <div>
                        <h2>Notifications</h2>
                        <p>Choose what notifications you receive.</p>
                    </div>

                    <i class="fa-regular fa-bell"></i>
                </div>

                <div class="setting-option">

                    <div>
                        <strong>Application Updates</strong>
                        <p>
                            Get notified when your application status changes.
                        </p>
                    </div>

                    <label class="switch">
                        <input type="checkbox" name="application_updates" <?php echo $settings['application_updates'] ? 'checked' : ''; ?>>
                        <span class="slider"></span>
                    </label>

                </div>

                <div class="setting-option">

                    <div>
                        <strong>Interview Reminders</strong>
                        <p>
                            Receive reminders about upcoming interviews.
                        </p>
                    </div>

                    <label class="switch">
                        <input type="checkbox" name="email_notifications" <?php echo $settings['email_notifications'] ? 'checked' : ''; ?>>
                        <span class="slider"></span>
                    </label>

                </div>

                <div class="setting-option">

                    <div>
                        <strong>CareerFlow Updates</strong>
                        <p>
                            Receive important updates and announcements.
                        </p>
                    </div>

                    <label class="switch">
                        <input type="checkbox" name="weekly_summary" <?php echo $settings['weekly_summary'] ? 'checked' : ''; ?>>
                        <span class="slider"></span>
                    </label>

                </div>

            </div>

            <div class="settings-card">

                <div class="settings-card-header">
                    <div>
                        <h2>Security</h2>
                        <p>Keep your account secure.</p>
                    </div>

                    <i class="fa-solid fa-lock"></i>
                </div>

                <div class="security-row">

                    <div>
                        <strong>Password</strong>
                        <p>Last updated recently</p>
                    </div>

                    <button type="button" class="outline-btn">
                        Change Password
                    </button>

                </div>

                <div class="security-row">

                    <div>
                        <strong>Two-Factor Authentication</strong>
                        <p>
                            Add an extra layer of security to your account.
                        </p>
                    </div>

                    <button type="button" class="outline-btn">
                        Enable
                    </button>

                </div>

            </div>

            <div class="settings-card danger-card">

                <div class="settings-card-header">
                    <div>
                        <h2>Danger Zone</h2>
                        <p>
                            Actions here can permanently affect your account.
                        </p>
                    </div>

                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>

                <div class="danger-row">

                    <div>
                        <strong>Delete Account</strong>
                        <p>
                            Permanently delete your CareerFlow account and data.
                        </p>
                    </div>

                    <button type="button" class="delete-btn">
                        Delete Account
                    </button>

                </div>

            </div>

        </div>
        </form>

    </section>

</main>

</div>

<div class="logout-overlay" id="logoutOverlay">
    <div class="logout-modal" onclick="event.stopPropagation()">

        <div class="logout-modal-icon">
            <i class="fa-solid fa-right-from-bracket"></i>
        </div>

        <h2>Logout?</h2>

        <p>
            Are you sure you want to logout from CareerFlow?
        </p>

        <div class="logout-actions">
            <button type="button" class="cancel-btn" onclick="closeLogout()">
                Cancel
            </button>

            <button type="button" class="confirm-logout-btn" onclick="confirmLogout()">
                Logout
            </button>
        </div>

    </div>
</div>

<script>
function openLogout() {
    document.getElementById("logoutOverlay").classList.add("show");
}

function closeLogout() {
    document.getElementById("logoutOverlay").classList.remove("show");
}

function confirmLogout() {
    window.location.href = "login.php";
}

document.getElementById("logoutOverlay").addEventListener("click", function () {
    closeLogout();
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
</body>
</html>
