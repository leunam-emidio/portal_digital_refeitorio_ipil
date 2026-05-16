<?php

    class Config {
        public static function getAllConfig($conn) {
            $stmt = $conn->prepare("SELECT * FROM configuration");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        

    }
?>