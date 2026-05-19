<?php

    require_once __DIR__ . '/../../config/conn.php';
    require_once __DIR__ . '/../models/Menu.php';

    class MenuController {
        private $conn;

        public function __construct($conn = null) {
            $this->conn = $conn;
        }

        public function listMenus() {
            global $conn;
            return Menu::getAllMenu($conn);
        }

        public function saveMenu() {
            $this->jsonHeader();

            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $name = trim($_POST['name'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $status = $_POST['status'] ?? 'active';
            $weekdays = trim($_POST['weekdays'] ?? '');
            $tip = trim($_POST['tip'] ?? '');

            if ($name === '' || $category === '' || $description === '' || !in_array($status, ['active', 'inactive'], true)) {
                http_response_code(422);
                echo json_encode(['success' => false, 'message' => 'Preencha os dados obrigatórios do prato.']);
                return;
            }

            $image = $this->uploadImage($_FILES['image'] ?? null);
            if ($image === false) {
                http_response_code(422);
                echo json_encode(['success' => false, 'message' => 'Envie uma imagem JPG, PNG, GIF ou WebP com até 3MB.']);
                return;
            }

            if ($id) {
                $saved = Menu::update($this->conn, $id, $name, $category, $description, $image, $status, $weekdays, $tip);
            } else {
                if ($image === '') {
                    http_response_code(422);
                    echo json_encode(['success' => false, 'message' => 'A imagem do prato é obrigatória.']);
                    return;
                }

                $saved = Menu::create($this->conn, $name, $category, $description, $image, $status, $weekdays, $tip);
            }

            echo json_encode(['success' => (bool) $saved]);
        }

        public function deleteMenu() {
            $this->jsonHeader();

            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            if (!$id) {
                http_response_code(422);
                echo json_encode(['success' => false, 'message' => 'Prato inválido.']);
                return;
            }

            echo json_encode(['success' => Menu::delete($this->conn, $id)]);
        }

        private function uploadImage($file) {
            if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
                return '';
            }

            if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK || ($file['size'] ?? 0) > 3 * 1024 * 1024) {
                return false;
            }

            $allowed = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/webp' => 'webp',
            ];

            $mimeType = mime_content_type($file['tmp_name']);
            if (!isset($allowed[$mimeType])) {
                return false;
            }

            $uploadDir = __DIR__ . '/../../imgs/uploads';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }

            $filename = uniqid('menu_', true) . '.' . $allowed[$mimeType];
            $destination = $uploadDir . '/' . $filename;

            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                return false;
            }

            return 'imgs/uploads/' . $filename;
        }

        private function jsonHeader() {
            header('Content-Type: application/json; charset=utf-8');
        }
    }

?>
