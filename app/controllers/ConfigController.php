<?php

    require_once __DIR__ . '/../../config/conn.php';
    require_once __DIR__ . '/../models/Config.php';

    class ConfigController {
        public function listConfig() {
            global $conn;
            return Config::getAllConfig($conn);
        }

    }
?>