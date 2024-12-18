document.addEventListener('DOMContentLoaded', function () {
    // Dynamically import header and footer
    loadHeader();
    loadFooter();

    // Start the image carousel
    startCarousel();
});

// Function to load the header HTML
function loadHeader() {
    const headerContainer = document.getElementById('header-container');
    fetch('/views/header.html')
        .then(response => response.text())
        .then(data => {
            headerContainer.innerHTML = data;
        })
        .catch(error => {
            console.error('Error loading header:', error);
        });
}

// Function to load the footer HTML
function loadFooter() {
    const footerContainer = document.getElementById('footer-container');
    fetch('/views/footer.html')
        .then(response => response.text())
        .then(data => {
            footerContainer.innerHTML = data;
        })
        .catch(error => {
            console.error('Error loading footer:', error);
        });
}

// Function to start the image carousel
function startCarousel() {
    const carouselImages = document.querySelector('.carousel-images');
    let index = 0;

    setInterval(() => {
        index++;
        if (index >= 4) {
            index = 0;
        }

        const offset = -index * 100;
        carouselImages.style.transform = `translateX(${offset}%)`;
    }, 3000);  // Change image every 3 seconds
}
