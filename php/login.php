<?php
//ログイン処理

session_start();
require_once './userLogic.php';

$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

if (!$email || !$password) {
    echo "必要項目が未入力です。";
} else {
    $login_user = UserLogic::login($email, $password);
    if (!$login_user) {
        echo "メールアドレスかパスワードが一致しません。";
    } else {
        $_SESSION['unique_id'] = $login_user['unique_id'];
        echo "success";
    }
}

?>