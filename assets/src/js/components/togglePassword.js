export function togglePassword() {
    const toggleButtons = document.querySelectorAll(".toggle-password");

    if (!toggleButtons.length) return;

    toggleButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const container = btn.closest(".password-field");

            const input = container.querySelector(".password-input");
            const showIcon = container.querySelector(".show-icon");
            const hideIcon = container.querySelector(".hide-icon");

            const isPassword = input.type === "password";

            // toggle input type
            input.type = isPassword ? "text" : "password";

            // toggle icons
            showIcon.classList.toggle("hidden", isPassword);
            hideIcon.classList.toggle("hidden", !isPassword);
        });
    });
}