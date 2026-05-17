<?php

    class Feedbacks {
        public static function create($conn, $userId, $menuId, $comment) {
            $stmt = $conn->prepare(
                "INSERT INTO feedbacks (id_user, id_menu, comentary, liked)
                 VALUES (?, ?, ?, 0)"
            );

            $stmt->bindValue(1, $userId, PDO::PARAM_INT);
            $stmt->bindValue(2, $menuId, PDO::PARAM_INT);
            $stmt->bindValue(3, $comment);
            $stmt->execute();

            return [
                'id' => (int) $conn->lastInsertId(),
                'id_user' => (int) $userId,
                'id_menu' => (int) $menuId,
                'comentary' => $comment,
                'liked' => 0,
                'create_at' => date('Y-m-d H:i:s')
            ];
        }
       
        public static function getAllFeedbacks($conn) {
            $stmt = $conn->prepare(
                "SELECT feedbacks.*, users.name AS author
                 FROM feedbacks
                 LEFT JOIN users ON users.id = feedbacks.id_user
                 ORDER BY feedbacks.create_at DESC"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }
?>
