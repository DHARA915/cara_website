

function setupCarousel(carouselId) {
    const carousel = document.getElementById(carouselId);
    const images = carousel.querySelector('.carousel-images');
    const slides = carousel.querySelectorAll('.carousel-slide');
    const totalSlides = slides.length;
    let currentIndex = 0;

    function slideToNext() {
        currentIndex = (currentIndex + 1) % totalSlides;
        const offset = -currentIndex * 100;
        images.style.transform = `translateX(${offset}%)`;
    }

    setInterval(slideToNext, 3000); // Change slide every 3 seconds
}

// Initialize the carousel
setupCarousel('carousel1');

// responsive

const bar =document.getElementById('bar');
const close =document.getElementById('close');
const nav=document.getElementById('navbar');

if(bar){
    bar.addEventListener('click',()=>{
        nav.classList.add('active');
        document.getElementById('cart').style.display='none';
    })
  
}

if(close){
    close.addEventListener('click',()=>{
        nav.classList.remove('active');
        document.getElementById('cart').style.display='flex';
       
    })
  
}




