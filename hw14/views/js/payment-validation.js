document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('paymentForm');
    const patientID = document.getElementById('patientID');
    const amount = document.getElementById('amount');
    const date = document.getElementById('date');

    form.addEventListener('submit', (e) => {
        let errors = [];

        if (patientID.value.length !== 10 || !/^\d+$/.test(patientID.value)) {
            errors.push("Patient ID must have exactly 10 numeric digits.");
        }

        if (parseFloat(amount.value) <= 0) {
            errors.push("Payment amount must be greater than zero.");
        }

        const selectedDate = new Date(date.value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        if (selectedDate > today) {
            errors.push("Payment date cannot be in the future.");
        }

        if (errors.length > 0) {
            e.preventDefault();
            alert("Payment validation error:\n\n- " + errors.join("\n- "));
        }
    });
});