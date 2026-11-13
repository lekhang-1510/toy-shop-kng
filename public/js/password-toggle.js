document.addEventListener('click', function (e) {
    const btn = e.target.closest('.toggle-password');
    if (!btn) return;

    const input = btn.closest('.password-field').querySelector('input');
    const icon = btn.querySelector('i');
    const show = input.type === 'password';

    input.type = show ? 'text' : 'password';
    icon.classList.toggle('bi-eye', !show);
    icon.classList.toggle('bi-eye-slash', show);
    btn.setAttribute('aria-label', show ? 'Ẩn mật khẩu' : 'Hiện mật khẩu');
});