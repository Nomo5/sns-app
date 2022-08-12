//いいね処理
const favorite = (postId) => {
    const post = document.getElementById(`${postId}`);
    const heartIcon = post.querySelector(".post_footer .heart i");
    const heartCount = post.querySelector(".post_footer .heart_count p");

    let count = Number(heartCount.textContent);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/favorite.php", true);
    xhr.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                console.log(data);
                if (data == "success") {
                    heartIcon.style.color = "red";
                    heartCount.textContent = count + 1;
                } else if (data == "delete-success") {
                    heartIcon.style.color = "rgb(179, 176, 176)";
                    heartCount.textContent = count - 1;
                }
            }
        }
    };

    xhr.send(`postId=${postId}`);
};