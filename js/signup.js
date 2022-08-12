const signupForm = document.querySelector(".signup form");
const signupBtn = signupForm.querySelector(".button input");
const signupErrorTxt = signupForm.querySelector(".signup .error-txt");

signupForm.onsubmit = (e) => {
    e.preventDefault();
};

//新規登録処理
signupBtn.onclick = () => {
    
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/signup.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if (data == "success") {
                    location.href = "home.php";
                } else {
                    signupErrorTxt.textContent = data;
                    signupErrorTxt.style.display = "block";
                }
            }
        }
    };

    let formData = new FormData(signupForm);
    xhr.send(formData);
};