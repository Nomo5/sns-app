<?php
require_once dirname(__FILE__) . './config.php';

class MessageLogic {

    static public function getMessages($from_id, $to_id) {

        $sql = 'SELECT * FROM messages WHERE (from_id = :from_id AND to_id = :to_id)
                            OR (from_id = :to_id AND to_id = :from_id) ORDER BY msg_id';

        $dbh = dbConnect();
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':from_id', $from_id, PDO::PARAM_INT);
        $stmt->bindValue(':to_id', $to_id, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static public function addMessage($from_id, $to_id, $message) {

        $sql = 'INSERT INTO messages (from_id, to_id, msg)
                    VALUES (:from_id, :to_id, :msg)';

        $dbh = dbConnect();

        $dbh->beginTransaction();
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':from_id', $from_id, PDO::PARAM_INT);
            $stmt->bindValue(':to_id', $to_id, PDO::PARAM_INT);
            $stmt->bindValue(':msg', $message, PDO::PARAM_STR);

            $stmt->execute();
            $dbh->commit();
            return true;
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }
}

?>