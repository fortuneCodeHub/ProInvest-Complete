/**
 * offcanvas navbar
 */
const navbarBtns = document.querySelectorAll('.nav-btn');
const navBg = document.querySelector('.side-nav-bg');
const toggle = (function () {
    return function toggle() {
        navbarBtns.forEach(navbarBtn => { 
            navbarBtn.addEventListener("click", function () {
                navBg.classList.toggle("open");
                console.log(navBg.classList);
            });
        });
    };
})();
toggle();