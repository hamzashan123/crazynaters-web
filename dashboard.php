<?php
include('includes/header.php');
include('includes/db.php');

?>

<div class="container-fluid">
    <div class="page-heading mb-4">
        <div class="eyebrow">Admin Overview</div>
        <h2 class="mb-1 fw-bold">Dashboard</h2>
        <p class="text-muted mb-0">Quick summary of your platform activity.</p>
    </div>

    <div class="row g-4">

        <!-- ADMIN CARD -->
        <?php if ($_SESSION['role'] == 'admin') { ?>
        <div class="col-xl-4 col-md-6">
            <div class="stat-card">
                <div class="stat-icon stat-green">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <span>Total Users</span>
                    <h2 id="totalUsersCount" class="dashboard-dynamic-count">...</h2>
                    <small id="totalUsersStatus" class="dashboard-count-status">Loading users...</small>
                    <a href="manage-users.php">Manage Users →</a>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php if ($_SESSION['role'] == 'admin') { ?>
        <div class="col-xl-4 col-md-6">
            <div class="stat-card">
                <div class="stat-icon stat-blue">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="stat-content">
                    <span>Total Chatrooms</span>
                    <h2 id="totalChatroomsCount" class="dashboard-dynamic-count">...</h2>
                    <small id="totalChatroomsStatus" class="dashboard-count-status">Loading chatrooms...</small>
                    <a href="manage-chatroom.php">Manage Chatrooms →</a>
                </div>
            </div>
        </div>
        <?php } ?>

       

    </div>
</div>

<style>
    .page-heading { padding: 4px 2px; }
    .stat-card {
        background: linear-gradient(135deg, rgba(10,24,58,.92), rgba(15,31,76,.68));
        border: 1px solid var(--border);
        border-radius: 22px;
        padding: 26px;
        display: flex;
        align-items: center;
        gap: 20px;
        min-height: 150px;
        box-shadow: var(--shadow);
        backdrop-filter: blur(18px);
        position: relative;
        overflow: hidden;
        transition: all .25s ease;
    }
    .stat-card::before {
        content: "";
        position: absolute;
        top: -55px;
        right: -55px;
        width: 190px;
        height: 190px;
        background: radial-gradient(circle, rgba(0,217,255,.24), transparent 68%);
        pointer-events: none;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        border-color: var(--border2);
        box-shadow: 0 30px 90px rgba(0,0,0,.45), 0 0 32px rgba(0,217,255,.13);
    }
    .stat-icon {
        width: 70px;
        height: 70px;
        border-radius: 21px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 29px;
        flex: 0 0 auto;
        box-shadow: 0 0 32px rgba(0,217,255,.24);
    }
    .stat-green { background: linear-gradient(135deg, #00c897, #00ffc8); color: #06122d; }
    .stat-blue { background: linear-gradient(135deg, var(--blue), var(--purple)); }
    .stat-content span {
        color: var(--muted);
        font-size: 13px;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
    }
    .stat-content h2 {
        color: #fff;
        font-size: 38px;
        font-weight: 900;
        margin: 5px 0 3px;
    }
    .stat-content a {
        color: var(--cyan);
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
    }
    .dashboard-count-status {
        display: block;
        min-height: 18px;
        color: var(--muted);
        font-size: 12px;
        margin-bottom: 4px;
    }
    .dashboard-count-status.count-error {
        color: #ff7b7b !important;
        font-weight: 700;
    }
</style>

<?php if ($_SESSION['role'] == 'admin') { ?>
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-app.js";
    import {
        getFirestore,
        collection,
        getCountFromServer
    } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-firestore.js";

    const firebaseConfig = {
        apiKey: "AIzaSyD_X8hJzryCHrlC8BgO4wExzHzmnIJCBOI",
        authDomain: "chatroom-4ecf4.firebaseapp.com",
        projectId: "chatroom-4ecf4",
        storageBucket: "chatroom-4ecf4.firebasestorage.app",
        messagingSenderId: "19724728120",
        appId: "1:19724728120:web:a61bc3d3986b15d58a73cd"
    };

    const app = initializeApp(firebaseConfig);
    const db = getFirestore(app);

    const totalUsersCount = document.getElementById('totalUsersCount');
    const totalChatroomsCount = document.getElementById('totalChatroomsCount');
    const totalUsersStatus = document.getElementById('totalUsersStatus');
    const totalChatroomsStatus = document.getElementById('totalChatroomsStatus');

    function setCount(countElement, statusElement, value, label) {
        if (!countElement || !statusElement) return;
        countElement.textContent = Number(value || 0).toLocaleString();
        statusElement.textContent = label || 'Updated from Firestore';
        statusElement.classList.remove('count-error');
    }

    function setCountError(countElement, statusElement, message) {
        if (!countElement || !statusElement) return;
        countElement.textContent = '0';
        statusElement.textContent = message || 'Failed to load count';
        statusElement.classList.add('count-error');
    }

    async function getCollectionCount(collectionName) {
        const snapshot = await getCountFromServer(collection(db, collectionName));
        return snapshot.data().count || 0;
    }

    async function loadDashboardCounts() {
        try {
            const usersCount = await getCollectionCount('users');
            setCount(totalUsersCount, totalUsersStatus, usersCount, 'Live total from users collection');
        } catch (error) {
            console.error('Failed to load users count:', error);
            setCountError(totalUsersCount, totalUsersStatus, 'Failed to load users count');
        }

        try {
            const [textRoomsCount, voiceRoomsCount] = await Promise.all([
                getCollectionCount('chatrooms'),
                getCollectionCount('voice_chatrooms')
            ]);
            setCount(
                totalChatroomsCount,
                totalChatroomsStatus,
                textRoomsCount + voiceRoomsCount,
                `${textRoomsCount} text + ${voiceRoomsCount} voice rooms`
            );
        } catch (error) {
            console.error('Failed to load chatrooms count:', error);
            setCountError(totalChatroomsCount, totalChatroomsStatus, 'Failed to load chatrooms count');
        }
    }

    loadDashboardCounts();
</script>
<?php } ?>

<?php include('includes/footer.php'); ?>
