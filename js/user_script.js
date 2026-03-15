let profile = document.querySelector('.header .flex .profile-detail');
document.querySelector('#user-btn').onclick = () => {
    profile.classList.toggle('active');
    searchform.classList.remove('active');
};

let searchform = document.querySelector('.header .flex .search-form'); 
document.querySelector('#search-btn').onclick = () => { 
    searchform.classList.toggle('active');
    profile.classList.remove('active');
};

let navbar = document.querySelector('.navbar');
document.querySelector('#menu-btn').onclick = () => {
    navbar.classList.toggle('active');
};

// Home slider
const imgBox = document.querySelector('.slider-container');
const slides = document.getElementsByClassName('slidebox');
var i = 0;

function nextslide() {
    slides[i].classList.remove('active');
    i = (i + 1) % slides.length;
    slides[i].classList.add('active');
}

function prevslide() {
    slides[i].classList.remove('active');
    i = (i - 1 + slides.length) % slides.length;
    slides[i].classList.add('active');
}
