<?php
include('includes/header.php');  // Sidebar & Navbar
include('includes/db.php');      // Database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch current user details
$user_id = (int) $_SESSION['user_id'];

$sql_user = "SELECT * FROM users WHERE id = $user_id";
$result_user = mysqli_query($conn, $sql_user);

if (!$result_user || mysqli_num_rows($result_user) === 0) {
    echo "<p>User not found.</p>";
    exit();
}

$user = mysqli_fetch_assoc($result_user);

// Update profile
if (isset($_POST['update_profile'])) {

    $new_username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $new_email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $new_password = trim($_POST['password']);

    // Update with password
    if (!empty($new_password)) {

        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        $sql_update = "
            UPDATE users 
            SET 
                username = '$new_username',
                email = '$new_email',
                password = '$hashed_password'
            WHERE id = $user_id
        ";

    } else {

        // Update without password
        $sql_update = "
            UPDATE users 
            SET 
                username = '$new_username',
                email = '$new_email'
            WHERE id = $user_id
        ";
    }

    if (mysqli_query($conn, $sql_update)) {

        echo "<script>
                alert('Profile updated successfully!');
                window.location.href = 'settings.php';
              </script>";
        exit();

    } else {

        echo "<p>Error updating profile: " . mysqli_error($conn) . "</p>";
    }
}
?>

<div class="container-fluid py-3">
    <div class="shadow p-4 rounded">

        <div class="eyebrow">Account</div>
        <h2 class="mb-4">Settings</h2>

        <form method="POST">

            <div class="form-group">
                <label class="form-label">Username</label>
                <input 
                    type="text" 
                    name="username" 
                    class="form-control"
                    value="<?php echo htmlspecialchars($user['username']); ?>" 
                    required
                >
            </div>

            <div class="form-group mt-3">
                <label class="form-label">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control"
                    value="<?php echo htmlspecialchars($user['email']); ?>" 
                    required
                >
            </div>

            <div class="form-group mt-3">
                <label class="form-label">
                    New Password (Leave blank to keep current password)
                </label>

                <input 
                    type="password" 
                    name="password" 
                    class="form-control"
                    placeholder="Enter new password"
                >
            </div>

            <button 
                type="submit" 
                name="update_profile" 
                class="btn-custom mt-4"
            >
                Update Profile
            </button>

        </form>
    </div>
</div>

<?php include('includes/footer.php'); ?>