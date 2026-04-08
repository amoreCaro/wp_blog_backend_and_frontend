export function signInit() {
    // GET register form 
    const registerForm = document.querySelector('.form-register');

    if (!registerForm) return;
    // GET submit button in form 
    const submit = registerForm.querySelector('button[type="submit"]');

    // Remove validation error when user starts typing/changing input
    registerForm.addEventListener('input', (e) => {
        if (e.target.matches('.form__input, .form__input-checkbox')) {
            e.target.classList.remove('invalid');
        }
    });

    registerForm.addEventListener('submit', function (e) {
        e.preventDefault();

        // Validate form fields before sending request
        const inputs = registerForm.querySelectorAll(
            '.form__input, .form__input-checkbox'
        );

        let valid = true;

        inputs.forEach(input => {
            if (input.classList.contains('form__input-checkbox')) {
                if (!input.checked) {
                    input.classList.add('invalid');
                    valid = false;
                } else {
                    input.classList.remove('invalid');
                }
            } else {
                const value = input.value.trim();

                if (!value) {
                    input.classList.add('invalid');
                    valid = false;
                } else if (
                    input.classList.contains('form__input-password') &&
                    value.length < 6
                ) {
                    input.classList.add('invalid');
                    valid = false;
                } else if (
                    input.classList.contains('form__input-email') &&
                    !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)
                ) {
                    input.classList.add('invalid');
                    valid = false;
                } else {
                    input.classList.remove('invalid');
                }
            }
        });

        if (!valid) return;

        submit.disabled = false;
        
        const formData = new FormData(registerForm);
        formData.append('action', 'register_user');

        fetch('/wp-admin/admin-ajax.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                const successMsg = registerForm.querySelector('.popup-success');
                const errorMsg = registerForm.querySelector('.popup-error');
                const errorText = registerForm.querySelector('.popup-error__text');

                if (data.success) {
                    successMsg.classList.remove('hidden');
                    errorMsg.classList.add('hidden');
                    submit.disabled = true;
                } else {
                    const { field, message } = data.data;

                    errorMsg.classList.remove('hidden');
                    successMsg.classList.add('hidden');
                    submit.disabled = false;

                    if (field) {
                        errorText.textContent = message;
                    }
                }
            })
            .catch(err => {
                console.error(err);
                submit.disabled = false;
            });
    });
}

// function validateInputs (input) {
//    return valid true / false
// }
