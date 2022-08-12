const userInfoHeader = document.querySelector(".message .chat_area header");
const messageForm = document.querySelector(".message .chat_area .typing-area");
const toId = messageForm.querySelector(".to_id");

const chatBox = document.querySelector(".message .chat_area .chat_box");

const messageInputField = messageForm.querySelector(".input_field");
const messageSendBtn = messageForm.querySelector("button");

messageForm.onsubmit = (e) => {
    e.preventDefault();
};

// メッセージ送信
messageSendBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/addChat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log(xhr.response);
                messageInputField.value = "";
            }
        }
    };

    let formData = new FormData(messageForm);
    xhr.send(formData);
};

//ユーザー情報取得
const getUserInfo = (userId) => {
    chatBox.innerHTML = "";
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/getUserInfo.php", true);
    xhr.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                userInfoHeader.innerHTML = data;
                toId.setAttribute("value", userId);
            }
        }
    };

    xhr.send(`userId=${userId}`);
};

// チャットの更新
setInterval( () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/getChat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                chatBox.innerHTML = data;
            }
        }
    };

    let formData = new FormData(messageForm);
    xhr.send(formData);
}, 1000);