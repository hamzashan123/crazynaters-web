<footer class="text-center py-3">
    <p>&copy; 2026 CrazyNaters. All Rights Reserved.</p>
</footer>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    const hamburger = document.getElementById("hamburger");
const sidebar = document.getElementById("sidebar-wrapper");
const navbar = document.querySelector(".navbar");
const footer = document.querySelector("footer");
const body = document.querySelector("body");
        
if (hamburger && sidebar) {
    hamburger.addEventListener("click", () => {
        sidebar.classList.toggle("close-triggered");
        navbar?.classList.toggle("close-triggered");
        footer?.classList.toggle("close-triggered");
        body.classList.toggle("close-triggered");
    });
}

    </script>

</body>
</html>