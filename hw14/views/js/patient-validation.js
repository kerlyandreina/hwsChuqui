document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('patientForm');
    const birthdayInput = document.getElementById('birthday');
    const legalRepInput = document.getElementById('legalRepresentative');
    const idInput = document.getElementById('patientID');
    const phoneInput = document.getElementById('phone');

    form.addEventListener('submit', (e) => {
        let errors = [];

        const tenDigitRegex = /^[0-9]{10}$/;
        if (!tenDigitRegex.test(idInput.value)) {
            errors.push("ID number must contain exactly 10 numeric digits.");
        }
        if (!tenDigitRegex.test(phoneInput.value)) {
            errors.push("Phone number must contain exactly 10 numeric digits.");
        }

        const birthDate = new Date(birthdayInput.value);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        if (age < 18 && legalRepInput.value.trim() === "") {
            errors.push("The patient is a minor (" + age + " years old). You must enter the legal representative's name.");
            legalRepInput.classList.add('is-invalid');
        } else {
            legalRepInput.classList.remove('is-invalid');
        }

        if (birthDate > today) {
            errors.push("Date of birth cannot be a future date.");
        }

        if (errors.length > 0) {
            e.preventDefault();
            alert("Form errors:\n\n" + errors.map(err => "- " + err).join("\n"));
        }
    });
});