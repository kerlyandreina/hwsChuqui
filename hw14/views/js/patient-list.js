document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    const patientTable = document.getElementById('patientTable');
    const rows = Array.from(patientTable.querySelectorAll('.patient-row'));
    const deleteForms = document.querySelectorAll('.delete-form');

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        
        rows.forEach(row => {
            const fullName = row.querySelector('.fullName')?.textContent.toLowerCase() || '';
            const patientID = row.querySelector('.patientID')?.textContent.toLowerCase() || '';
            
            const matches = fullName.includes(query) || patientID.includes(query);
            row.style.display = matches ? '' : 'none';
        });
    });

    
    deleteForms.forEach(form => {
        form.addEventListener('submit', (event) => {
            if (!confirm('Are you sure you want to permanently delete this patient?')) {
                event.preventDefault();
            }
        });
    });
});