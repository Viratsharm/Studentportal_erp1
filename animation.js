document.addEventListener('DOMContentLoaded', () => {
    const formContainer = document.querySelector('.form-container');

    // Apply initial fade-in effect with rotation and scaling
    formContainer.style.opacity = '0';
    formContainer.style.transform = 'scale(0.8) rotate(-5deg)';
    formContainer.style.transition = 'opacity 1s ease-out, transform 1s ease-out';

    // Trigger the fade-in effect after the DOM is fully loaded
    setTimeout(() => {
        formContainer.style.opacity = '1';
        formContainer.style.transform = 'scale(1) rotate(0)';
    }, 100); // Delay for a smooth transition

    // Add hover interactivity for a premium feel
    formContainer.addEventListener('mouseenter', () => {
        formContainer.style.boxShadow = '0 15px 50px rgba(0, 255, 150, 0.6), 0 10px 20px rgba(0, 150, 255, 0.4)';
        formContainer.style.transition = 'box-shadow 0.5s ease, transform 0.4s ease';
        formContainer.style.transform = 'scale(1.05) rotate(2deg)';
    });

    formContainer.addEventListener('mouseleave', () => {
        formContainer.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.2)';
        formContainer.style.transform = 'scale(1) rotate(0)';
    });

    // Add subtle tilt effect on mouse movement
    formContainer.addEventListener('mousemove', (event) => {
        const rect = formContainer.getBoundingClientRect();
        const x = ((event.clientX - rect.left) / rect.width - 0.5) * 10; // Tilt based on horizontal mouse position
        const y = ((event.clientY - rect.top) / rect.height - 0.5) * 10; // Tilt based on vertical mouse position
        formContainer.style.transform = `scale(1.05) rotateX(${y}deg) rotateY(${x}deg)`;
    });

    // Reset tilt effect when the mouse leaves the container
    formContainer.addEventListener('mouseleave', () => {
        formContainer.style.transform = 'scale(1) rotate(0)';
    });
});
