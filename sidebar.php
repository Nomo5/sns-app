<!-- サイドバー -->
<div class="sidebar">
    <div class="sidebarIcon">
        <img src="./php/images/<?php echo $user['img'] ?>">
        <p><?php echo $user['username'] ?></p>
    </div>

    <div class="sidebarOption">
        <ul>
            <li><a href="./home.php"><i class="fa-solid fa-house"></i>home</a></li>
            <li><a href="./profile.php"><i class="fa-solid fa-user"></i>profile</a></li>
            <li><a href="./message.php"><i class="fa-solid fa-message"></i>Message</a></li>
            <li><a href="./php/logout.php?logout_id=<?php echo $user['unique_id'] ?>"><i class="fa-solid fa-arrow-right-from-bracket"></i>logout</a></li>
        </ul>
    </div>

    <div class="sidebarButton">
        <button>投稿する</button>
    </div>
</div>