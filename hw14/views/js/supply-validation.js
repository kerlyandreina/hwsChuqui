const orderDateInput = document.getElementById('orderDate');
const expirationDateInput = document.getElementById('expirationDate');
const supplyForm = document.getElementById('supplyForm');

orderDateInput.addEventListener('change', () => {
    expirationDateInput.min = orderDateInput.value;
});

supplyForm.addEventListener('submit', (event) => {
    const orderDateValue = new Date(orderDateInput.value);
    const expirationDateValue = new Date(expirationDateInput.value);

    if (expirationDateValue < orderDateValue) {
        event.preventDefault();
        expirationDateInput.setCustomValidity('Expiration date cannot be earlier than the order date.');
        expirationDateInput.reportValidity();
    } else {
        expirationDateInput.setCustomValidity('');
    }
});

expirationDateInput.addEventListener('input', () => {
    expirationDateInput.setCustomValidity('');
});