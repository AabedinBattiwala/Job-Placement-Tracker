<?php
require_once 'includes/auth.php';
require_once 'db.php';
require_once 'includes/functions.php';
$userId=(int)$_SESSION['user_id'];
$stmt=$conn->prepare("SELECT COUNT(*) total, SUM(status='Applied') applied, SUM(status='Interview') interview, SUM(status='Selected') selected, SUM(status='Rejected') rejected FROM applications WHERE user_id=?");
$stmt->bind_param('i',$userId); $stmt->execute(); $stats=$stmt->get_result()->fetch_assoc(); $stmt->close();
$total=(int)($stats['total']??0); $applied=(int)($stats['applied']??0); $interview=(int)($stats['interview']??0); $selected=(int)($stats['selected']??0); $rejected=(int)($stats['rejected']??0);
$stmt=$conn->prepare('SELECT * FROM applications WHERE user_id=? ORDER BY application_date DESC, id DESC');
$stmt->bind_param('i',$userId); $stmt->execute(); $applications=$stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Applications - Careerflow
  </title>
  <link href="css/Applications.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com" rel="preconnect"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
 </head>
 <body>
  <div class="app-container">
   <aside class="sidebar">
    <div class="logo">
     <div class="logo-icon">
      <i class="fa-solid fa-chart-line">
      </i>
     </div>
     <span>
      Career
      <span>
       Flow
      </span>
     </span>
    </div>
    <div class="menu-section">
     <p class="menu-title">
      MAIN
     </p>
     <a class="menu-item" href="dashboard.php">
      <i class="fa-solid fa-house">
      </i>
      <span>
       Dashboard
      </span>
     </a>
     <a class="menu-item active" href="applications.php">
      <i class="fa-solid fa-briefcase">
      </i>
      <span>
       Applications
      </span>
     </a>
     <a class="menu-item" href="companies.php">
      <i class="fa-solid fa-building">
      </i>
      <span>
       Companies
      </span>
     </a>
    </div>
    <div class="menu-section account-section">
     <p class="menu-title">
      ACCOUNT
     </p>
     <a class="menu-item" href="profile.php">
      <i class="fa-regular fa-user">
      </i>
      <span>
       Profile
      </span>
     </a>
     <a class="menu-item" href="settings.php">
      <i class="fa-solid fa-gear">
      </i>
      <span>
       Settings
      </span>
     </a>
    </div>
    <div class="sidebar-bottom">
     <div class="help-box">
      <div class="help-icon">
       <i class="fa-solid fa-question">
       </i>
      </div>
      <div>
       <strong>
        Need help?
       </strong>
       <p>
        We're here for you.
       </p>
      </div>
     </div>
     <button class="logout" onclick="openLogout()">
      <i class="fa-solid fa-right-from-bracket">
      </i>
      <span>
       Logout
      </span>
     </button>
    </div>
   </aside>
   <main class="main-content">
    <header class="page-header">
     <div>
      <p class="date">
       Tuesday, August 18, 2026
      </p>
      <h1>
       Applications
      </h1>
      <p class="subtitle">
       Track and manage all your job applications.
      </p>
     </div>
     <a class="add-btn" href="add_application.php">
      <i class="fa-solid fa-plus">
      </i>
      Add Application
     </a>
    </header>
    <section class="stats-grid">
     <div class="stat-card">
      <div class="stat-top">
       <div class="stat-icon blue">
        <i class="fa-solid fa-paper-plane">
        </i>
       </div>
       <span class="growth">
        24
       </span>
      </div>
      <p class="stat-title">
       Total Applications
      </p>
      <h2>
       <?php echo $total; ?>
      </h2>
      <p class="stat-description">
       Applications submitted
      </p>
     </div>
     <div class="stat-card">
      <div class="stat-top">
       <div class="stat-icon light-blue">
        <i class="fa-solid fa-file-circle-check">
        </i>
       </div>
       <span class="growth">
        8
       </span>
      </div>
      <p class="stat-title">
       Applied
      </p>
      <h2>
       <?php echo $applied; ?>
      </h2>
      <p class="stat-description">
       Waiting for response
      </p>
     </div>
     <div class="stat-card">
      <div class="stat-top">
       <div class="stat-icon purple">
        <i class="fa-solid fa-comments">
        </i>
       </div>
       <span class="growth">
        5
       </span>
      </div>
      <p class="stat-title">
       Interviews
      </p>
      <h2>
       <?php echo $interview; ?>
      </h2>
      <p class="stat-description">
       Interview stages
      </p>
     </div>
     <div class="stat-card">
      <div class="stat-top">
       <div class="stat-icon green">
        <i class="fa-solid fa-circle-check">
        </i>
       </div>
       <span class="growth">
        3
       </span>
      </div>
      <p class="stat-title">
       Selected
      </p>
      <h2>
       <?php echo $selected; ?>
      </h2>
      <p class="stat-description">
       Offers received
      </p>
     </div>
    </section>
    <section class="application-section">
     <div class="applications-card">
      <div class="card-header">
       <div>
        <h2>
         All Applications
        </h2>
        <p>
         Recent job applications
        </p>
       </div>
       <div class="filter-area">
        <button class="filter-btn active" onclick="filterApps('All',this)">
         All
        </button>
        <button class="filter-btn" onclick="filterApps('Applied',this)">
         Applied
        </button>
        <button class="filter-btn" onclick="filterApps('Interview',this)">
         Interview
        </button>
        <button class="filter-btn" onclick="filterApps('Selected',this)">
         Selected
        </button>
        <button class="filter-btn" onclick="filterApps('Rejected',this)">
         Rejected
        </button>
       </div>
      </div>
      <div class="application-list">
