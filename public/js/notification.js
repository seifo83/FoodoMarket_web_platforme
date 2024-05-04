document.addEventListener('DOMContentLoaded', function () {
    var notification = document.getElementById('notification');
    if (notification) {
        notification.classList.remove('is-hidden');
        setTimeout(function () {
            notification.classList.add('is-hidden');
        }, 2000);
    }
});
