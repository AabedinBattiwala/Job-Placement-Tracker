<?php
require_once 'includes/auth.php'; require_once 'db.php'; require_once 'includes/functions.php';
$stmt=$conn->query('SELECT id,name,industry,location,website FROM companies ORDER BY name');
$companies=$stmt;
?>
<?php
// Frontend-only company page.
// Company records can be loaded from MySQL later.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Companies - CareerFlow</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/companies.css">
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

        <a href="companies.php" class="menu-item active">
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
            <h1>Companies</h1>
            <p class="subtitle">
                Explore and manage companies you're interested in.
            </p>
        </div>

        <a href="add_application.php" class="add-btn">
            <i class="fa-solid fa-plus"></i>
            Add Company
        </a>
    </header>

    <div class="search-section">

        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                placeholder="Search companies..."
            >
        </div>

        <select class="industry-filter">
            <option value="all">All Industries</option>
            <option value="technology">Technology</option>
            <option value="finance">Finance</option>
            <option value="consulting">Consulting</option>
            <option value="ecommerce">E-Commerce</option>
        </select>

    </div>

    <section class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fa-solid fa-building"></i>
            </div>

            <div>
                <p>Total Companies</p>
                <h2><?php echo $companies->num_rows; ?></h2>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fa-solid fa-paper-plane"></i>
            </div>

            <div>
                <p>Applied To</p>
                <h2>8</h2>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fa-solid fa-star"></i>
            </div>

            <div>
                <p>Saved Companies</p>
                <h2>5</h2>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fa-solid fa-briefcase"></i>
            </div>

            <div>
                <p>Open Positions</p>
                <h2>27</h2>
            </div>
        </div>

    </section>

    <section class="companies-card">

        <div class="card-header">
            <div>
                <h2>Companies</h2>
                <p>Companies you're tracking.</p>
            </div>

            <button type="button" class="sort-btn">
                <i class="fa-solid fa-arrow-down-wide-short"></i>
                Sort
            </button>
        </div>

        <div class="company-grid">
<?php if ($companies->num_rows===0): ?>
            <p style="padding:25px;">No companies have been added yet.</p>
<?php else: while($company=$companies->fetch_assoc()): ?>
            <div class="company-card">
                <div class="company-top">
                    <div class="company-logo"><?php echo e(strtoupper(substr($company['name'],0,1))); ?></div>
                    <button type="button" class="bookmark-btn"><i class="fa-regular fa-bookmark"></i></button>
                </div>
                <h3><?php echo e($company['name']); ?></h3>
                <p class="company-industry"><?php echo e($company['industry'] ?: 'Industry not set'); ?></p>
                <div class="company-details"><span><i class="fa-solid fa-location-dot"></i><?php echo e($company['location'] ?: 'Location not set'); ?></span></div>
                <div class="company-bottom"><span class="application-status applied">Company</span><?php if($company['website']): ?><a class="view-btn" href="<?php echo e($company['website']); ?>" target="_blank">View <i class="fa-solid fa-arrow-right"></i></a><?php endif; ?></div>
            </div>
<?php endwhile; endif; ?>
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
