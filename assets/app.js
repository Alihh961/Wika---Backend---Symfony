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

let inputs = [document.querySelectorAll(".login-input"), document.querySelectorAll(".register-input")];

for(let i = 0 ; i<inputs.length ; i++){

inputs[i].forEach((input) => {
  input.addEventListener("focusout", () => {
    console.log(input.value);

    if (input.value != "") {
      // if(input.classList.contains("date-input")){
        
      // }
      
      input.classList.add("translate");
    } else {
      input.classList.remove("translate");
    }
  });
});

}

console.log("works");