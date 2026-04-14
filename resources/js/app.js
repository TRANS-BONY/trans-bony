import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';

AOS.init();

// Dark mode toggle
window.toggleTheme = () => {
    const html = document.documentElement;
    html.classList.toggle('dark');

    localStorage.setItem('theme',
        html.classList.contains('dark') ? 'dark' : 'light'
    );
};

// Charger thème
if(localStorage.getItem('theme') === 'dark'){
    document.documentElement.classList.add('dark');
}

// Notifications temps réel (polling simple XAMPP)
setInterval(async () => {
    let res = await fetch('/notifications');
    let data = await res.json();

    let badge = document.getElementById('notif-count');
    if(badge) badge.innerText = data.count;

}, 5000);
