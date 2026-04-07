export function loginInit() {
    const form = document.querySelector('.form-login');

    if (!form) {
        console.log("❌ there is no form");
        return; 
    }

    console.log("✅ form found:", form);

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        console.log("📦 FORM DATA:");

        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }

        console.log("📦 OBJECT:", Object.fromEntries(formData.entries()));
    });
}