<?php if ($applications->num_rows===0): ?>
       <p style="padding:25px;text-align:center;">No applications found.</p>
<?php else: while($row=$applications->fetch_assoc()): $cls=statusClass($row['status']); ?>
       <div class="application-row" data-status="<?php echo e($row['status']); ?>">
        <div class="company-logo"><?php echo e(strtoupper(substr($row['company'],0,1))); ?></div>
        <div class="company-info"><h3><?php echo e($row['company']); ?></h3><p><?php echo e($row['role']); ?></p></div>
        <div class="application-date"><?php echo e(date('d M Y',strtotime($row['application_date']))); ?></div>
        <span class="status <?php echo $cls; ?>"><?php echo e($row['status']); ?></span>
        <a class="more-btn" href="edit_application.php?id=<?php echo (int)$row['id']; ?>"><i class="fa-solid fa-ellipsis"></i></a>
       </div>
<?php endwhile; endif; ?>
      </div>
     </div>
     <div class="right-panel">
      <div class="status-card">
       <div class="small-card-header">
        <h2>
         Application Status
        </h2>
        <i class="fa-solid fa-chart-pie">
        </i>
       </div>
       <div class="status-item">
        <div class="status-name">
         <span class="dot blue-dot">
         </span>
         Applied
        </div>
        <strong><?php echo $applied; ?></strong>
       </div>
       <div class="status-item">
        <div class="status-name">
         <span class="dot purple-dot">
         </span>
         Interview
        </div>
        <strong><?php echo $interview; ?></strong>
       </div>
       <div class="status-item">
        <div class="status-name">
         <span class="dot green-dot">
         </span>
         Selected
        </div>
        <strong><?php echo $selected; ?></strong>
       </div>
       <div class="status-item">
        <div class="status-name">
         <span class="dot red-dot">
         </span>
         Rejected
        </div>
        <strong><?php echo $rejected; ?></strong>
       </div>
      </div>
      <div class="quick-card">
       <div class="quick-icon">
        <i class="fa-solid fa-plus">
        </i>
       </div>
       <h3>
        Add a new application
       </h3>
       <p>
        Keep your job search organized.
       </p>
       <a class="quick-btn" href="add_application.php">
        Add Application
       </a>
      </div>
     </div>
    </section>
   </main>
  </div>
  <div class="logout-overlay" id="logoutOverlay">
   <div class="logout-modal">
    <div class="logout-modal-icon">
     <i class="fa-solid fa-right-from-bracket">
     </i>
    </div>
    <h2>
     Logout?
    </h2>
    <p>
     Are you sure you want to logout?
    </p>
    <div class="logout-actions">
     <button class="cancel-btn" onclick="closeLogout()">
      Cancel
     </button>
     <button class="confirm-logout-btn" onclick="location.href='actions/logout.php'">
      Logout
     </button>
    </div>
   </div>
  </div>
  <script>
   function filterApps(s,b){document.querySelectorAll('.filter-btn').forEach(x=>x.classList.remove('active'));b.classList.add('active');document.querySelectorAll('.application-row').forEach(r=>r.style.display=(s==='All'||r.dataset.status===s)?'':'none')}
  </script>
  <script>
   function openLogout(){document.getElementById('logoutOverlay').classList.add('show')}function closeLogout(){document.getElementById('logoutOverlay').classList.remove('show')}document.getElementById('logoutOverlay').addEventListener('click',function(e){if(e.target===this)closeLogout()});
  </script>
 </body>
</html>
