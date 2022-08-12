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
    <link rel="stylesheet" href="./css/profile.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body>
    <div class="wrapper">
        <?php $user = UserLogic::getUserByUniqueId($_SESSION['unique_id']) ?>
        <!-- sidebar -->
        <?php include_once './sidebar.php' ?>

        <!-- profile -->
        <div class="mypage">
            <div class="mypage_header">
                <h2>profile</h2>
            </div>

            <div class="user_info">
                <img src="./php/images/<?php echo $user['img'] ?>">
                <h4><?php echo $user['username'] ?></h4>
            </div>
        
            <!-- モータルウィンドウ -->
            <div class="deleteBox">
                <h3>本当に削除しますか？</h3>
                <div class="buttons">
                    <button class="delete">削除</button>
                    <button class="cancel">キャンセル</button>
                </div>
            </div>

            <section class="tab_contents">
                <div class="tab_wrapper">
                    <input type="radio" id="tab1" name="check" checked>
                    <label for="tab1" class="tab_lab1">Posts</label>
                    <input type="radio" id="tab2" name="check">
                    <label for="tab2" class="tab_lab2">Favorites</label>

                    <div class="panels">
                        <!-- 自分の投稿一覧 -->
                        <div id="area1" class="panel">
                            <div class="post_area">
                                <?php $posts = PostLogic::getPostsByUserId($_SESSION['unique_id']) ?>
                                <?php foreach ($posts as $post) : ?>
                                    <div class="post" id="<?php echo $post['id'] ?>">
                                        <div class="post_avator">
                                            <?php $post_user = UserLogic::getUserByUniqueId($post['user_id']) ?>
                                            <img src="./php/images/<?php echo $post_user['img'] ?>">
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
                                                <div class="trash">
                                                    <i class="fa-solid fa-trash-can" onclick="deletePost(<?php echo $post['id'] ?>)"></i>
                                                </div>

                                                <div class="heart">
                                                    <?php $result = PostLogic::judgeLiked($_SESSION['unique_id'], $post['id']) ?>
                                                    <?php if (!$result): ?>
                                                        <i class="fa-solid fa-heart" onclick="favorite(<?php echo $post['id']?>)"></i>
                                                    <?php else: ?>
                                                        <i class="fa-solid fa-heart" onclick="favorite(<?php echo $post['id']?>)" style="color:red"></i>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="heart_count">
                                                    <?php $count = count(PostLogic::countliked($post['id'])) ?>
                                                    <?php if (!$count) $count = 0 ?>
                                                    <p><?php echo $count ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- いいねした投稿一覧 -->
                        <div id="area2" class="panel">
                            <div class="post_area">
                                <?php $likedPosts = PostLogic::getLikedPostsByUserId($_SESSION['unique_id']) ?>
                                <?php foreach ($likedPosts as $likedPost) : ?>
                                        <?php $post = PostLogic::getPostsByPostId($likedPost['post_id']) ?>

                                        <div class="post" id="<?php echo $post['id'] ?>">
                                            <div class="post_avator">
                                                <?php $post_user = UserLogic::getUserByUniqueId($post['user_id']) ?>
                                                <img src="./php/images/<?php echo $post_user['img'] ?>">
                                            </div>

                                            <div class="post_body">
                                                <div class="post_header">
                                                    <div class="post_headerText">
                                                        <h3><?php echo $post_user['username']; ?></h3>
                                                    </div>

                                                    <div class="post_headerDescription">
                                                        <p><?php echo $post['content']; ?></p>
                                                    </div>
                                                </div>

                                                <div class="post_footer">
                                                    <div class="heart">
                                                        <i class="fa-solid fa-heart" onclick="favorite(<?php echo $post['id'] ?>)" style="color:red"></i>
                                                    </div>

                                                    <div class="heart_count">
                                                        <?php $count = count(PostLogic::countliked($post['id'])) ?>
                                                        <?php if (!$count) $count = 0; ?>
                                                        <p><?php echo $count; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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
    <script src="./js/favorite.js"></script>
    <script src="./js/delete-post.js"></script>
</body>

</html>