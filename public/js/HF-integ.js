document.addEventListener('DOMContentLoaded', function () {
    // Dynamically import header and footer
    loadHeader();
    loadFooter();

    // Initialize the image carousel for the Whole Life Insurance page
    startCarousel();
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
