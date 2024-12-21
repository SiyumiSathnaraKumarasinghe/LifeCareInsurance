document.addEventListener('DOMContentLoaded', function () {
    // Dynamically load header and footer
    loadHeader();
    loadFooter();

    // Fetch client data and pre-fill the form
    const clientId = new URLSearchParams(window.location.search).get('id');
    if (clientId) {
        fetchClientData(clientId);
    }

    // Handle form submission for updating client
    const updateForm = document.getElementById('update-form');
    updateForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        // Collect form data
        const formData = new FormData(updateForm);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

        // Send the updated data to the backend
        updateClientData(clientId, data);
    });
});

// Function to load the header HTML dynamically
function loadHeader() {
    const headerContainer = document.getElementById('header');
    fetch('/views/header.html')
        .then(response => response.text())
        .then(data => {
            headerContainer.innerHTML = data;
        })
        .catch(error => {
            console.error('Error loading header:', error);
        });
}

// Function to load the footer HTML dynamically
function loadFooter() {
    const footerContainer = document.getElementById('footer');
    fetch('/views/footer.html')
        .then(response => response.text())
        .then(data => {
            footerContainer.innerHTML = data;
        })
        .catch(error => {
            console.error('Error loading footer:', error);
        });
}

// Function to fetch client data by ID
function fetchClientData(clientId) {
    fetch(`/backend/api/get_client.php?id=${clientId}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                // Pre-fill the form fields with existing data
                document.getElementById('name').value = data.name;
                document.getElementById('nic').value = data.nic;
                document.getElementById('date_of_birth').value = data.date_of_birth;
                document.getElementById('contact_number').value = data.contact_number;
                document.getElementById('email').value = data.email;
                document.getElementById('address').value = data.address;
                document.getElementById('policy_type').value = data.policy_type;
                document.getElementById('coverage_amount').value = data.coverage_amount;
                document.getElementById('payment_frequency').value = data.payment_frequency;
                document.getElementById('beneficiary_name').value = data.beneficiary_name;
                document.getElementById('beneficiary_relationship').value = data.beneficiary_relationship;
                document.getElementById('height_cm').value = data.height_cm;
                document.getElementById('weight_kg').value = data.weight_kg;
                document.getElementById('smoker_status').value = data.smoker_status;
                document.getElementById('alcohol_status').value = data.alcohol_status;
                document.getElementById('medical_conditions').value = data.medical_conditions;
                document.getElementById('family_medical_history').value = data.family_medical_history;
                document.getElementById('occupation').value = data.occupation;
                document.getElementById('annual_income').value = data.annual_income;
                document.getElementById('payment_mode').value = data.payment_mode;
                document.getElementById('bank_account_details').value = data.bank_account_details;
                document.getElementById('emergency_contact_name').value = data.emergency_contact_name;
                document.getElementById('emergency_contact_relationship').value = data.emergency_contact_relationship;
                document.getElementById('emergency_contact_number').value = data.emergency_contact_number;
            }
        })
        .catch(error => {
            console.error('Error fetching client data:', error);
        });
}

// Function to update the client data
function updateClientData(clientId, data) {
    fetch(`/backend/api/update_client.php?id=${clientId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Client information updated successfully!');
            window.location.href = '/client-list.html'; // Redirect to client list page or wherever appropriate
        } else {
            alert('Failed to update client information. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error updating client data:', error);
        alert('An error occurred while updating client data.');
    });
}
