

document.addEventListener('DOMContentLoaded', function () {

    const navbar = document.querySelector('.navbar');
    let lastScrollTop = 0;
    let ticking = false;

    function updateNavbar(scrollTop) {
        if (scrollTop > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        lastScrollTop = scrollTop;
    }

    window.addEventListener('scroll', function () {
        if (!ticking) {
            window.requestAnimationFrame(function () {
                updateNavbar(window.scrollY);
                ticking = false;
            });
            ticking = true;
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const uuidInput = document.querySelector('[data-uuid-input]');

    if (uuidInput) {
        uuidInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/-/g, '');
            let formattedValue = '';

            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 2 === 0 && i < 30) {
                    formattedValue += '-';
                }
                formattedValue += value[i];
            }

            e.target.value = formattedValue.toUpperCase();
        });
    }
});
