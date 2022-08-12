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
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <?php $user = UserLogic::getUserByUniqueId($_SESSION['unique_id'])?>
        <!-- sidebar -->
        <?php include_once './sidebar.php'?>

        <!-- timeline -->
        <div class="timeline">
            <div class="timeline_header">
                <h2>Home</h2>
            </div>

            <div class="postBox">
                <form action="" method="post">
                    <div class="postBox_input">
                        <img src="./php/images/<?php echo $user['img'] ?>">
                        <input type="text" name="content" placeholder="いまどうしてる？">
                        <input type="hidden" name="user_id" value="<?php echo $user['unique_id']?>">
                    </div>
                    <input type="submit" value="投稿する" class="postBox_postButton">
                </form>
            </div>

            <div class="post_area">
                <?php $posts = PostLogic::getPosts() ?>
                <?php foreach($posts as $post): ?>
                    <div class="post" id="<?php echo $post['id'] ?>">
                        <div class="post_avator">
                            <?php $post_user = UserLogic::getUserByUniqueId($post['user_id']) ?>
                            <img src="./php/images/<?php echo $post_user['img']?>">
                        </div>

                        <div class="post_body">
                            <div class="post_header">
                                <div class="post_headerText">
                                    <h3><?php echo $post_user['username'] ?></h3>
                                </div>

                                <div class="post_headerDescription">
                                    <p><?php echo $post['content'] ?></p>
                                </div>
                            </div>

                            <div class="post_footer">
                                <div class="heart">
                                    <?php $result = PostLogic::judgeLiked($_SESSION['unique_id'], $post['id']) ?>
                                    <?php if (!$result): ?>
                                        <i class="fa-solid fa-heart" onclick="favorite(<?php echo $post['id']?>)"></i>
                                    <?php else: ?>
                                        <i class="fa-solid fa-heart" onclick="favorite(<?php echo $post['id']?>)" style="color:red"></i>
                                    <?php endif; ?>
        
                                    <div class="heart_count">
                                        <?php $count = count(PostLogic::countliked($post['id'])) ?>
                                        <?php if (!$count) $count = 0; ?>
                                        <p><?php echo $count; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- モータルウィンドウ -->
        <div class="model"></div>
        <div class="post_cardBox">
            <div class="header">
                <p id="close">x</p>
            </div>

            <div class="hiddenPostBox">
                <form action="" method="post">
                    <div class="postBox_input">
                        <img src="./php/images/<?php echo $user['img'] ?>">
                        <input type="text" name="content" placeholder="いまどうしてる？">
                        <input type="hidden" name="user_id" value="<?php echo $user['unique_id']?>">
                    </div>
                    <input type="submit" value="投稿する" class="postBox_postButton">
                </form>
            </div>
        </div>
    </div>

    <script src="./js/postBox-hide.js"></script>
    <script src="./js/add-post.js"></script>
    <script src="./js/favorite.js"></script>
</body>
</html>