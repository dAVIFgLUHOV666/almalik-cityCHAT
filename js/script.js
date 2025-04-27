document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('a');
    links.forEach(link => {
        link.addEventListener('click', function(event) {
            // Удалите или закомментируйте следующую строку, чтобы ссылки работали
            // event.preventDefault();
            // alert('Ссылка отключена в режиме хостинга.');
        });
    });

    const themeToggle = document.createElement('div');
    themeToggle.className = 'theme-toggle';
    themeToggle.textContent = '🌙';
    document.body.appendChild(themeToggle);

    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        document.body.classList.add(savedTheme);
        themeToggle.textContent = savedTheme === 'dark-mode' ? '☀️' : '🌙';
    }

    themeToggle.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
        const currentTheme = document.body.classList.contains('dark-mode') ? 'dark-mode' : '';
        localStorage.setItem('theme', currentTheme);
        themeToggle.textContent = currentTheme === 'dark-mode' ? '☀️' : '🌙';
    });

    const arrowButton = document.createElement('button');
    arrowButton.className = 'arrow-button';
    arrowButton.textContent = '↑';
    document.body.appendChild(arrowButton);

    arrowButton.addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}); 