<?php
require_once dirname(__FILE__) . './config.php';

class UserLogic {

    /**
     * ユーザーの新規登録処理
     * 
     * @param int $unique_id
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $img
     * 
     * @return bool
     */
    public static function addUser($unique_id, $username, $email, $password, $img) {

        $sql = 'INSERT INTO users (unique_id, username, email, password, img)
                VALUES (:unique_id, :username, :email, :password, :img)';
        
        $dbh = dbConnect();

        $dbh->beginTransaction();
        try {
            $stmt = $dbh->prepare($sql);

            $stmt->bindValue(':unique_id', $unique_id, PDO::PARAM_INT);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $stmt->bindValue(':img', $img, PDO::PARAM_STR);

            $stmt->execute();
            $dbh->commit();
            return true;
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    /**
     * ログイン処理
     * 
     * @param string $email
     * @param string $password
     * 
     * @return bool
     */
    public static function login($email, $password) {

        //emailが登録されているかチェック
        $user = self::getUserByEmail($email);
        if (!$user) {
            return false;
        } else {
            //パスワードチェック
            if (password_verify($password, $user['password'])) {
                return $user;
            } else {
                return false;
            }
        }
    }

    /**
     * 自分以外の全ユーザー取得
     * 
     * @param int $unique_id
     */
    public static function getUsers($unique_id) {
        $sql = 'SELECT * FROM users WHERE unique_id != (:unique_id)';
        $dbh = dbConnect();

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':unique_id', $unique_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * emailからユーザーを取得
     * 
     * @param string $email
     */
    public static function getUserByEmail($email) {

        $sql = 'SELECT * FROM users WHERE email = :email';
        $dbh = dbConnect();

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * unique_idからユーザを取得
     * 
     * @param int $unique_id
     */
    public static function getUserByUniqueId($unique_id) {
        $sql = 'SELECT * FROM users WHERE unique_id = :unique_id';
        $dbh = dbConnect();
    
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':unique_id', $unique_id, PDO::PARAM_INT);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}

?>