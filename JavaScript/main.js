"use strict";
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/

// collect the elements with query selectors, add eventlisteners and toggle the class "is-active" on and off. 
// css regulates if it showes or hides.
//hamburger menu, get button, show/hide menu on click
const hamburger = document.querySelector(".hamburger");
const mobilenav = document.querySelector(".mobile-nav");
hamburger.addEventListener("click", function() {
    hamburger.classList.toggle("is-active");
    mobilenav.classList.toggle("is-active");
    hamburger.setAttribute("aria-expanded", "true");
});


// fold out buttons
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementsByClassName("btn");
    for (let i = 0; i < btn.length; i++) {
        btn[i].addEventListener("click", function() {
            //get next element, the article
            let text = this.nextElementSibling;
            //if visible
            if (text.style.display === "block") {
                //hide
                text.style.display = "none";

                //change aria
                this.setAttribute("aria-expanded", "false");

                //change arrow
                btn[i].querySelector(".arrow").classList.remove("fa-chevron-up");
                btn[i].querySelector(".arrow").classList.add("fa-chevron-down");
            } else {
                //if hidden, show
                text.style.display = "block";

                //change aria
                this.setAttribute("aria-expanded", "true");

                //change arrow
                btn[i].querySelector(".arrow").classList.remove("fa-chevron-down");
                btn[i].querySelector(".arrow").classList.add("fa-chevron-up");
            }
        })
    }
})

// GDPR checkbox must be checked for registration button to activate
// gett checkbox and submitt btn and change disable to true/false dependeing on checkbox
document.addEventListener('DOMContentLoaded', function() {
    let input = document.getElementById('gdpr');
    let submit = document.getElementById('submit');
    if (input) {
        input.addEventListener("click", function() {
            if (input.checked) {
                submit.disabled = false;
            } else {
                submit.disabled = true;
            }
        })
    }
})


// warning for to manny characters in project intro
document.addEventListener('DOMContentLoaded', function() {
        let intro = document.getElementById('intro');
        let maxchar = document.getElementById('maxchar');
        let submit = document.getElementById('submit');
        if (intro) {
            intro.addEventListener("keyup", function() {
                let input = intro.value;

                if (input.length > 256) {
                    maxchar.innerHTML = "To manny characters, Max 256!";
                    submit.disabled = true;
                } else {
                    maxchar.innerHTML = "";
                    submit.disabled = false;
                }
            })
        }
    })
    // fold out skills
document.addEventListener('DOMContentLoaded', function() {
    const skill = document.getElementsByClassName("skillscontain");
    for (let i = 0; i < skill.length; i++) {
        skill[i].addEventListener("click", function() {
            //get next element, the article
            let text = this.nextElementSibling;
            //if visible
            if (text.style.display === "block") {
                //hide
                text.style.display = "none";

                //change aria
                this.setAttribute("aria-expanded", "false");

                //change arrow
                skill[i].querySelector(".arrow").classList.remove("fa-chevron-up");
                skill[i].querySelector(".arrow").classList.add("fa-chevron-down");
            } else {
                //if hidden, show
                text.style.display = "block";

                //change aria
                this.setAttribute("aria-expanded", "true");

                //change arrow
                skill[i].querySelector(".arrow").classList.remove("fa-chevron-down");
                skill[i].querySelector(".arrow").classList.add("fa-chevron-up");
            }
        })
    }
})


// mark what page you are on in menu
// when pages has loaded, get url, select menu (depending on main or admin) and check if url is same as manu url
// if the same change add class
document.addEventListener('DOMContentLoaded', function() {
    const hereyouare = window.location.pathname;
    const links = document.querySelectorAll('.menu .navlink').forEach(link => {
        // prevents all from hightlighting when on non specific start page
        if (hereyouare != "/~jeej2100/writeable/DT093G/projekt_vt22-Jessofnorth/") {
            if (link.href.includes(hereyouare)) {
                link.classList.add('youarehere');
            }
        }

    });
});
document.addEventListener('DOMContentLoaded', function() {
    const hereyouare = window.location.pathname;
    const admin = document.querySelectorAll('.adminmenu .link').forEach(link => {
        // prevents all from hightlighting when on non specific start page
        if (hereyouare != "/~jeej2100/writeable/DT093G/projekt_vt22-Jessofnorth/") {
            if (link.href.includes(hereyouare)) {
                link.classList.add('youarehereadmin');
            }
        }
    })
});