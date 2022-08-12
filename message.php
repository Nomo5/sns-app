<?php
session_start();
if (!isset($_SESSION['unique_id'])) {
    header("location: ./login.php");
}

require_once './php/userLogic.php';
require_once './php/postLogic.php';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sns-app</title>
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="./css/message.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <?php $user = UserLogic::getUserByUniqueId($_SESSION['unique_id'])?>
        <!-- sidebar -->
        <?php include_once './sidebar.php'?>

        <!-- チャット -->
        <div class="message">
            <div class="user_list">
                <?php $users = UserLogic::getUsers($_SESSION['unique_id']) ?>
                <?php foreach ($users as $user):?>
                    <button class="user" id="<?php echo $user['unique_id'] ?>" onclick="getUserInfo(<?php echo $user['unique_id']?>)">
                        <div class="content">
                            <img src="./php/images/<?php echo $user['img'] ?>">
                            <span><?php echo $user['username'] ?></span>
                        </div>
                    </button>
                <?php endforeach; ?>
            </div>

            <section class="chat_area">
                <header></header>
                <div class="chat_box"></div>

                <form action="" class="typing-area" autocomplete="off">
                    <input type="hidden" class="to_id" name="to_id" value="">
                    <input type="text" class="input_field" name="message" placeholder="type a message...">
                    <button><i class="fa-solid fa-paper-plane"></i></button>
                </form>
            </section>
        </div>
    </div>

    <script src="./js/message.js"></script>
</body>
</html>