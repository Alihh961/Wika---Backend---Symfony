/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// loads the jquery package from node_modules
import "./bootstrap";

const $ = require('jquery');
import "./ajax";



// any CSS you import will output into a single css file (app.css in this case)
import "./styles/app.scss";

// start the Stimulus application

import "./errorTemplates";

//importing fontawesome
import "@fortawesome/fontawesome-free/js/fontawesome";
import "@fortawesome/fontawesome-free/js/solid";
import "@fortawesome/fontawesome-free/js/regular";
import "@fortawesome/fontawesome-free/js/brands";

// Sign-in Form
function checkInputValues() { // Translate the label when focusing in and out in the input

    let inputs = [document.querySelectorAll(".login-input"), document.querySelectorAll(".register-input")];

    for (let i = 0; i < inputs.length; i++) {

        inputs[i].forEach((input) => {
            input.addEventListener("focusout", () => {
                console.log(input.value);

                if (input.value != "") {
                    if (input.classList.contains("special-input")) {
                        input.classList.add("special-translate");
                        console.log("special");
                        ;
                    } else {
                        input.classList.add("translate");
                        console.log("not special")
                    }


                } else {
                    if (input.classList.contains("special-input")) {
                        input.classList.remove("special-translate");
                    }
                    input.classList.remove("translate");
                }
            });
        });

    }

};
function checkInputValuesOnLoad() { // check if the input have a value on load , translate the label

    let inputs = [document.querySelectorAll(".login-input"), document.querySelectorAll(".register-input")];

    for (let i = 0; i < inputs.length; i++) {

        inputs[i].forEach((input) => {

            if (input.value != "") {
                if (input.classList.contains("special-input")) {
                    input.classList.add("special-translate");
                }
                 else {
                    input.classList.add("translate");
                }

            } else {
                if (input.classList.contains("special-input")) {
                    input.classList.remove("special-translate");
                }  else {
                    input.classList.remove("translate");

                }
            }
        });

    }

};
checkInputValues();
checkInputValuesOnLoad();




// Controlling the borders of the first and last child of pagination .
function addBorders() {
    // the current page element is an html element <span> while the others will be <span> with a child html element
    // <a> so we check if the current page is number 1 we add the class of borders to the span element  while
    // if it is not the first then we will access to the html element <a> of the first <span> of the pagination and
    // we add the class to it , we do the same for the last element;

    const paginationDiv = document.querySelector('.pagination');
    const paginationLength = paginationDiv.children.length; // number of pagination children

    if (paginationDiv.children[0].classList.contains("current")) {
        paginationDiv.children[0].classList.add("first-pagination");

    } else {
        const a = paginationDiv.children[0].querySelector("a");
        a.classList.add('first-pagination');
    }
    if (paginationDiv.children[paginationLength - 1].classList.contains("current")) {
        paginationDiv.children[paginationLength - 1].classList.add("last-pagination");

    } else {
        const a = paginationDiv.children[paginationLength - 1].querySelector("a");
        a.classList.add("last-pagination");

    }
}
addBorders();




