document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('.sidebar-toggle');
    const wrapper = document.querySelector('.wrapper');
    
    if (button && wrapper) {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            wrapper.classList.toggle('toggled');
        });
    }

    // Responsive menu
    const resBtn = document.querySelector('.res-menu');
    const resWrapper = document.querySelector('.res-wrapper');
    
    if (resBtn && resWrapper) {
        resBtn.addEventListener('click', (e) => {
            e.preventDefault();
            resWrapper.classList.toggle('toggled');
        });
    }

    // Bootstrap tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
});
