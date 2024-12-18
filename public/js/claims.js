document.addEventListener('DOMContentLoaded', function () {
    // Dynamically import header and footer
    loadHeader();
    loadFooter();

    // Form submission handling
    const form = document.getElementById('claims-form');
    if (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            // Convert form data to a JSON object
            const formData = new FormData(form);
            const formObject = {};
            formData.forEach((value, key) => {
                formObject[key] = value;
            });

            // Debugging: Log the form data
            console.log("Form data being sent:", formObject);

            // Send data to the backend API
            fetch('http://localhost/LifeCare/backend/api/submit_claim.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formObject), // Send the data as JSON
            })
                .then(response => {
                    // Debugging: Log the response status
                    console.log("Response status:", response.status);

                    if (!response.ok) {
                        // Handle non-2xx HTTP responses
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Debugging: Log the response data
                    console.log("Response from server:", data);

                    if (data.message) {
                        alert(data.message); // Display the success message
                        form.reset(); // Reset the form after successful submission
                    } else {
                        alert("Error: No message received from the server.");
                    }
                })
                .catch(error => {
                    console.error('Error submitting the form:', error);
                    alert("There was an error submitting your claim. Please try again later.");
                });
        });
    } else {
        console.error("Form with ID 'claims-form' not found.");
    }
});

// Function to load the header HTML dynamically
function loadHeader() {
    const headerContainer = document.getElementById('header');
    if (headerContainer) {
        fetch('/views/header.html')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Failed to load header. HTTP status: ${response.status}`);
                }
                return response.text();
            })
            .then(data => {
                headerContainer.innerHTML = data;
            })
            .catch(error => {
                console.error('Error loading header:', error);
            });
    } else {
        console.error("Header container with ID 'header' not found.");
    }
}

// Function to load the footer HTML dynamically
function loadFooter() {
    const footerContainer = document.getElementById('footer');
    if (footerContainer) {
        fetch('/views/footer.html')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Failed to load footer. HTTP status: ${response.status}`);
                }
                return response.text();
            })
            .then(data => {
                footerContainer.innerHTML = data;
            })
            .catch(error => {
                console.error('Error loading footer:', error);
            });
    } else {
        console.error("Footer container with ID 'footer' not found.");
    }
}
