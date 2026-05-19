<?php

    require_once __DIR__ . '/../../config/conn.php';
    require_once __DIR__ . '/../models/Config.php';

    class ConfigController {
        public function listConfig() {
            global $conn;
            return Config::getAllConfig($conn);
        }

        public function saveConfig() {
            global $conn;

            header('Content-Type: application/json; charset=utf-8');

            $data = [
                'nome_refeitorio' => trim($_POST['nome_refeitorio'] ?? ''),
                'descricao_refeitorio' => trim($_POST['descricao_refeitorio'] ?? ''),
                'boas_vinda' => trim($_POST['boas_vinda'] ?? ''),
                'titulo_index' => trim($_POST['titulo_index'] ?? ''),
                'descricao_index' => trim($_POST['descricao_index'] ?? ''),
                'titulo_home' => trim($_POST['titulo_home'] ?? ''),
                'descricao_home' => trim($_POST['descricao_home'] ?? ''),
            ];

            if ($data['nome_refeitorio'] === '' || $data['titulo_index'] === '' || $data['titulo_home'] === '') {
                http_response_code(422);
                echo json_encode(['success' => false, 'message' => 'Preencha os campos obrigatórios da configuração.']);
                return;
            }

            echo json_encode(['success' => Config::updateFirst($conn, $data)]);
        }

    }
?>
