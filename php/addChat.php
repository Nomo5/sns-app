<?php
//メッセージを追加

session_start();
if (isset($_SESSION['unique_id'])) {
    require_once './messageLogic.php';
    $from_id = $_SESSION['unique_id'];
    $to_id = filter_input(INPUT_POST, 'to_id');
    $message = filter_input(INPUT_POST, 'message');

    if (!$to_id || !$message) {
        echo "error";
    } else {
        $result = MessageLogic::addMessage($from_id, $to_id, $message);
        if ($result) {
            echo "success";
        } else {
            echo "error" ;
        }
    }
} else {
    header("../login.php");
}

?>