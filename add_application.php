<?php require_once 'includes/auth.php'; require_once 'db.php'; require_once 'includes/functions.php'; ?>
<?php
// Frontend-only page.
// Your friend can connect this form to MySQL/PHP later.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Application - CareerFlow</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/Addapplication.css">
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

        <a href="applications.php" class="menu-item active">
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
            <h1>Add Application</h1>
            <p class="subtitle">
                Add a new job application to your tracker.
            </p>
        </div>
    </header>

    <section class="application-form-card">

        <div class="form-header">
            <div class="form-icon">
                <i class="fa-solid fa-briefcase"></i>
            </div>

            <div>
                <h2>Application Details</h2>
                <p>Enter the details of the job you applied for.</p>
            </div>
        </div>

        <form action="actions/application_save.php" method="post">

            <div class="form-grid">

                <div class="form-group">
                    <label for="company">Company Name</label>
                    <input
                        type="text"
                        id="company"
                        name="company"
                        placeholder="e.g. TCS"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="role">Job Role</label>
                    <input
                        type="text"
                        id="role"
                        name="role"
                        placeholder="e.g. Software Developer"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input
                        type="text"
                        id="location"
                        name="location"
                        placeholder="e.g. Mumbai"
                    >
                </div>

                <div class="form-group">
                    <label for="date">Application Date</label>
                    <input
                        type="date"
                        id="date"
                        name="date"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="Applied">Applied</option>
                        <option value="Interview">Interview</option>
                        <option value="Selected">Selected</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="jobLink">Job Link</label>
                    <input
                        type="url"
                        id="jobLink"
                        name="jobLink"
                        placeholder="https://example.com/job"
                    >
                </div>

                <div class="form-group full-width">
                    <label for="notes">Notes</label>
                    <textarea
                        id="notes"
                        name="notes"
                        placeholder="Add any notes about this application..."
                        rows="5"
                    ></textarea>
                </div>

            </div>

            <div class="form-actions">
                <a href="applications.php" class="cancel-form-btn">
                    Cancel
                </a>

                <button type="submit" class="save-form-btn">
                    <i class="fa-solid fa-plus"></i>
                    Add Application
                </button>
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
