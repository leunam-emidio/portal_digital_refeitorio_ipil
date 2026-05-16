<?php

    require_once __DIR__ . '/../../config/conn.php';
    require_once __DIR__ . '/../models/Feedback.php';

    class FeedbackController {
        public function listFeedbacks() {
            global $conn;
            return Feedbacks::getAllFeedbacks($conn);
        }

    }
?>