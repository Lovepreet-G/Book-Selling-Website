const uname = document.getElementById('name');
const mobile = document.getElementById('mobile_number');
const password = document.getElementById('password');
const cPassword = document.getElementById('c_password');
const form = document.getElementById('form');
const errorElememt = document.getElementById('error');
const nameError = document.getElementById('nameError');
const cpassError = document.getElementById('cpassError');
const numberError = document.getElementById('numberError');

const upper = document.getElementById('upper');
const lower = document.getElementById('lower');
const digit = document.getElementById('digit');
const special = document.getElementById('special');
const len = document.getElementById('length');
const f = document.getElementById('flag');

var letters = /^[A-Za-z ]+$/;

form.addEventListener("submit", (e) => {
    var flag = 0;

    if(!(uname.value.match(letters))) {
        flag = 1;
        nameError.innerText = 'Name must contain only alphabets.';
        uname.value = "";
    }

    if(mobile.value.length != 10) {
        flag = 1;
        numberError.innerText = "Mobile number must contain 10 digits.";
        mobile.value = "";
    }

    if(password.value === "") {
        flag = 1;
        upper.style.color = "tomato";
        lower.style.color = "tomato";
        digit.style.color = "tomato";
        special.style.color = "tomato";
        len.style.color = "tomato";

        upper.innerText = "Password must contain atleast 1 uppercase alphabet";
        lower.innerText = "Password must contain atleast 1 lowercase alphabet";
        special.innerText = "Password must contain atleast 1 special character(# ? ! @ $ % ^ & * _)";
        digit.innerText = "Password must contain atleast 1 digit";
        len.innerText = "Password must contain 8-16 characters";
    } else {
        if(password.value.match(/[0-9]/)) {
            digit.style.color = "green";
            digit.innerText = "Password must contain atleast 1 digit";
        } else {
            digit.style.color = "tomato";
            digit.innerText = "Password must contain atleast 1 digit";
        }
    
        if(password.value.match(/[A-Z]/)) {
            upper.style.color = "green";
            upper.innerText = "Password must contain atleast 1 uppercase alphabet";
        } else {
            upper.style.color = "tomato";
            upper.innerText = "Password must contain atleast 1 uppercase alphabet";
        }
    
        if(password.value.match(/[a-z]/)) {
            lower.style.color = "green";
            lower.innerText = "Password must contain atleast 1 lowercase alphabet";
        } else {
            lower.style.color = "tomato";
            lower.innerText = "Password must contain atleast 1 lowercase alphabet";
        }
    
        if(password.value.match(/[#?!@$%^&*_]/)) {
            flag = 0
            special.style.color = "green";
        } else {
            flag = 1;
            special.style.color = "tomato";
        }
    
        if(password.value.length < 8 || password.value.length > 16) {
            len.style.color = "tomato";
            special.innerText = "Password must contain atleast 1 special character(# ? ! @ $ % ^ & * _)";
        } else {
            len.style.color = "green";
            special.innerText = "Password must contain atleast 1 special character(# ? ! @ $ % ^ & * _)";
        }
    }

    if(len.style.color === "green" && special.style.color === "green" && digit.style.color === "green" && lower.style.color === "green" && upper.style.color === "green") {
        flag = 0;  
    } else {
        flag = 1;
    }

    if(cPassword.value != password.value) {
        flag = 1;
        cpassError.innerText = 'Passwords don\'t match, please re-enter password.';
        cPassword.focus;
        cPassword.value = "";
    }

    if(flag === 1) {
         e.preventDefault();
    }
})