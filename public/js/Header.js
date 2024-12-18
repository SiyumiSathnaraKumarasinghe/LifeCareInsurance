// Optional Dropdown Animation
document.querySelectorAll('.dropdown').forEach(dropdown => {
    dropdown.addEventListener('mouseover', () => {
        dropdown.querySelector('.dropdown-menu').style.display = 'block';
    });

    dropdown.addEventListener('mouseout', () => {
        dropdown.querySelector('.dropdown-menu').style.display = 'none';
    });
});
