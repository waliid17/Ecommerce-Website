document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.querySelector(".sidebar");
    const navItems = document.querySelectorAll(".nav-item");

    // Function to show specific content based on the target ID
    function showContent(targetId) {
        // Hide all content sections
        document.querySelectorAll(".home .content").forEach(content => {
            content.style.display = "none";
        });

        // Show the content section with the matching ID
        const targetContent = document.getElementById(targetId);
        if (targetContent) {
            targetContent.style.display = "block";
        }
    }

    // Sidebar toggle functionality
    const toggle = document.querySelector(".toggle");
    toggle.addEventListener("click", () => {
        sidebar.classList.toggle("closed");
    });

    // Show content when a nav item is clicked
    navItems.forEach(item => {
        item.addEventListener("click", (e) => {
            e.preventDefault();
            navItems.forEach(item => {
                item.classList.remove('activer');
            });
            item.classList.add('activer');
            const targetId = e.currentTarget.getAttribute("data-target");

            if (targetId) {
                // Update the URL with the target ID
                const newUrl = `${window.location.pathname}?targetId=${targetId}`;
                history.pushState(null, '', newUrl);
                
                showContent(targetId);
            }
        });
    });

    // Get the target ID from the URL query parameters
    const urlParams = new URLSearchParams(window.location.search);
    const targetId = urlParams.get("targetId");

    // If there's a targetId in the URL, show that content; otherwise, show the default
    if (targetId) {
        showContent(targetId);
    } else {
        showContent("accueil-content"); // Set default content ID
    }
});