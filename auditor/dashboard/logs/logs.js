// Sample data for audit logs
const auditLogs = [
    {
        timestamp: '2024-10-08 10:30:00',
        action: 'Patient Data Viewed',
        user: 'Therapist A'
    },
    {
        timestamp: '2024-10-08 11:00:00',
        action: 'Therapist Logged In',
        user: 'Therapist B'
    },
    {
        timestamp: '2024-10-08 11:45:00',
        action: 'Patient Record Updated',
        user: 'Therapist C'
    },
    {
        timestamp: '2024-10-08 12:30:00',
        action: 'Audit Log Viewed',
        user: 'Auditor X'
    }
];

// Function to populate the audit logs table
function populateAuditLogs() {
    const tbody = document.querySelector('tbody');
    
    auditLogs.forEach(log => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${log.timestamp}</td>
            <td>${log.action}</td>
            <td>${log.user}</td>
        `;
        tbody.appendChild(row);
    });
}

// Call the function to populate the audit logs on page load
window.onload = populateAuditLogs;

// Function to handle the 'Go Back' button action
function goBack() {
    window.history.back(); // Navigate back to the previous page
}
