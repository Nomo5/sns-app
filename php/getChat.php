<?php
//チャットを取得

session_start();
if (isset($_SESSION['unique_id'])) {
    require_once './messageLogic.php';
    $from_id = $_SESSION['unique_id'];
    $to_id = filter_input(INPUT_POST, 'to_id');
    $output = "";

    $messages = MessageLogic::getMessages($from_id, $to_id);
    if (count($messages) > 0) {
        foreach ($messages as $message) {
            if ($message['from_id'] === $from_id) {
                $output .= '<div class="chat from">
                            <div class="details">
                                <p>'.$message['msg'].'</p>
                            </div>
                            </div>';
            } else {
                $output .= '<div class="chat to">
                            <div class="details">
                                <p>'.$message['msg'].'</p>
                            </div>
                            </div>';
            }
        }
        echo $output;
    }
} else {
    header("../login.php");
}

?>