<?php
//いいね処理
session_start();

require_once './postLogic.php';

$result = PostLogic::like($_SESSION['unique_id'], $_POST['postId']);
if ($result) {
    echo "success";
} else {
    $result2 = PostLogic::dislike($_SESSION['unique_id'], $_POST['postId']);
    if ($result2) {
        echo "delete-success";
    } else {
        echo "エラーです。";
    }
}
?>