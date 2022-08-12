<?php
//ログアウト処理

session_start();

if (isset($_SESSION['unique_id'])) {
    require_once './userLogic.php';
    $logout_id = filter_input(INPUT_GET, 'logout_id');
    if (isset($logout_id)) {
        session_unset();
        session_destroy();
        header("location: ../login.php");
    } else {
        header("location: ../home.php");
    }
} else {
    header("location: ../login.php");
}
?>