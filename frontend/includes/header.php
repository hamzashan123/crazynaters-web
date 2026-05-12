<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CrazyNaters</title>
    <link rel="icon" type="image/png" href="../assets/images/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../assets/images/favicon.svg" />
    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png" />
    <link rel="manifest" href="../assets/images/site.webmanifest" />
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <!-- Include custom CSS for sidebar and content layout -->
    <!--<link href="assets/css/style.css" rel="stylesheet">-->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/livekit-client/dist/livekit-client.umd.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // (function () {
        //     function getTargetPage() {
        //         const isMobileOrTablet =
        //             /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ||
        //             window.innerWidth <= 1024;
        
        //         return isMobileOrTablet ? "mobile.php" : "chat-dashboard.php";
        //     }
        
        //     function getTargetUrl(targetPage) {
        //         const queryString = window.location.search;
        
        //         return queryString
        //             ? targetPage + queryString
        //             : targetPage;
        //     }
        
        //     function switchPageIfNeeded() {
        //         const currentPage = window.location.pathname.split("/").pop();
        //         const targetPage = getTargetPage();
        
        //         if (currentPage !== targetPage) {
        //             window.location.href = getTargetUrl(targetPage);
        //         }
        //     }
        
        //     switchPageIfNeeded();
        
        //     let resizeTimer;
        //     window.addEventListener("resize", function () {
        //         clearTimeout(resizeTimer);
        
        //         resizeTimer = setTimeout(function () {
        //             switchPageIfNeeded();
        //         }, 300);
        //     });
        // })();
    </script>

</head>

<body >
 <div class="d-flex d-none" id="wrapper" >