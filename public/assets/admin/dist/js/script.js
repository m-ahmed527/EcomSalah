document.addEventListener("DOMContentLoaded", function () {
    // Current full URL
    const currentUrl = window.location.href;

    // Loop through all sidebar links
    document.querySelectorAll('.nav-sidebar a').forEach(link => {
        if (currentUrl === link.href || currentUrl.startsWith(link.href)) {
            // Add active class to the current link
            link.classList.add('active');

            // If inside a treeview, open its parent
            let parent = link.closest('.nav-treeview');
            if (parent) {
                let mainItem = parent.closest('.nav-item');
                if (mainItem) {
                    mainItem.classList.add('menu-open');
                    let mainLink = mainItem.querySelector('a.nav-link');
                    if (mainLink) {
                        mainLink.classList.add('active');
                    }
                }
            }
        }
    });


    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        
    });
});

//Start-> Page load hone par buttons disable karne aur load hone ke baad enable karne ka code
function disableButtons(selector = null) {
    // selector pass ho to usko use karo warna sab ko select karo (slick buttons exclude)
    const elements = selector
        ? document.querySelectorAll(selector)
        : document.querySelectorAll('button:not(.slick-arrow):not(.slick-dots button), a');

    elements.forEach(el => {
        if (!el.classList.contains('disabled')) {
            el.classList.add('disabled');
            el.setAttribute('aria-disabled', 'true');

            if (el.tagName.toLowerCase() === 'a') {
                el.dataset.href = el.getAttribute('href');
                el.removeAttribute('href');
            } else {
                el.setAttribute('disabled', 'disabled');
            }

            if (!el.dataset.originalHtml) {
                el.dataset.originalHtml = el.innerHTML;
            }

            el.innerHTML = `<i class="mdi mdi-sync-circle mdi-spin me-1"></i> Loading...`;
        }
    });
}

function enableButtons(selector = null) {
    const elements = selector
        ? document.querySelectorAll(selector)
        : document.querySelectorAll('button:not(.slick-arrow):not(.slick-dots button), a');

    elements.forEach(el => {
        el.classList.remove('disabled');
        el.removeAttribute('aria-disabled');

        if (el.tagName.toLowerCase() === 'a' && el.dataset.href) {
            el.setAttribute('href', el.dataset.href);
            delete el.dataset.href;
        } else {
            el.removeAttribute('disabled');
        }

        if (el.dataset.originalHtml) {
            el.innerHTML = el.dataset.originalHtml;
        }
    });
}

// Example usage:
// disableButtons(); // sab disable
// disableButtons('#submitBtn'); // sirf ek button disable
// disableButtons('.save-btn'); // sirf specific class wale disable



document.addEventListener('DOMContentLoaded', function () {
    // Load saved theme
    const savedTheme = localStorage.getItem('themeMode') || 'light-mode';
    const savedNavbar = localStorage.getItem('navbarColor') || 'navbar-light navbar-white';
    const savedSidebar = localStorage.getItem('sidebarColor') || 'sidebar-dark-primary';

    // Apply classes
    document.body.classList.add(savedTheme);
    document.querySelector('.main-header').className = 'main-header navbar navbar-expand ' + savedNavbar;
    document.querySelector('.main-sidebar').className = 'main-sidebar ' + savedSidebar;

    // Set dropdowns
    const themeModeEl = document.getElementById('themeMode');
    if (themeModeEl) themeModeEl.value = savedTheme;

    const navbarColorEl = document.getElementById('navbarColor');
    if (navbarColorEl) navbarColorEl.value = savedNavbar;

    const sidebarColorEl = document.getElementById('sidebarColor');
    if (sidebarColorEl) sidebarColorEl.value = savedSidebar;

    // Save new theme
    const saveBtn = document.getElementById('saveThemeBtn');
    if (saveBtn) {
        saveBtn.addEventListener('click', function () {
            const themeMode = document.getElementById('themeMode').value;
            const navbarColor = document.getElementById('navbarColor').value;
            const sidebarColor = document.getElementById('sidebarColor').value;

            // Save to localStorage
            localStorage.setItem('themeMode', themeMode);
            localStorage.setItem('navbarColor', navbarColor);
            localStorage.setItem('sidebarColor', sidebarColor);

            // Apply immediately
            document.body.className = ''; // reset
            document.body.classList.add(themeMode);
            document.querySelector('.main-header').className = 'main-header navbar navbar-expand ' + navbarColor;
            document.querySelector('.main-sidebar').className = 'main-sidebar ' + sidebarColor;

            toastr.success('Theme updated successfully!');
        });
    }
});

