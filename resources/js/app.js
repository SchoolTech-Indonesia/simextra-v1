import './bootstrap';
document.addEventListener('DOMContentLoaded', function () {
    window.addEventListener('password-updated', event => {
        Swal.fire({
            icon: event.detail.type,
            title: event.detail.title,
            text: event.detail.text,
            timer: 1500,
            showConfirmButton: false,
            position: 'center',
        });
    });
});