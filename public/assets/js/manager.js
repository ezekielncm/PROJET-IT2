// JS UrbanHome - manager : disparition auto des flash messages
window.addEventListener('DOMContentLoaded', function() {
    const flashes = document.querySelectorAll('.flash-message');
    flashes.forEach(function(flash) {
        setTimeout(() => {
            flash.style.transition = 'opacity 0.7s cubic-bezier(.4,0,.2,1)';
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 700);
        }, 3500);
    });
});
