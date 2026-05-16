<?php

    class Feedbacks {
       
        public static function getAllFeedbacks($conn) {
            $stmt = $conn->prepare("SELECT * FROM feedbacks");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }
?>