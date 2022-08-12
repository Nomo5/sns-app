<?php
require_once dirname(__FILE__) . './config.php';

class PostLogic {

    /**
     * 投稿を追加
     * 
     * @param int $user_id
     * @param string $content
     * 
     * @return bool
     */
    public static function addPost($user_id, $content) {
        $sql = 'INSERT INTO posts (user_id, content)
                VALUES (:user_id, :content)';
        $dbh = dbConnect();

        $dbh->beginTransaction();
        try {
            $stmt = $dbh->prepare($sql);

            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':content', $content, PDO::PARAM_STR);
            $stmt->execute();
            $dbh->commit();
            return true;
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    /**
     * 投稿を削除
     * 
     * @param int $post_id
     * 
     * @return bool
     */
    public static function deletePost($post_id) {
        //その投稿がいいねされているかどうかチェック
        //いいねされていれば、favoritesテーブルからも削除する必要がある。else文へ。
        $result = self::getLikedPostsByPostId($post_id);
        if (!$result) {
            $sql = 'DELETE FROM posts WHERE id = (:post_id)';
            $dbh = dbConnect();

            $dbh->beginTransaction();
            try {
                $stmt = $dbh->prepare($sql);

                $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
                $stmt->execute();
                $dbh->commit();

                return true;
            } catch (PDOException $e) {
                $dbh->rollBack();
                exit($e);
            }
        } else {
            $sql = 'DELETE posts, favorites FROM posts LEFT JOIN favorites ON posts.id = favorites.post_id
                    WHERE posts.id = (:post_id)';
            $dbh = dbConnect();

            $dbh->beginTransaction();
            try {
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
                $stmt->execute();
                $dbh->commit();

                return true;
            } catch (PDOException $e) {
                $dbh->rollBack();
                exit($e);
            }
        }
    }

    /**
     * すべての投稿を取得
     * 
     * @param void
     */
    public static function getPosts() {
        $sql = 'SELECT * FROM posts ORDER BY created_day desc';
        $dbh = dbConnect();

        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $posts;
    }

    /**
     * そのユーザの投稿を取得
     * 
     * @param int $user_id
     */
    public static function getPostsByUserId($user_id) {
        $sql = 'SELECT * FROM posts WHERE user_id = (:user_id) ORDER BY created_day desc';
        $dbh = dbConnect();

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }

    /**
     * 特定の投稿をpost_idをもとに取得
     * 
     * @param int $post_id
     */
    public static function getPostsByPostId($post_id) {
        $sql = 'SELECT * FROM posts WHERE id = (:post_id) ORDER BY created_day desc';
        $dbh = dbConnect();

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }

    /**
     * いいね処理
     * 
     * @param int $user_id
     * @param int $post_id
     * 
     * @return bool
     */
    public static function like($user_id, $post_id) {
        //既にいいねしていないかチェック
        $result = self::judgeLiked($user_id, $post_id);
        if (!$result) {
            $sql = 'INSERT INTO favorites (user_id, post_id)
                    VALUES (:user_id, :post_id)';

            $dbh = dbConnect();

            $dbh->beginTransaction();
            try {
                $stmt = $dbh->prepare($sql);

                $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
                $stmt->execute();
                $dbh->commit();

                return true;
            } catch (PDOException $e) {
                $dbh->rollBack();
                exit($e);
            }
        } else {
            return false;
        }
    }

    /**
     * いいね取り消し処理
     * 
     * @param int $user_id
     * @param int $post_id
     * 
     * @return bool
     */
    public static function dislike($user_id, $post_id) {
        $sql = 'DELETE FROM favorites WHERE user_id = (:user_id) AND post_id = (:post_id)';

        $dbh = dbConnect();

        $dbh->beginTransaction();
        try {
            $stmt = $dbh->prepare($sql);
            
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
            $stmt->execute();
            $dbh->commit();

            return true;
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    /**
     * いいねしているかチェック
     * 
     * @param int $user_id
     * @param int $post_id
     * 
     * @return bool
     */
    public static function judgeLiked($user_id, $post_id) {
        $sql = 'SELECT * FROM favorites WHERE user_id = (:user_id) AND post_id = (:post_id)';

        $dbh = dbConnect();

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * いいねされた回数を調べる
     * 
     * @param int $post_id
     */
    public static function countliked($post_id) {
        $sql = 'SELECT * FROM favorites WHERE post_id = (:post_id)';

        $dbh = dbConnect();

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * そのユーザーがいいねした投稿のID一覧を取得
     * 
     * @param int $user_id
     */
    public static function getLikedPostsByUserId($user_id) {
        $sql = 'SELECT post_id FROM favorites WHERE user_id = (:user_id) ORDER BY id desc';
        $dbh = dbConnect();

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * その投稿がいいねされているかチェック
     * 
     * @param int $post_id
     */
    public static function getLikedPostsByPostId($post_id) {
        $sql = 'SELECT * FROM favorites WHERE post_id = (:post_id)';
        $dbh = dbConnect();

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>