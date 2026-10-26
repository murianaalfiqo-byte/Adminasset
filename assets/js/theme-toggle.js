(function () {
    const savedTheme = localStorage.getItem('assetflow-theme') || 'light';
    document.documentElement.setAttribute('data-bs-theme', savedTheme);
})();

function toggleTheme() {
    const htmlEl = document.documentElement;
    const bodyEl = document.body;
    const currentTheme = htmlEl.getAttribute('data-bs-theme') || 'light';
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    htmlEl.setAttribute('data-bs-theme', newTheme);
    if (bodyEl) bodyEl.setAttribute('data-bs-theme', newTheme);
    
    localStorage.setItem('assetflow-theme', newTheme);
    
    updateThemeIcons(newTheme);
}

function updateThemeIcons(theme) {
    const icons = document.querySelectorAll('.theme-toggle-icon');
    icons.forEach(icon => {
        if (theme === 'dark') {
            icon.classList.remove('fa-moon', 'text-light', 'text-secondary');
            icon.classList.add('fa-sun', 'text-warning');
        } else {
            icon.classList.remove('fa-sun', 'text-warning');
            icon.classList.add('fa-moon');
        }
    });
}

window.toggleTheme = toggleTheme;

document.addEventListener('DOMContentLoaded', function () {
    const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
    updateThemeIcons(currentTheme);
});