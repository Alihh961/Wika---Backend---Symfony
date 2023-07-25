/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "./styles/app.scss";

// start the Stimulus application
import "./bootstrap";

// Sign-in Form

let inputs = document.querySelectorAll(".login-input");
// let label = document.querySelectorAll(".login-input + label");
// console.log(label);
inputs.forEach((input) => {
  input.addEventListener("focusout", () => {
    if (input.value != "") {
    //   let label = document.querySelectorAll(".login-input + label");
    //   label.classList.add('label-position-up');
    input.classList.add("tes");
    } else {
        input.classList.remove("tes");

    }

  });
});
