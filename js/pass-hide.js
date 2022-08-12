const passInput = document.querySelector(".form input[type='password']");

const hideBtn = document.querySelector(".form .field i");

//パスワードの表示・非表示
hideBtn.onclick = () => {
    if (passInput.type == "password") {
        passInput.type = "text";
        hideBtn.classList.add("active");
    } else {
        passInput.type = "password";
        hideBtn.classList.remove("active");
    }
};