<div class="text-white" id="sidebar-wrapper">
    <div class="sidebar-brand">
       <div class="sidebar-logo">
            <img src="assets/images/logo.png" alt="Logo">
        </div>
        <div class="sidebar-title-wrap">
            <div class="sidebar-title">CrazyNaters</div>
            <div class="sidebar-subtitle">Admin Control Panel</div>
        </div>
    </div>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-white" href="dashboard.php">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
        </li>
        <?php if ($_SESSION['role'] == 'admin') { ?>
            <li class="nav-item">
                <a class="nav-link text-white" href="manage-users.php">
                    <i class="fas fa-users-cog"></i> <span>Manage Users</span>
                </a>
            </li>
        <?php } ?>

        <?php if ($_SESSION['role'] == 'admin') { ?>
            <li class="nav-item">
                <a class="nav-link text-white" href="manage-chatroom.php">
                    <i class="far fa-comment-dots"></i> <span>Manage Chatroom</span>
                </a>
            </li>
        <?php } ?>
        
        <?php if ($_SESSION['role'] == 'admin') { ?>
            <li class="nav-item">
                <a class="nav-link text-white" href="payment_plan_management.php">
                    <i class="far fa-credit-card"></i> <span>Manage Payment Plans</span>
                </a>
            </li>
        <?php } ?>

        <li class="nav-item">
            <a class="nav-link text-white" href="settings.php">
                <i class="fas fa-cogs"></i> <span>Settings</span>
            </a>
        </li>
    </ul>
</div>
