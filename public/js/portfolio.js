/* ========================================
   PORTFOLIO INTERAKSI
   - Menu mobile (hamburger)
   - Penanda menu aktif sesuai section
======================================== */

(function () {
    'use strict';

    var toggle = document.querySelector('.navbar__toggle');
    var links = document.getElementById('navbar-links');

    if (toggle && links) {
        var setOpen = function (open) {
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            toggle.setAttribute('aria-label', open ? 'Tutup menu navigasi' : 'Buka menu navigasi');
            links.classList.toggle('is-open', open);
        };

        var isOpen = function () {
            return toggle.getAttribute('aria-expanded') === 'true';
        };

        toggle.addEventListener('click', function () {
            setOpen(!isOpen());
        });

        links.addEventListener('click', function (event) {
            if (event.target.closest('a')) {
                setOpen(false);
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && isOpen()) {
                setOpen(false);
                toggle.focus();
            }
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 760 && isOpen()) {
                setOpen(false);
            }
        });
    }

    /* Menu aktif mengikuti posisi scroll */

    var sections = Array.prototype.slice.call(document.querySelectorAll('section[id]'));

    if (!links || !sections.length || !('IntersectionObserver' in window)) {
        return;
    }

    var navLinks = Array.prototype.slice.call(links.querySelectorAll('a[href^="#"]'));

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) {
                return;
            }

            navLinks.forEach(function (link) {
                link.classList.toggle(
                    'is-active',
                    link.getAttribute('href') === '#' + entry.target.id
                );
            });
        });
    }, { rootMargin: '-45% 0px -50% 0px' });

    sections.forEach(function (section) {
        observer.observe(section);
    });
})();
