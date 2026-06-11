<?php
include('includes/header.php');
include('includes/db.php');
require_once __DIR__ . '/includes/stripe-settings-helper.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (($_SESSION['role'] ?? '') !== 'admin') {
    echo "<div class='container-fluid py-3'><div class='alert alert-danger'>Access denied. Only admin can manage Stripe settings.</div></div>";
    include('includes/footer.php');
    exit();
}

$settings = get_stripe_settings($conn);
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_stripe_settings'])) {
    $stripeMode = (isset($_POST['stripe_mode']) && $_POST['stripe_mode'] === 'live') ? 'live' : 'test';

    $testPublishableKey = trim($_POST['test_publishable_key'] ?? '');
    $livePublishableKey = trim($_POST['live_publishable_key'] ?? '');

    // Secret key fields are intentionally left blank on the form for security.
    // If admin does not enter a new secret key, keep the old saved key.
    $testSecretKey = trim($_POST['test_secret_key'] ?? '');
    if ($testSecretKey === '') {
        $testSecretKey = $settings['test_secret_key'] ?? '';
    }

    $liveSecretKey = trim($_POST['live_secret_key'] ?? '');
    if ($liveSecretKey === '') {
        $liveSecretKey = $settings['live_secret_key'] ?? '';
    }

    if ($stripeMode === 'test' && ($testPublishableKey === '' || $testSecretKey === '')) {
        $error = 'Please add both Test Publishable Key and Test Secret Key before switching to Test mode.';
    } elseif ($stripeMode === 'live' && ($livePublishableKey === '' || $liveSecretKey === '')) {
        $error = 'Please add both Live Publishable Key and Live Secret Key before switching to Live mode.';
    } else {
        $stmt = mysqli_prepare($conn, "
            UPDATE stripe_settings
            SET stripe_mode = ?,
                test_publishable_key = ?,
                test_secret_key = ?,
                live_publishable_key = ?,
                live_secret_key = ?
            WHERE id = 1
        ");

        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                'sssss',
                $stripeMode,
                $testPublishableKey,
                $testSecretKey,
                $livePublishableKey,
                $liveSecretKey
            );

            if (mysqli_stmt_execute($stmt)) {
                $success = 'Stripe settings updated successfully.';
                $settings = get_stripe_settings($conn);
            } else {
                $error = 'Error saving Stripe settings: ' . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = 'Error preparing Stripe settings update: ' . mysqli_error($conn);
        }
    }
}

$currentMode = ($settings['stripe_mode'] ?? 'test') === 'live' ? 'live' : 'test';
?>

<div class="container-fluid py-3">
    <div class="shadow p-4 rounded">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
            <div>
                <div class="eyebrow">Payments</div>
                <h2 class="mb-1">Manage Stripe</h2>
                <p class="text-muted mb-0">Add your Stripe test/live keys and choose which mode the website should use.</p>
            </div>
            <div>
                <?php if ($currentMode === 'live') { ?>
                    <span class="badge bg-success">Current Mode: LIVE</span>
                <?php } else { ?>
                    <span class="badge bg-warning">Current Mode: TEST</span>
                <?php } ?>
            </div>
        </div>

        <?php if ($success !== '') { ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php } ?>

        <?php if ($error !== '') { ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php } ?>

        <form method="POST" autocomplete="off">
            <div class="row g-4">
                <div class="col-12">
                    <label class="form-label">Stripe Mode</label>
                    <div class="stripe-mode-card d-flex flex-wrap gap-3">
                        <label class="stripe-mode-option <?php echo $currentMode === 'test' ? 'active' : ''; ?>">
                            <input type="radio" name="stripe_mode" value="test" <?php echo $currentMode === 'test' ? 'checked' : ''; ?>>
                            <span>
                                <strong>Test Mode</strong>
                                <small>Use this while testing payments with Stripe test cards.</small>
                            </span>
                        </label>

                        <label class="stripe-mode-option <?php echo $currentMode === 'live' ? 'active' : ''; ?>">
                            <input type="radio" name="stripe_mode" value="live" <?php echo $currentMode === 'live' ? 'checked' : ''; ?>>
                            <span>
                                <strong>Live Mode</strong>
                                <small>Use this only when you are ready to accept real payments.</small>
                            </span>
                        </label>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="stripe-key-panel h-100">
                        <div class="eyebrow">Test Keys</div>
                        <h4 class="mb-3">Stripe Test</h4>

                        <div class="form-group mb-3">
                            <label class="form-label">Test Publishable Key</label>
                            <input type="text" name="test_publishable_key" class="form-control" value="<?php echo htmlspecialchars($settings['test_publishable_key'] ?? ''); ?>" placeholder="pk_test_...">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Test Secret Key</label>
                            <input type="password" name="test_secret_key" class="form-control" value="" placeholder="<?php echo htmlspecialchars(mask_stripe_key($settings['test_secret_key'] ?? '')); ?>">
                            <small class="text-muted d-block mt-2">Leave blank to keep the saved test secret key.</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="stripe-key-panel h-100">
                        <div class="eyebrow">Live Keys</div>
                        <h4 class="mb-3">Stripe Live</h4>

                        <div class="form-group mb-3">
                            <label class="form-label">Live Publishable Key</label>
                            <input type="text" name="live_publishable_key" class="form-control" value="<?php echo htmlspecialchars($settings['live_publishable_key'] ?? ''); ?>" placeholder="pk_live_...">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Live Secret Key</label>
                            <input type="password" name="live_secret_key" class="form-control" value="" placeholder="<?php echo htmlspecialchars(mask_stripe_key($settings['live_secret_key'] ?? '')); ?>">
                            <small class="text-muted d-block mt-2">Leave blank to keep the saved live secret key.</small>
                        </div>
                    </div>
                </div>

                <div class="col-12 d-flex flex-wrap gap-2 align-items-center">
                    <button type="submit" name="save_stripe_settings" class="btn-custom">
                        <i class="fas fa-save me-2"></i> Save Stripe Settings
                    </button>
                    <a href="settings.php" class="btn btn-secondary">Back to Settings</a>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.stripe-mode-card{
    background:rgba(2,12,36,.45);
    border:1px solid var(--border);
    border-radius:18px;
    padding:14px;
}
.stripe-mode-option{
    flex:1 1 260px;
    display:flex;
    gap:12px;
    align-items:flex-start;
    padding:16px;
    border:1px solid rgba(0,217,255,.22);
    border-radius:16px;
    cursor:pointer;
    background:rgba(255,255,255,.04);
    transition:.2s;
}
.stripe-mode-option:hover,.stripe-mode-option.active{
    border-color:var(--cyan);
    background:linear-gradient(135deg,rgba(22,119,255,.18),rgba(124,60,255,.20));
    box-shadow:0 0 22px rgba(0,217,255,.12);
}
.stripe-mode-option input{margin-top:4px;accent-color:#00d9ff;}
.stripe-mode-option strong{display:block;color:#fff;font-size:16px;}
.stripe-mode-option small{display:block;color:var(--muted);margin-top:4px;}
.stripe-key-panel{
    background:rgba(2,12,36,.45);
    border:1px solid var(--border);
    border-radius:18px;
    padding:20px;
}
</style>

<script>
document.querySelectorAll('.stripe-mode-option').forEach(function(option){
    option.addEventListener('click', function(){
        document.querySelectorAll('.stripe-mode-option').forEach(function(item){ item.classList.remove('active'); });
        option.classList.add('active');
        var radio = option.querySelector('input[type="radio"]');
        if (radio) radio.checked = true;
    });
});
</script>

<?php include('includes/footer.php'); ?>
