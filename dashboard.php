<?php
require_once 'includes/auth.php';
require_once 'db.php';
require_once 'includes/functions.php';
$userId=(int)$_SESSION['user_id'];
$userName=$_SESSION['user_name'] ?? 'User';
$stmt=$conn->prepare("SELECT COUNT(*) total, SUM(status='Applied') applied, SUM(status='Interview') interview, SUM(status='Selected') selected, SUM(status='Rejected') rejected FROM applications WHERE user_id=?");
$stmt->bind_param('i',$userId); $stmt->execute(); $stats=$stmt->get_result()->fetch_assoc(); $stmt->close();
$total=(int)($stats['total']??0); $applied=(int)($stats['applied']??0); $interview=(int)($stats['interview']??0); $selected=(int)($stats['selected']??0); $rejected=(int)($stats['rejected']??0);
$stmt=$conn->prepare('SELECT company, role, application_date, status FROM applications WHERE user_id=? ORDER BY application_date DESC, id DESC LIMIT 4');
$stmt->bind_param('i',$userId); $stmt->execute(); $recent=$stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CareerFlow</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<div class="dashboard">

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <div class="logo-icon"><i class="fa-solid fa-chart-line"></i></div>
            <span>Career<span>Flow</span></span>
        </div>

        <nav class="sidebar-nav">
            <p class="nav-title">MAIN</p>

            <a href="dashboard.php" class="nav-item active">
                <i class="fa-solid fa-house"></i><span>Dashboard</span>
            </a>
            <a href="applications.php" class="nav-item">
                <i class="fa-solid fa-briefcase"></i><span>Applications</span>
            </a>
            <a href="companies.php" class="nav-item">
                <i class="fa-solid fa-building"></i><span>Companies</span>
            </a>

            <p class="nav-title second-title">ACCOUNT</p>

            <a href="profile.php" class="nav-item">
                <i class="fa-regular fa-user"></i><span>Profile</span>
            </a>
            <a href="settings.php" class="nav-item">
                <i class="fa-solid fa-gear"></i><span>Settings</span>
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="help-box">
                <div class="help-icon"><i class="fa-solid fa-circle-question"></i></div>
                <div><h4>Need help?</h4><p>We're here for you.</p></div>
            </div>

            <button type="button" class="logout-btn" onclick="openLogout()">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
            </button>
        </div>
    </aside>

    <main class="dashboard-main">
        <header class="dashboard-header">
            <button type="button" class="mobile-menu" onclick="toggleMenu()">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="header-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search applications, companies...">
            </div>

            <div class="header-right">
                <button type="button" class="notification-btn">
                    <i class="fa-regular fa-bell"></i>
                    <span class="notification-dot"></span>
                </button>

                <div class="header-profile">
                    <div class="profile-avatar">R</div>
                    <div class="profile-info">
                        <strong><?php echo e($userName); ?></strong>
                        <span>Student</span>
                    </div>
                    <i class="fa-solid fa-chevron-down profile-arrow"></i>
                </div>
            </div>
        </header>

        <section class="dashboard-content">
            <div class="welcome-section">
                <div>
                    <p class="welcome-small">Tuesday, August 18, 2026</p>
                    <h1>Good afternoon, <?php echo e($userName); ?> <span>👋</span></h1>
                    <p class="welcome-text">Here's an overview of your placement journey.</p>
                </div>

                <a href="add_application.php" class="add-application-btn">
                    <i class="fa-solid fa-plus"></i> Add Application
                </a>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-icon blue"><i class="fa-solid fa-paper-plane"></i></div>
                        <span class="stat-growth">+12%</span>
                    </div>
                    <p>Total Applications</p><h2><?php echo $total; ?></h2>
                    <span class="stat-description">Compared to last month</span>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-icon orange"><i class="fa-solid fa-clock"></i></div>
                        <span class="stat-growth">+3</span>
                    </div>
                    <p>In Progress</p><h2><?php echo $interview + $applied; ?></h2>
                    <span class="stat-description">Applications under review</span>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-icon purple"><i class="fa-solid fa-comments"></i></div>
                        <span class="stat-growth">+2</span>
                    </div>
                    <p>Interviews</p><h2><?php echo $interview; ?></h2>
                    <span class="stat-description">Upcoming interviews</span>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-icon green"><i class="fa-solid fa-circle-check"></i></div>
                        <span class="stat-growth">+1</span>
                    </div>
                    <p>Selected</p><h2><?php echo $selected; ?></h2>
                    <span class="stat-description">Offers received</span>
                </div>
            </div>

            <div class="dashboard-grid">
                <div class="applications-card">
                    <div class="card-header">
                        <div><h2>Recent Applications</h2><p>Your latest job applications</p></div>
                        <a href="applications.php">View All <i class="fa-solid fa-arrow-right"></i></a>
                    </div>

                    <div class="applications-list">
