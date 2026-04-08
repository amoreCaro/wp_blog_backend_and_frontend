export function loginInit() {
    const loginForm = document.querySelector('.form-login');
    if (!loginForm) return;

    const submit = loginForm.querySelector('button[type="submit"]');

    loginForm.addEventListener('input', (e) => {
        if (e.target.matches('.form__input, .form__input-checkbox')) {
            e.target.classList.remove('invalid');
        }
    });

    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Validate form fields before sending request
        const inputs = loginForm.querySelectorAll(
            '.form__input, .form__input-checkbox'
        );

        let valid = true;

        inputs.forEach(input => {
            const value = input.value.trim();

            if ( input.classList.contains('form__input-password') && value.length < 6 ) {
                input.classList.add('invalid');
                valid = false;
            } else if ( !value ) {
                input.classList.add('invalid');
                valid = false;
            } else {
                input.classList.remove('invalid');
            }
        });

        if (!valid) return;

        submit.disabled = false;

        const formData = new FormData(loginForm);

        try {
            const res = await fetch('/wp-admin/admin-ajax.php', {
                method: 'POST',
                body: new URLSearchParams({
                    action: 'login_user',
                    username: formData.get('username'),
                    password: formData.get('password'),
                    rememberMe: formData.get('rememberMe'),
                    nonce: formData.get('nonce') 
                })
            });

            const data = await res.json();

            if (data.success) {
                alert('Login success');
                window.location.reload();
            } else {
                alert(JSON.stringify(data.data));
            }

        } catch (err) {
            console.error(err);
        }
    });
}