document.addEventListener('DOMContentLoaded', function () {
    // Simple toggle for dropdowns
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle-full');

    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            // Get the parent dropdown item
            const dropdownItem = this.closest('.dropdown-click-item');

            // Toggle this dropdown
            dropdownItem.classList.toggle('active');

            // Close other dropdowns
            document.querySelectorAll('.dropdown-click-item').forEach(item => {
                if (item !== dropdownItem && item.classList.contains('active')) {
                    item.classList.remove('active');
                }
            });
        });
    });

    // Close when clicking outside
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.dropdown-click-item')) {
            document.querySelectorAll('.dropdown-click-item.active').forEach(item => {
                item.classList.remove('active');
            });
        }
    });

    // Prevent dropdown from closing when clicking inside dropdown content
    const dropdownContainers = document.querySelectorAll('.menu-dropdown-container');
    dropdownContainers.forEach(container => {
        container.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    });

    // Handle window resize - reset dropdowns when switching between mobile and desktop
    let lastWindowWidth = window.innerWidth;
    window.addEventListener('resize', function () {
        const currentWidth = window.innerWidth;
        const breakpointCrossed =
            (lastWindowWidth < 992 && currentWidth >= 992) ||
            (lastWindowWidth >= 992 && currentWidth < 992);

        if (breakpointCrossed) {
            // Reset all dropdowns when crossing breakpoint
            document.querySelectorAll('.dropdown-click-item.active').forEach(item => {
                item.classList.remove('active');
            });
        }

        lastWindowWidth = currentWidth;
    });
});
