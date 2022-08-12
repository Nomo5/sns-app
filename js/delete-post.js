const deleteBox = document.querySelector(".mypage .deleteBox");
const deletePostModel = document.querySelector(".model");
const deleteBtn = deleteBox.querySelector(".buttons .delete");
const cancelBtn = deleteBox.querySelector(".buttons .cancel");

//投稿の削除
const deletePost = (postId) => {
    deleteBox.style.display = "block";
    deletePostModel.style.display = "block";

    deleteBtn.onclick = function(){
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "php/deletePost.php", true);
        xhr.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response;
                    console.log(data);
                    if (data == "success") {
                        location.reload();
                    }
                }
            }
        };
    
        xhr.send(`postId=${postId}`);
    };
    
};


cancelBtn.onclick = function(){
    location.reload();
};