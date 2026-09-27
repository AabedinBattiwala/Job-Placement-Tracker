<?php
require_once 'includes/auth.php';
require_once 'db.php';
require_once 'includes/functions.php';
$applicationId = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare('SELECT * FROM applications WHERE id=? AND user_id=?');
$stmt->bind_param('ii', $applicationId, $_SESSION['user_id']);
$stmt->execute();
$application = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$application) { header('Location: applications.php'); exit; }
?>
<?php
// Frontend-only edit page.
// Later, load the application using $_GET["id"] and save it to MySQL.
$applicationId = isset($_GET["id"]) ? $_GET["id"] : "1";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Application - CareerFlow</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/Editapplication.css">
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
            <h1>Edit Application</h1>
            <p class="subtitle">
                Update the details of your job application.
            </p>
        </div>
    </header>

    <section class="application-form-card">

        <div class="form-header">
            <div class="form-icon">
                <i class="fa-solid fa-pen"></i>
            </div>

            <div>
                <h2>Application Details</h2>
                <p>Update the information for this application.</p>
            </div>
        </div>

        <form action="actions/application_save.php" method="post">

            <input type="hidden" name="id" value="<?php echo e($application['id']); ?>">

            <div class="form-grid">

                <div class="form-group">
                    <label for="company">Company Name</label>
                    <input
                        type="text"
                        id="company"
                        name="company"
                        value="<?php echo e($application['company']); ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="role">Job Role</label>
                    <input
                        type="text"
                        id="role"
                        name="role"
                        value="<?php echo e($application['role']); ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input
                        type="text"
                        id="location"
                        name="location"
                        value="<?php echo e($application['location']); ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="date">Application Date</label>
                    <input
                        type="date"
                        id="date"
                        name="date"
                        value="<?php echo e($application['application_date']); ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="Applied" <?php echo $application['status']=='Applied' ? 'selected' : ''; ?>>Applied</option>
                        <option value="Interview" <?php echo $application['status']=='Interview' ? 'selected' : ''; ?>>Interview</option>
                        <option value="Selected" <?php echo $application['status']=='Selected' ? 'selected' : ''; ?>>Selected</option>
                        <option value="Rejected" <?php echo $application['status']=='Rejected' ? 'selected' : ''; ?>>Rejected</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="jobLink">Job Link</label>
                    <input
                        type="url"
                        id="jobLink"
                        name="jobLink"
                        value="<?php echo e($application['job_link']); ?>" placeholder="https://example.com/job"
                    >
                </div>

                <div class="form-group full-width">
                    <label for="notes">Notes</label>
                    <textarea
                        id="notes"
                        name="notes"
                        placeholder="Add any notes about this application..."
                        rows="5"
                    ><?php echo e($application['notes']); ?></textarea>
                </div>

            </div>

            <div class="form-actions">
                <a href="applications.php" class="cancel-form-btn">
                    Cancel
                </a>

                <button type="submit" class="save-form-btn">
                    <i class="fa-solid fa-check"></i>
                    Save Changes
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
