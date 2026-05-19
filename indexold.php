<?php
// Redirect to login if not logged in
  
    // header('Location: login.php');
    // exit();
?>
<script>
(function () {
    function getTargetPage() {
        const isMobileOrTablet =
            /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ||
            window.innerWidth <= 1024;

        return isMobileOrTablet ? "frontend/chat-dashboard.php" : "frontend/chat-dashboard.php";
    }

    function switchPageIfNeeded() {
        const currentPage = window.location.pathname.split("/").pop();
        const targetPage = getTargetPage();

        if (currentPage !== targetPage) {
            window.location.href = targetPage;
        }
    }

    // Run on page load
    switchPageIfNeeded();

    // Run when browser is resized
    let resizeTimer;
    window.addEventListener("resize", function () {
        clearTimeout(resizeTimer);
        console.log('asdasdsad');
        resizeTimer = setTimeout(function () {
            switchPageIfNeeded();
        }, 300);
    });
})();
</script>