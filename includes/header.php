<?php
require_once __DIR__ . '/../bootstrap.php';

session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crazynaters Admin Panel</title>
    <link rel="icon" type="image/png" href="assets/images/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../assets/images/favicon.svg" />
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png" />
    <link rel="manifest" href="assets/images/site.webmanifest" />
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <!-- Include custom CSS for sidebar and content layout -->
    <link href="assets/css/style.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
:root{--bg:#020617;--panel:rgba(7,18,45,.86);--panel2:rgba(10,24,58,.76);--border:rgba(0,217,255,.25);--border2:rgba(0,217,255,.48);--text:#eef6ff;--muted:#94a8cc;--cyan:#00d9ff;--blue:#1677ff;--purple:#7c3cff;--green:#00ffc8;--shadow:0 22px 70px rgba(0,0,0,.38)}
*{box-sizing:border-box}body{margin:0;font-family:Inter,system-ui,-apple-system,Segoe UI,sans-serif;color:var(--text);background:radial-gradient(circle at 82% 0%,rgba(124,60,255,.38),transparent 34%),radial-gradient(circle at 0% 15%,rgba(0,217,255,.24),transparent 28%),linear-gradient(135deg,#020617 0%,#06122d 52%,#17075a 100%);min-height:100vh}#wrapper{min-height:100vh}#page-content-wrapper{width:100%;min-height:100vh;padding-bottom:76px}.container-fluid{padding:28px 32px}h1,h2,h3,h4,h5{color:#fff;font-weight:800;letter-spacing:-.04em}.text-muted{color:var(--muted)!important}
#sidebar-wrapper{width:350px;min-height:100vh;background:rgba(2,9,29,.84);border-right:1px solid var(--border);box-shadow:12px 0 50px rgba(0,0,0,.22);backdrop-filter:blur(18px);position:sticky;top:0;z-index:20;transition:.25s}.sidebar-brand{padding:20px 16px 12px;display:flex;align-items:center;gap:12px}.sidebar-logo{width:44px;height:44px;border-radius:14px;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,var(--cyan),var(--purple));box-shadow:0 0 28px rgba(0,217,255,.45)}.sidebar-title{font-size:18px;font-weight:800;line-height:1}.sidebar-subtitle{font-size:11px;color:var(--muted);margin-top:4px}#sidebar-wrapper .nav{padding:10px 10px 24px}#sidebar-wrapper .nav-item{margin-bottom:8px}#sidebar-wrapper .nav-link{color:#c7d7f7!important;display:flex;align-items:center;gap:11px;padding:13px 14px;border-radius:15px;font-weight:700;border:1px solid transparent;transition:.2s}#sidebar-wrapper .nav-link i{width:22px;color:var(--cyan);text-align:center;filter:drop-shadow(0 0 8px rgba(0,217,255,.45))}#sidebar-wrapper .nav-link:hover,#sidebar-wrapper .nav-link.active{color:#fff!important;background:linear-gradient(135deg,rgba(22,119,255,.22),rgba(124,60,255,.24));border-color:var(--border);box-shadow:0 0 22px rgba(0,217,255,.12);transform:translateX(3px)}
.navbar{min-height:64px;padding:10px 28px;background:rgba(2,8,24,.72);border-bottom:1px solid var(--border);backdrop-filter:blur(18px);box-shadow:0 12px 36px rgba(0,0,0,.2)}.hamburger{width:42px;height:42px;display:flex;flex-direction:column;justify-content:center;align-items:center;gap:5px;border-radius:13px;background:rgba(255,255,255,.05);border:1px solid var(--border);cursor:pointer}.hamburger:hover{background:rgba(0,217,255,.12);box-shadow:0 0 18px rgba(0,217,255,.18)}.hamburger span{width:18px;height:2px;border-radius:999px;background:#fff;display:block}.admin-user-pill{display:flex;align-items:center;gap:12px;color:#eaf2ff;font-weight:600}
.btn-custom,.btn-primary,.btn-info,.btn-warning,.btn-success,.btn-danger{border:0!important;border-radius:12px!important;font-weight:800!important;box-shadow:0 12px 28px rgba(0,0,0,.22);transition:.2s}.btn-custom,.btn-primary,.btn-info{background:linear-gradient(135deg,var(--purple),var(--cyan))!important;color:#fff!important;padding:9px 18px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none}.btn-warning{background:linear-gradient(135deg,#ffd166,#ff9f1c)!important;color:#06122d!important}.btn-success{background:linear-gradient(135deg,#00c897,#00ffc8)!important;color:#06122d!important}.btn-danger{background:linear-gradient(135deg,#ff4d6d,#b5179e)!important;color:#fff!important}.btn:hover,.btn-custom:hover{transform:translateY(-1px);filter:brightness(1.08)}
.shadow,.bg-white,.admin-panel{background:var(--panel2)!important;color:var(--text)!important;border:1px solid var(--border)!important;border-radius:20px!important;box-shadow:var(--shadow)!important;backdrop-filter:blur(18px)}.rounded{border-radius:20px!important}.form-label{color:#dbeafe;font-weight:700;font-size:13px}.form-control,.form-select,.input-group-text{background:rgba(2,12,36,.72)!important;border:1px solid var(--border)!important;color:#fff!important;border-radius:13px!important;min-height:44px}.form-control::placeholder{color:#7890bb!important}.form-control:focus,.form-select:focus{box-shadow:0 0 0 .2rem rgba(0,217,255,.12)!important;border-color:var(--cyan)!important}.input-group .input-group-text{border-radius:13px 0 0 13px!important;color:var(--cyan)!important}.input-group .form-control{border-radius:0 13px 13px 0!important}
.table-responsive{border:1px solid rgba(0,217,255,.42);border-radius:18px;overflow:hidden;background:#fff;box-shadow:0 18px 45px rgba(0,0,0,.22),0 0 0 1px rgba(255,255,255,.05),inset 0 1px 0 rgba(255,255,255,.9)}.table{color:#0f172a!important;margin-bottom:0;background:#fff!important;border-collapse:separate;border-spacing:0}.table>:not(caption)>*>*{background:#fff!important;color:#0f172a!important;border-bottom:1px solid rgba(15,23,42,.10)!important;border-right:1px solid rgba(15,23,42,.07)!important;padding:14px;vertical-align:middle}.table tbody tr>*:last-child,.table thead tr>*:last-child{border-right:0!important}.table tbody tr:last-child>*{border-bottom:0!important}.table thead th,.table-dark th{background:linear-gradient(135deg,#03122f,#062b5f)!important;color:#fff!important;border-bottom:2px solid rgba(0,217,255,.55)!important;font-size:12px;text-transform:uppercase;letter-spacing:.06em}.table-striped>tbody>tr:nth-of-type(odd)>*{background:#ffffff!important}.table-striped>tbody>tr:nth-of-type(even)>*{background:#f8fbff!important}.table-hover tbody tr:hover>*{background:#eef9ff!important;color:#06122d!important}.table .text-muted,.table small.text-muted{color:#64748b!important}.badge{border-radius:999px;padding:7px 10px;font-weight:800}.bg-primary,.bg-secondary{background:linear-gradient(135deg,var(--blue),var(--purple))!important}.bg-success{background:linear-gradient(135deg,#00c897,#00ffc8)!important;color:#06122d!important}.bg-dark{background:rgba(255,255,255,.1)!important}.bg-warning{background:linear-gradient(135deg,#ffd166,#ff9f1c)!important}.bg-danger{background:linear-gradient(135deg,#ff4d6d,#b5179e)!important}.alert{border:1px solid var(--border)!important;border-radius:14px!important;color:#fff!important;background:rgba(2,12,36,.75)!important}.eyebrow{color:var(--cyan);font-size:12px;text-transform:uppercase;letter-spacing:.16em;font-weight:900;margin-bottom:6px}
footer{position:fixed;left:260px;right:0;bottom:0;background:rgba(2,8,24,.78);border-top:1px solid var(--border);backdrop-filter:blur(18px);color:var(--muted);z-index:15;transition:.25s}footer p{margin:0;font-size:13px}body.close-triggered #sidebar-wrapper{width:78px;overflow:hidden}body.close-triggered .sidebar-title-wrap,body.close-triggered #sidebar-wrapper .nav-link span{display:none}body.close-triggered footer{left:78px}
    @media(max-width:991px){#wrapper{display:block!important}#sidebar-wrapper{position:fixed;transform:translateX(-100%);height:100vh}body:not(.close-triggered) #sidebar-wrapper{transform:translateX(0)}#page-content-wrapper{width:100%}footer{left:0}.container-fluid{padding:20px 16px 84px}
                .sidebar-title-wrap {
            display: none;
        }
        
        #page-content-wrapper {
            width: calc(100% - 75px) !important;
        }
        
        footer {
            left: unset !important;
            right: 0;
        }
    }
    
    .sidebar-logo {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: radial-gradient(circle at 30% 20%, rgba(0, 229, 255, .95), rgba(0, 89, 255, .88) 48%, rgba(165, 0, 255, .82));
    }
    
    .sidebar-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    </style>

</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <?php include('sidebar.php'); ?>
        
        <!-- Main content area -->
        <div id="page-content-wrapper" class="">
            <!-- Navbar -->
            <?php include('navbar.php'); ?>
            
    
  
