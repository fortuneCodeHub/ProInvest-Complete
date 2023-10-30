/**
 * Offcanvas Navbar
 */
const navbarBtns = document.querySelectorAll('#offCanvasBtn');
const navBg = document.querySelector('.offcanvas-collapse');
const toggle = (function () {
    return function toggle() {
        navbarBtns.forEach(navbarBtn => {
            navbarBtn.addEventListener('click', function () {
                navBg.classList.toggle('open');
            });
        });
    }
})();
toggle();
/**
 * Navbar Active selector and deselector
 */

const navlink = document.querySelectorAll("#nav-link");

function unsetActive(value) {
    for (let i = 0; i < value.length; i++) {
        const valueArray = value[i].classList;
        for (let a = 0; a < valueArray.length; a++) {
            if (valueArray[a] == "active") {
                valueArray.remove("active");
            }
        }
    }
}

for (let i = 0; i < navlink.length; i++) {
    navlink[i].addEventListener("click", function () {
        const navArray = navlink[i].classList;
        unsetActive(navlink);
        for (let a = 0; a < navArray.length; a++) {
            if (navArray[a] != "active") {
                navArray.add("active");
            }
        }
    });
}

/**
 * Reveal Animation On scroll
 */
window.addEventListener("scroll", reveal);

function reveal() {
    const reveals = document.querySelectorAll(".reveal");
    const buttonUp = document.querySelector(".button-up-link");
    for (let i = 0; i < reveals.length; i++) {
        let windowHeight = window.innerHeight;
        let revealTop = reveals[i].getBoundingClientRect().top;
        let revealPoint = 150;


        if (revealTop < windowHeight - revealPoint) {
            reveals[i].classList.add("active");
            buttonUp.classList.add("active");
        } else {
            reveals[i].classList.remove("active");
            buttonUp.classList.remove("active");
        }
        
    } 
}

/**
 * CountUp Animation
 */
const valueDisplays = document.querySelectorAll(".num");
// const interval = 1000000;

valueDisplays.forEach(valueDisplay => {
    let startValue = 0;
    let endValue = parseInt(valueDisplay.getAttribute("data-val"));
    // let duration = Math.floor(interval / endValue);
    let counter = setInterval(function () {
        if (startValue == endValue) {
            clearInterval(counter);
        } else if (startValue > endValue) {
            clearInterval(counter);
            valueDisplay.textContent = endValue;
        } else {
            startValue += 1000000;
            valueDisplay.textContent = startValue;
        }
        
    });
});

/**
 * Testimonial Slide
 */
const slides = document.querySelectorAll(".testimonial-slide");
const nextBtn = document.querySelector(".nextBtn");
const prevBtn = document.querySelector(".prevBtn");
const indicators = document.querySelector(".slide-indicators");

for (let i = 0; i < slides.length; i++) {
    slides[i].style.left = `${i * 100}%`;
    indicators.innerHTML += `<p class="mx-2 slide-radio" style="width: 15px; height: 15px;"></p>`;
}

const radios = document.querySelectorAll(".slide-radio");
radios[0].classList.add("checked");

function checked(counter) {
    radios.forEach(radio => {
        for (let i = 0; i < radio.classList.length; i++) {
            if (radio.classList[i] == "checked") {
                radio.classList.remove("checked");
                radios[counter].classList.add("checked");
            }
        }
    });
}

let counter = 0;
nextBtn.addEventListener('click', function () {
    counter++;
    carousel();
    checked(counter);
});

prevBtn.addEventListener('click', function () {
    counter--;
    carousel();
    checked(counter);
});

function carousel() {
    // working with slides

    if (counter === slides.length) {
        counter = 0;
    }
    if (counter < 0) {
        counter = slides.length - 1;
    }
    slides.forEach(function (slide) {
        slide.style.transform = `translateX(-${counter * 100}%)`;
    });
}

