<?php

    require_once __DIR__ . '/../../config/conn.php';
    require_once __DIR__ . '/../models/Feedback.php';

    class FeedbackController {
        public function listFeedbacks() {
            global $conn;
            return Feedbacks::getAllFeedbacks($conn);
        }

        public function createFeedback() {
            global $conn;

            header('Content-Type: application/json; charset=utf-8');

            if (!isset($_SESSION['user_id'])) {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Sessao expirada. Faca login novamente.']);
                exit;
            }

            $menuId = filter_input(INPUT_POST, 'id_menu', FILTER_VALIDATE_INT);
            $comment = trim($_POST['comentary'] ?? '');

            if (!$menuId || $comment === '') {
                http_response_code(422);
                echo json_encode(['success' => false, 'message' => 'Preencha o feedback antes de enviar.']);
                exit;
            }

            $feedback = Feedbacks::create($conn, (int) $_SESSION['user_id'], $menuId, $comment);
            $feedback['author'] = $_SESSION['user_name'] ?? 'Voce';

            echo json_encode(['success' => true, 'feedback' => $feedback], JSON_UNESCAPED_UNICODE);
            exit;
        }

        public function deleteFeedback() {
            global $conn;

            header('Content-Type: application/json; charset=utf-8');

            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            if (!$id) {
                http_response_code(422);
                echo json_encode(['success' => false, 'message' => 'Feedback inválido.']);
                return;
            }

            echo json_encode(['success' => Feedbacks::delete($conn, $id)]);
        }

    }
?>
