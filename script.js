// Mobile menu
const nav = document.querySelector('.nav');
const hamburger = document.getElementById('hamburger');
const links = document.getElementById('navLinks');

hamburger?.addEventListener('click', () => {
  nav.classList.toggle('nav--open');
});

// Add a subtle parallax to gradient
const gradient = document.querySelector('.gradient-bg');
document.addEventListener('pointermove', (e) => {
  const { innerWidth:w, innerHeight:h } = window;
  const x = (e.clientX - w/2) / w * 10;
  const y = (e.clientY - h/2) / h * 10;
  gradient.style.transform = `translate(${x}px, ${y}px)`;
});
