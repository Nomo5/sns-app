<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sns-app</title>
    <link rel="stylesheet" href="./css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <section class="form signup">
            <header>新規登録</header>
            <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
                <div class="error-txt"></div>
                <div class="name-details">
                    <div class="field input">
                        <label>ユーザーネーム</label>
                        <input type="text" name="username" required>
                    </div>
                    <div class="field input">
                        <label>メールアドレス</label>
                        <input type="text" name="email" required>
                    </div>
                    <div class="field input">
                        <label>パスワード</label>
                        <input type="password" name="password" required>
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="field input">
                        <label>プロフィール画像</label>
                        <input type="file" name="image" required>
                    </div>
                    <div class="field button">
                        <input type="submit" value="新規登録">
                    </div>
                </div>
            </form>

            <div class="link">すでにアカウントをお持ちですか？ <a href="./login.php">ログインへ</a></div>
        </section>
    </div>

    <script src="./js/pass-hide.js"></script>
    <script src="./js/signup.js"></script>
</body>
</html>