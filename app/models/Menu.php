<?php

    class Menu {
        public static function getAllMenu($conn) {
            $stmt = $conn->prepare("SELECT * FROM menu");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function getAllFeedbacks($conn) {
            $stmt = $conn->prepare("SELECT * FROM menu");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }
?>