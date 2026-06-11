<?php
if (!function_exists('ensure_stripe_settings_table')) {
    function ensure_stripe_settings_table(mysqli $conn): void
    {
        $createSql = "
            CREATE TABLE IF NOT EXISTS stripe_settings (
                id INT NOT NULL PRIMARY KEY,
                stripe_mode ENUM('test','live') NOT NULL DEFAULT 'test',
                test_publishable_key TEXT NULL,
                test_secret_key TEXT NULL,
                live_publishable_key TEXT NULL,
                live_secret_key TEXT NULL,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ";
        mysqli_query($conn, $createSql);

        $check = mysqli_query($conn, "SELECT id FROM stripe_settings WHERE id = 1 LIMIT 1");
        if ($check && mysqli_num_rows($check) === 0) {
            $envPublishable = mysqli_real_escape_string($conn, $_ENV['STRIPE_PUBLISHABLE_KEY'] ?? '');
            $envSecret = mysqli_real_escape_string($conn, $_ENV['STRIPE_SECRET_KEY'] ?? '');
            mysqli_query($conn, "
                INSERT INTO stripe_settings
                    (id, stripe_mode, test_publishable_key, test_secret_key, live_publishable_key, live_secret_key)
                VALUES
                    (1, 'test', '$envPublishable', '$envSecret', '', '')
            ");
        }
    }
}

if (!function_exists('get_stripe_settings')) {
    function get_stripe_settings(mysqli $conn): array
    {
        ensure_stripe_settings_table($conn);

        $result = mysqli_query($conn, "SELECT * FROM stripe_settings WHERE id = 1 LIMIT 1");
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }

        return [
            'stripe_mode' => 'test',
            'test_publishable_key' => $_ENV['STRIPE_PUBLISHABLE_KEY'] ?? '',
            'test_secret_key' => $_ENV['STRIPE_SECRET_KEY'] ?? '',
            'live_publishable_key' => '',
            'live_secret_key' => '',
        ];
    }
}

if (!function_exists('get_active_stripe_keys')) {
    function get_active_stripe_keys(mysqli $conn): array
    {
        $settings = get_stripe_settings($conn);
        $mode = ($settings['stripe_mode'] ?? 'test') === 'live' ? 'live' : 'test';

        $publishableKey = $mode === 'live'
            ? ($settings['live_publishable_key'] ?? '')
            : ($settings['test_publishable_key'] ?? '');

        $secretKey = $mode === 'live'
            ? ($settings['live_secret_key'] ?? '')
            : ($settings['test_secret_key'] ?? '');

        // Safe fallback for old installs before the Stripe settings screen is saved.
        if ($mode === 'test') {
            if ($publishableKey === '') {
                $publishableKey = $_ENV['STRIPE_PUBLISHABLE_KEY'] ?? '';
            }
            if ($secretKey === '') {
                $secretKey = $_ENV['STRIPE_SECRET_KEY'] ?? '';
            }
        }

        return [
            'mode' => $mode,
            'publishable_key' => $publishableKey,
            'secret_key' => $secretKey,
        ];
    }
}

if (!function_exists('mask_stripe_key')) {
    function mask_stripe_key(?string $key): string
    {
        $key = trim((string) $key);
        if ($key === '') {
            return '';
        }
        if (strlen($key) <= 12) {
            return str_repeat('*', strlen($key));
        }
        return substr($key, 0, 8) . str_repeat('*', max(strlen($key) - 12, 8)) . substr($key, -4);
    }
}
?>
