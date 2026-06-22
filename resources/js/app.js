import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
import Swal from 'sweetalert2';
window.Swal = Swal;
import Chart from 'chart.js/auto';
window.Chart = Chart;

document.addEventListener('DOMContentLoaded', () => {
    // Reveal animation
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.15 }
    );
    document.querySelectorAll('[data-reveal]').forEach(el => observer.observe(el));
});