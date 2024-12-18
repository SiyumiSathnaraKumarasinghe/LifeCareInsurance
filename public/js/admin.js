document.addEventListener("DOMContentLoaded", () => {
    // Load header and footer dynamically
    loadHeader();
    loadFooter();

    const claimsTableBody = document.querySelector("#claims-table tbody");

    // Fetch claims and populate the table
    fetch("http://localhost/LifeCare/backend/api/fetch_claims.php")
        .then(response => response.json())
        .then(data => {
            data.forEach(claim => {
                const row = document.createElement("tr");

                row.innerHTML = `
                    <td>${claim.name}</td>
                    <td>${claim.nic}</td>
                    <td>${claim.telephone}</td>
                    <td>${claim.email}</td>
                    <td>${claim.age}</td>
                    <td>${claim.package}</td>
                    <td>${claim.non_communicable_diseases}</td>
                    <td>${claim.additional_info}</td>
                    <td>
                        <button class="delete-btn" data-id="${claim.id}">Delete</button>
                    </td>
                `;
                claimsTableBody.appendChild(row);
            });
        })
        .catch(error => console.error("Error fetching claims:", error));

    // Add event listener for delete buttons
    claimsTableBody.addEventListener("click", event => {
        if (event.target.classList.contains("delete-btn")) {
            const claimId = event.target.getAttribute("data-id");
            if (confirm("Are you sure you want to delete this claim?")) {
                fetch("http://localhost/LifeCare/backend/api/delete_claim.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ id: claimId }),
                })
                    .then(response => response.json())
                    .then(result => {
                        if (result.message) {
                            alert(result.message);
                            event.target.closest("tr").remove(); // Remove row from table
                        } else {
                            alert("Error deleting claim.");
                        }
                    })
                    .catch(error => console.error("Error deleting claim:", error));
            }
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
