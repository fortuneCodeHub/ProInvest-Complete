/**
 * Input style
 */
const inputs = document.querySelectorAll(".input");
const groups = document.querySelectorAll(".join-group");
// console.log(group);

function unsetActive() {
    groups.forEach(group => {
        group.classList.remove("active");
    });
}

for (let i = 0; i < inputs.length; i++) {
    inputs[i].addEventListener("click", function () {
        unsetActive();
        groups[i].classList.toggle("active");
    });
}

