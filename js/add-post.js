const addPostForm = document.querySelector(".postBox form");
const addPostBtn = addPostForm.querySelector("input[type='submit']");

addPostForm.onsubmit = (e) => {
    e.preventDefault();
};

//投稿の追加
addPostBtn.onclick = () => {
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

    let formData = new FormData(addPostForm);
    xhr.send(formData);
};