<?php if ($recent->num_rows === 0): ?>
                        <p style="padding:20px;text-align:center;">No applications yet. Add your first application.</p>
<?php else: ?>
<?php while($row=$recent->fetch_assoc()): $cls=statusClass($row['status']); ?>
                        <div class="application-row">
                            <div class="company-logo"><?php echo e(strtoupper(substr($row['company'],0,1))); ?></div>
                            <div class="application-info"><h3><?php echo e($row['company']); ?></h3><p><?php echo e($row['role']); ?></p></div>
                            <div class="application-date"><?php echo e(date('d M Y', strtotime($row['application_date']))); ?></div>
                            <span class="status <?php echo $cls; ?>"><?php echo e($row['status']); ?></span>
                            <a class="row-menu" href="applications.php"><i class="fa-solid fa-ellipsis"></i></a>
                        </div>
<?php endwhile; ?>
<?php endif; ?>
                    </div>
                </div>

                <div class="right-column">
                    <div class="progress-card">
                        <div class="card-header">
                            <div><h2>Placement Progress</h2><p>Your overall progress</p></div>
                            <i class="fa-solid fa-chart-pie card-header-icon"></i>
                        </div>

                        <div class="progress-circle">
                            <div class="circle-inner"><strong>68%</strong><span>Completed</span></div>
                        </div>

                        <div class="progress-details">
                            <div><span class="legend blue-dot"></span>Applications <strong><?php echo $total; ?></strong></div>
                            <div><span class="legend green-dot"></span>Selected <strong><?php echo $selected; ?></strong></div>
                            <div><span class="legend gray-dot"></span>Remaining <strong><?php echo max(0, 34-$total); ?></strong></div>
                        </div>
                    </div>

                    <div class="upcoming-card">
                        <div class="card-header">
                            <div><h2>Upcoming</h2><p>Don't miss these events</p></div>
                            <i class="fa-regular fa-calendar card-header-icon"></i>
                        </div>

                        <div class="event">
                            <div class="event-date"><strong>22</strong><span>AUG</span></div>
                            <div class="event-info"><h3>TCS Interview</h3><p><i class="fa-regular fa-clock"></i>10:30 AM</p></div>
                        </div>
                        <div class="event">
                            <div class="event-date"><strong>25</strong><span>AUG</span></div>
                            <div class="event-info"><h3>Infosys Drive</h3><p><i class="fa-regular fa-clock"></i>9:00 AM</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div class="logout-overlay" id="logoutOverlay" onclick="closeLogout(event)">
        <div class="logout-modal" onclick="event.stopPropagation()">
            <div class="logout-modal-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
            <h2>Logout?</h2>
            <p>Are you sure you want to logout from CareerFlow?</p>
            <div class="logout-actions">
                <button type="button" class="cancel-btn" onclick="closeLogout()">Cancel</button>
                <button type="button" class="confirm-logout-btn" onclick="window.location.href='login.php'">Logout</button>
            </div>
        </div>
    </div>
</div>

<script>
function openLogout() {
    document.getElementById('logoutOverlay').classList.add('show');
}
function closeLogout(event) {
    if (!event || event.target === document.getElementById('logoutOverlay')) {
        document.getElementById('logoutOverlay').classList.remove('show');
    }
}
function toggleMenu() {
    document.getElementById('sidebar').classList.toggle('sidebar-open');
}
</script>

</body>
</html>
