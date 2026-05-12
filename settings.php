<?php
include('includes/header.php');  // Sidebar & Navbar
include('includes/db.php');      // Database connection

// Check if the user is logged in and user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirect to login page if user is not logged in
    exit();
}

// Fetch the current user's details
$sql_user = "SELECT * FROM users WHERE id = {$_SESSION['user_id']}";
$result_user = mysqli_query($conn, $sql_user);
$user = mysqli_fetch_assoc($result_user);

// Check if the user is an admin
$is_admin = $_SESSION['role'] === 'admin';

// Fetch current settings from the settings table
$sql_settings = "SELECT * FROM settings LIMIT 1";
$result_settings = mysqli_query($conn, $sql_settings);

// Check if the query returned a result
if (mysqli_num_rows($result_settings) > 0) {
    $settings = mysqli_fetch_assoc($result_settings);
} else {
    // If no settings are found, handle the error
    echo "<p>Error: No settings found. Please contact the administrator.</p>";
    exit();  // Exit if settings are missing
}

// Update profile information
if (isset($_POST['update_profile'])) {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];

    // If password is provided, hash it before saving
    if (!empty($new_password)) {
        $new_password = password_hash($new_password, PASSWORD_BCRYPT);
        $sql_update_user = "UPDATE users SET username = '$new_username', email = '$new_email', password = '$new_password' WHERE id = {$_SESSION['user_id']}";
    } else {
        // If no password provided, only update username and email
        $sql_update_user = "UPDATE users SET username = '$new_username', email = '$new_email' WHERE id = {$_SESSION['user_id']}";
    }

    // Update the user details
    if (mysqli_query($conn, $sql_update_user)) {
        // Check if Admin is updating Guesty details
        if ($is_admin) {
            // Update the GUESTY_CLIENT_ID and GUESTY_CLIENT_SECRET in the settings table
            $new_guesty_client_id = $_POST['guesty_client_id'];
            $new_guesty_client_secret = $_POST['guesty_client_secret'];

            $sql_update_settings = "UPDATE settings SET GUESTY_CLIENT_ID = '$new_guesty_client_id', GUESTY_CLIENT_SECRET = '$new_guesty_client_secret' WHERE id = 1";

            if (mysqli_query($conn, $sql_update_settings)) {
                // Redirect back to the settings page with a success message
                echo "<script>
                        window.location.href = 'settings.php'; // Redirect to settings page after success
                      </script>";
                exit();  // Ensure the rest of the script does not execute
            } else {
                echo "<p>Error updating settings: " . mysqli_error($conn) . "</p>";
            }
        }
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
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $user['username']; ?>" required>
        </div>

        <div class="form-group mt-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
        </div>

        <div class="form-group mt-3">
            <label for="password" class="form-label">New Password (Leave blank to keep current password)</label>
            <input type="password" name="password" class="form-control" placeholder="Enter new password">
        </div>

        <button type="submit" name="update_profile" class="btn-custom mt-4">Update Profile</button>
    </form>
    </div>
</div>

<?php include('includes/footer.php'); ?>