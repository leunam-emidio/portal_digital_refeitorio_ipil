<?php

    require_once __DIR__ . '/../../config/conn.php';
    require_once __DIR__ . '/../models/Menu.php';

    class MenuController {
        public function listMenus() {
            global $conn;
            return Menu::getAllMenu($conn);
        }

    }
?>