<?php
//投稿を追加

if (!filter_input(INPUT_POST, 'content')) {
    echo "何か入力してください。";
} else {
    require_once './postLogic.php';
    
    $result = PostLogic::addPost($_POST['user_id'], $_POST['content']);
    if ($result) {
        echo "success";
    } else {
        echo "error";
    }
}
?>