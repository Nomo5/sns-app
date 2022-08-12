<?php
//投稿の削除

require_once './postLogic.php';

$result = PostLogic::deletePost($_POST['postId']);

if ($result) {
    echo "success";
} else {
    echo "エラーです。";
}

?>