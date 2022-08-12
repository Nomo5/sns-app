<?php
//新規登録処理

session_start();
require_once './userLogic.php';

$username = filter_input(INPUT_POST, 'username');
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

if (!$username || !$email || !$password) {
    echo "必要項目が未入力です。";
} else {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = UserLogic::getUserByEmail($email);
        if (!$result) {
            //新規登録処理

            //プロフィール画像の処理
            if (isset($_FILES['image'])) {
                $img_name = $_FILES['image']['name'];
                $tmp_name = $_FILES['image']['tmp_name'];

                $img_explode = explode('.', $img_name);
                $img_ext = end($img_explode);

                $extensions = ['png', 'jpeg', 'jpg'];
                if (in_array($img_ext, $extensions) === true) {
                    $time = time();
                    $new_img_name = $time . $img_name;

                    if (move_uploaded_file($tmp_name, "images/".$new_img_name)) {
                        //DBに新規ユーザを登録
                        $random_id = rand(time(), 10000000);
                        $result2 = UserLogic::addUser($random_id, $username, $email, $password, $new_img_name);
                        if (!$result2) {
                            echo "エラーが発生しました。";
                        } else {
                            $user = UserLogic::getUserByEmail($email);
                            if (count($user) > 0) {
                                $_SESSION['unique_id'] = $user['unique_id'];
                                echo "success";
                            }
                        }
                    }
                } else {
                    echo "利用できるファイル - jpeg, jpg, png";
                }
            } else {
                echo "プロフィール画像を選択してください。";
            }
        } else {
            echo "$email はすでに使用されています。";
        }
    } else {
        echo "メールアドレス　$email は不正です。";
    }
}
?>
