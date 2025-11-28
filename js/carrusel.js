// JavaScript para el carrusel de productos
document.addEventListener('DOMContentLoaded', function() {
    const carouselTrack = document.querySelector('.carousel-track');
    const slides = document.querySelectorAll('.carousel-slide');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const dots = document.querySelectorAll('.dot');
    
    let currentSlide = 0;
    const totalSlides = slides.length;
    
    // Función para actualizar el carrusel
    function updateCarousel() {
        const slideWidth = slides[0].getBoundingClientRect().width + 20; // + gap
        carouselTrack.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
        
        // Actualizar dots
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentSlide);
        });
        
        // Actualizar estado de botones
        prevBtn.disabled = currentSlide === 0;
        nextBtn.disabled = currentSlide >= totalSlides - getSlidesPerView();
    }
    
    // Función para obtener cuántos slides caben en la vista
    function getSlidesPerView() {
        const width = window.innerWidth;
        if (width <= 768) return 1;
        if (width <= 992) return 2;
        return 3;
    }
    
    // Event listeners para botones
    prevBtn.addEventListener('click', () => {
        if (currentSlide > 0) {
            currentSlide--;
            updateCarousel();
        }
    });
    
    nextBtn.addEventListener('click', () => {
        const slidesPerView = getSlidesPerView();
        if (currentSlide < totalSlides - slidesPerView) {
            currentSlide++;
            updateCarousel();
        }
    });
    
    // Event listeners para dots
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            updateCarousel();
        });
    });
    
    // Auto-avance opcional (descomenta si lo quieres)
    /*
    setInterval(() => {
        const slidesPerView = getSlidesPerView();
        if (currentSlide < totalSlides - slidesPerView) {
            currentSlide++;
        } else {
            currentSlide = 0;
        }
        updateCarousel();
    }, 5000);
    */
    
    // Actualizar en resize
    window.addEventListener('resize', updateCarousel);
    
    // Inicializar
    updateCarousel();
});