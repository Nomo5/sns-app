const loginForm = document.querySelector(".login form");
const loginBtn = loginForm.querySelector(".button input");
const loginErrorTxt = loginForm.querySelector(".login .error-txt");

loginForm.onsubmit = (e) => {
    e.preventDefault();
};

//ログイン処理
loginBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/login.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                console.log(data);
                if (data == "success") {
                    location.href = "home.php";
                } else {
                    loginErrorTxt.textContent = data;
                    loginErrorTxt.style.display = "block";
                }
            }
        }
    };

    let formData = new FormData(loginForm);
    xhr.send(formData);
};