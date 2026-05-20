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

            $existingMenu = $id ? Menu::findById($this->conn, $id) : null;

            if ($id && !$existingMenu) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Prato nao encontrado.']);
                return;
            }

            if (Menu::nameExists($this->conn, $name, $id ?: null)) {
                http_response_code(409);
                echo json_encode(['success' => false, 'message' => 'Ja existe um prato com este nome.']);
                return;
            }

            $image = $this->uploadImage($_FILES['image'] ?? null, $name);
            $uploadedImage = $image !== '';
            if ($image === false) {
                http_response_code(422);
                echo json_encode(['success' => false, 'message' => 'Envie uma imagem JPG, PNG, GIF ou WebP com até 4MB.']);
                return;
            }

            if ($id) {
                if ($image === '') {
                    $image = $this->renameStoredImage($existingMenu['image'] ?? '', $name);
                }

                $saved = Menu::update($this->conn, $id, $name, $category, $description, $image, $status, $weekdays, $tip);
            } else {
                if ($image === '') {
                    http_response_code(422);
                    echo json_encode(['success' => false, 'message' => 'A imagem do prato é obrigatória.']);
                    return;
                }

                $saved = Menu::create($this->conn, $name, $category, $description, $image, $status, $weekdays, $tip);
            }

            if (!$saved && $uploadedImage) {
                $this->deleteStoredImage($image);
            }

            if ($saved && $uploadedImage && $id && ($existingMenu['image'] ?? '') !== $image) {
                $this->deleteStoredImage($existingMenu['image'] ?? '');
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

        private function uploadImage($file, $dishName) {
            if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
                return '';
            }

            if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK || ($file['size'] ?? 0) > 4 * 1024 * 1024) {
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

            $filename = $this->slugify($dishName) . '.' . $allowed[$mimeType];
            $destination = $uploadDir . '/' . $filename;

            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                return false;
            }

            return 'imgs/uploads/' . $filename;
        }

        private function renameStoredImage($image, $dishName) {
            if (!$image || str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
                return '';
            }

            $source = realpath(__DIR__ . '/../../' . $image);
            $uploadDir = realpath(__DIR__ . '/../../imgs/uploads');
            if (!$source || !$uploadDir || !str_starts_with($source, $uploadDir)) {
                return '';
            }

            $extension = pathinfo($source, PATHINFO_EXTENSION);
            if ($extension === '') {
                return '';
            }

            $filename = $this->slugify($dishName) . '.' . strtolower($extension);
            $destination = $uploadDir . DIRECTORY_SEPARATOR . $filename;

            if ($source === $destination) {
                return $image;
            }

            if (!rename($source, $destination)) {
                return '';
            }

            return 'imgs/uploads/' . $filename;
        }

        private function deleteStoredImage($image) {
            if (!$image || str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
                return;
            }

            $path = realpath(__DIR__ . '/../../' . $image);
            $uploadDir = realpath(__DIR__ . '/../../imgs/uploads');
            if ($path && $uploadDir && str_starts_with($path, $uploadDir) && is_file($path)) {
                unlink($path);
            }
        }

        private function slugify($value) {
            $slug = trim($value);

            if (function_exists('iconv')) {
                $converted = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $slug);
                if ($converted !== false) {
                    $slug = $converted;
                }
            }

            $slug = strtolower($slug);
            $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
            $slug = trim($slug, '-');

            return $slug !== '' ? $slug : 'prato';
        }

        private function jsonHeader() {
            header('Content-Type: application/json; charset=utf-8');
        }
    }

?>
