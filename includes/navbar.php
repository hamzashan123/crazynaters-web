<nav class="navbar navbar-dark">
    <div class="d-flex justify-content-between align-items-center w-100">
        <div class="hamburger" id="hamburger" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="admin-user-pill">
            <span>Welcome, <strong><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></strong></span>
            <a class="nav-link text-white p-0" href="logout.php"><span class="btn-custom">Logout</span></a>
        </div>
    </div>
</nav>
