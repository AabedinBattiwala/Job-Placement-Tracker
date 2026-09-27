<?php
require_once 'includes/auth.php'; require_once 'db.php'; require_once 'includes/functions.php';
$userId=(int)$_SESSION['user_id'];
$stmt=$conn->prepare('SELECT u.name,u.email,p.phone,p.bio,p.education,p.skills,p.location FROM users u LEFT JOIN profiles p ON p.user_id=u.id WHERE u.id=?');
$stmt->bind_param('i',$userId); $stmt->execute(); $profile=$stmt->get_result()->fetch_assoc(); $stmt->close();
$stmt=$conn->prepare("SELECT COUNT(*) total, SUM(status='Interview') interview, SUM(status='Selected') selected FROM applications WHERE user_id=?"); $stmt->bind_param('i',$userId); $stmt->execute(); $ps=$stmt->get_result()->fetch_assoc(); $stmt->close();
?>
<?php
// Frontend-only profile page.
// Profile values can be loaded from MySQL later.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - CareerFlow</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/profile.css">
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

        <a href="profile.php" class="menu-item active">
            <i class="fa-regular fa-user"></i>
            <span>Profile</span>
        </a>

        <a href="settings.php" class="menu-item ">
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
            <h1>My Profile</h1>
            <p class="subtitle">
                Manage your personal information and career details.
            </p>
        </div>
    </header>

    <section class="profile-layout">

        <div class="profile-card">

            <div class="profile-cover"></div>

            <div class="profile-main">

                <div class="profile-avatar">
                    R
                </div>

                <h2><?php echo e($profile['name']); ?></h2>

                <p class="profile-role">
                    <?php echo e($profile['education'] ?: 'Student'); ?>
                </p>

                <p class="profile-location">
                    <i class="fa-solid fa-location-dot"></i>
                    <?php echo e($profile['location'] ?: 'Not set'); ?>
                </p>

                <a href="settings.php" class="profile-edit-btn">
                    Edit Profile
                </a>

            </div>

            <div class="profile-stats">

                <div>
                    <strong><?php echo (int)($ps['total']??0); ?></strong>
                    <span>Applications</span>
                </div>

                <div>
                    <strong><?php echo (int)($ps['interview']??0); ?></strong>
                    <span>Interviews</span>
                </div>

                <div>
                    <strong><?php echo (int)($ps['selected']??0); ?></strong>
                    <span>Selected</span>
                </div>

            </div>

        </div>

        <div class="profile-details">

            <div class="details-card">

                <div class="details-header">
                    <div>
                        <h2>Personal Information</h2>
                        <p>Your basic personal details.</p>
                    </div>

                    <i class="fa-regular fa-user"></i>
                </div>

                <div class="details-grid">

                    <div class="detail-item">
                        <span>Full Name</span>
                        <strong>Rehan</strong>
                    </div>

                    <div class="detail-item">
                        <span>Email</span>
                        <strong><?php echo e($profile['email']); ?></strong>
                    </div>

                    <div class="detail-item">
                        <span>Phone</span>
                        <strong><?php echo e($profile['phone'] ?: 'Not set'); ?></strong>
                    </div>

                    <div class="detail-item">
                        <span>Location</span>
                        <strong><?php echo e($profile['location'] ?: 'Not set'); ?></strong>
                    </div>

                </div>

            </div>

            <div class="details-card">

                <div class="details-header">
                    <div>
                        <h2>Education</h2>
                        <p>Your academic information.</p>
                    </div>

                    <i class="fa-solid fa-graduation-cap"></i>
                </div>

                <div class="education-item">

                    <div class="education-icon">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>

                    <div>
                        <h3><?php echo e($profile['education'] ?: 'Education not set'); ?></h3>
                        <p><?php echo e($profile['bio'] ?: 'CareerFlow profile'); ?></p>
                        <span>Currently Studying</span>
                    </div>

                </div>

            </div>

            <div class="details-card">

                <div class="details-header">
                    <div>
                        <h2>Skills</h2>
                        <p>Your technical skills.</p>
                    </div>

                    <i class="fa-solid fa-code"></i>
                </div>

                <div class="skills">
                    <span>HTML</span>
                    <span>CSS</span>
                    <span>JavaScript</span>
                    <span>React</span>
                    <span>MongoDB</span>
                    <span>Node.js</span>
                </div>

            </div>

        </div>

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
