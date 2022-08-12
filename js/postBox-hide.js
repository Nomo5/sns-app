const showPostBtn = document.querySelector(".sidebar .sidebarButton button");
const model = document.querySelector(".model");
const postCartBox = document.querySelector(".post_cardBox");

const hiddenCloseBtn = document.querySelector(".post_cardBox .header p");

const hiddenPostForm = postCartBox.querySelector(".hiddenPostBox form");
const hiddenPostBtn = hiddenPostForm.querySelector("input[type='submit']");

//投稿ウィンドウの表示
showPostBtn.onclick = () => {
    postCartBox.style.display = "block";
    model.style.display = "block";
};

//投稿ウィンドウの非表示
hiddenCloseBtn.onclick = () => {
    postCartBox.style.display = "none";
    model.style.display = "none";
}

hiddenPostForm.onsubmit = (e) => {
    e.preventDefault();
};

//投稿の追加
hiddenPostBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/addPost.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if (data == "success") {
                    location.reload();
                } else {
                    alert(data);
                }
            }
        }
    };

    let formData = new FormData(hiddenPostForm);
    xhr.send(formData);
};