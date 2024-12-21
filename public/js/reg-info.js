document.addEventListener("DOMContentLoaded", () => {
    // Load header and footer dynamically
    loadHeader();
    loadFooter();

    const clientsTableBody = document.querySelector("#clients-table tbody");

    // Fetch clients and populate the table
    fetch("http://localhost/LifeCare/backend/api/fetch_clients.php")
        .then(response => response.json())
        .then(data => {
            data.forEach(client => {
                const row = document.createElement("tr");

                row.innerHTML = `
                    <td>${client.name}</td>
                    <td>${client.nic}</td>
                    <td>${client.date_of_birth}</td>
                    <td>${client.contact_number}</td>
                    <td>${client.email}</td>
                    <td>${client.address}</td>
                    <td>${client.policy_type}</td>
                    <td>${client.coverage_amount}</td>
                    <td>${client.payment_frequency}</td>
                    <td>${client.beneficiary_name}</td>
                    <td>${client.beneficiary_relationship}</td>
                    <td>${client.height_cm}</td>
                    <td>${client.weight_kg}</td>
                    <td>${client.smoker_status}</td>
                    <td>${client.alcohol_status}</td>
                    <td>${client.medical_conditions}</td>
                    <td>${client.family_medical_history}</td>
                    <td>${client.occupation}</td>
                    <td>${client.annual_income}</td>
                    <td>${client.payment_mode}</td>
                    <td>${client.bank_account_details}</td>
                    <td>${client.emergency_contact_name}</td>
                    <td>${client.emergency_contact_relationship}</td>
                    <td>${client.emergency_contact_number}</td>
                    <td>
                        <button class="edit-btn" data-id="${client.nic}">Edit</button>
                        <button class="delete-btn" data-id="${client.nic}">Delete</button>
                    </td>
                `;
                clientsTableBody.appendChild(row);
            });
        })
        .catch(error => console.error("Error fetching clients:", error));

    // Add event listener for delete and edit buttons
    clientsTableBody.addEventListener("click", event => {
        const clientId = event.target.getAttribute("data-id");

        // Handle delete
        if (event.target.classList.contains("delete-btn")) {
            if (confirm("Are you sure you want to delete this client?")) {
                fetch("http://localhost/LifeCare/backend/api/delete_client.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ nic: clientId }),
                })
                    .then(response => response.json())
                    .then(result => {
                        if (result.message) {
                            alert(result.message);
                            event.target.closest("tr").remove(); // Remove row from table
                        } else {
                            alert("Error deleting client.");
                        }
                    })
                    .catch(error => console.error("Error deleting client:", error));
            }
        }

        // Handle edit
        if (event.target.classList.contains("edit-btn")) {
            // Redirect to the client edit page with the NIC in the query string
            window.location.href = `/views/registration.html?nic=${clientId}`;
        }
    });
});

// Function to load the header HTML dynamically
function loadHeader() {
    const headerContainer = document.getElementById("header");
    fetch("/views/header.html")
        .then(response => response.text())
        .then(data => {
            headerContainer.innerHTML = data;
        })
        .catch(error => {
            console.error("Error loading header:", error);
        });
}

// Function to load the footer HTML dynamically
function loadFooter() {
    const footerContainer = document.getElementById("footer");
    fetch("/views/footer.html")
        .then(response => response.text())
        .then(data => {
            footerContainer.innerHTML = data;
        })
        .catch(error => {
            console.error("Error loading footer:", error);
        });
}
