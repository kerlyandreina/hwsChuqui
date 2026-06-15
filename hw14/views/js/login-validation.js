document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');

    form.addEventListener('submit', (event) => {
        const user = form["username"].value.trim();
        const pass = form["password"].value.trim();

        if (user === "" || pass === "") {
            alert("All fields are required.");
            event.preventDefault();
            return;
        }

        const userRegex = /^[a-zA-Z0-9]+$/;
        if (!userRegex.test(user)) {
            alert("Username can only contain letters and numbers (no spaces or special characters).");
            event.preventDefault();
            return;
        }

        if (pass.length > 8) {
            alert("Password must not exceed 8 characters.");
            event.preventDefault();
            return;
        }

        const passRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/;
        if (!passRegex.test(pass)) {
            alert("Password must contain at least one uppercase letter, one lowercase letter, one number and one special character.");
            event.preventDefault();
            return;
        }
    });
});