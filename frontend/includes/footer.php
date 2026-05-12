
<!--<footer class="text-center py-3" style="color: white;">-->
<!--    <p>&copy; 2026 Crazynatters. All Rights Reserved.</p>-->
<!--</footer>-->
</div>


<!-- Initial Page Loader -->
<div id="initialPageLoader" class="initial-page-loader">
    <div class="initial-loader-card">
        <div class="initial-loader-logo">
            <i class="fas fa-comments"></i>
        </div>
        <div class="initial-loader-title">Loading Chatroom</div>
        <div class="initial-loader-spinner"></div>
    </div>
</div>


<script src="/frontend/assets/js/audio-call.js"></script>

</body>


<script>
    
(function () {
    function hideInitialLoader() {
        var loader = document.getElementById('initialPageLoader');
        if (!loader) return;

        loader.classList.add('loader-hidden');

        loader.addEventListener('transitionend', function () {
            if (loader && loader.parentNode) {
                loader.parentNode.removeChild(loader);
            }
        }, { once: true });
    }

    if (document.readyState === 'complete') {
        hideInitialLoader();
        document.getElementById('wrapper').classList.remove("d-none");
    } else {
        window.addEventListener('load', hideInitialLoader, { once: true });
         document.getElementById('wrapper').classList.remove("d-none");
    }
})();
</script>

</html>