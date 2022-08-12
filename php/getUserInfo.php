<?php
//ユーザーの情報を取得

require_once './userLogic.php';

$user = UserLogic::getUserByUniqueId($_POST['userId']);
$output = "";
if (isset($user)) {
    $output .= '<div class="user_info">
                <img src="./php/images/'.$user['img'].'">
                <span>'.$user['username'].'</span>
                </div>';
} else {
    $output .= "error";
}

echo $output;

?>