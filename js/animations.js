// JavaScript para funcionalidades interactivas
document.addEventListener('DOMContentLoaded', function() {
    // Menú hamburguesa
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');
    
    if (hamburger) {
        hamburger.addEventListener('click', function() {
            this.classList.toggle('active');
            navLinks.classList.toggle('active');
        });
    }
    
    // Header con scroll
    const header = document.querySelector('header');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
    
    // Carga de imágenes
    const productImages = document.querySelectorAll('.product-image img');
    
    productImages.forEach(img => {
        img.addEventListener('load', function() {
            this.parentElement.classList.add('loaded');
        });
        
        // Si la imagen ya está cargada
        if (img.complete) {
            img.parentElement.classList.add('loaded');
        }
    });
    
    // Cerrar menú al hacer clic en un enlace
    const navItems = document.querySelectorAll('.nav-links a');
    
    navItems.forEach(item => {
        item.addEventListener('click', function() {
            hamburger.classList.remove('active');
            navLinks.classList.remove('active');
        });
    });
});
