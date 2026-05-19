<?php
    require_once __DIR__ . '/../../config/conn.php';
require_once __DIR__ . '/../models/User.php';


class AuthController {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllusers() {

        global $conn;

        return User::getallusers($conn);
    }

    public function login() {
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        $user = User::findByEmail($this->conn, $email);

        if ($user && ($user['status'] ?? 'active') === 'blocked') {
            echo "Conta bloqueada. Contacte o administrador.";
            return;
        }

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            header("Location: index.php?action=dashboard");
        } else {
            echo "Login inválido";
        }
    }

    public function register() {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConfirm = $_POST['passwordConfirm'];

        if ($password !== $passwordConfirm) {
            echo "As palavras passes não coincidem.";
            return;
        }

        $userId = User::create($this->conn, $name, $email, $password);

        $_SESSION['user_id'] = $userId;
        $_SESSION['user_name'] = $name;
        $_SESSION['role'] = 'user';

        header("Location: app/views/home/home.php");
    }

    public function dashboard() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit;
        }

        if ($_SESSION['role'] === 'admin') {
            header("Location: app/views/admin/admin.php");   
        } else {
            #include __DIR__ . '/../views/dashboard.php';
            header("Location: app/views/home/home.php");
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
    }

    public function toggleUserStatus() {
        header('Content-Type: application/json; charset=utf-8');

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $status = $_POST['status'] ?? '';

        if (!$id || !in_array($status, ['active', 'blocked'], true)) {
            http_response_code(422);
            echo json_encode(['success' => false, 'message' => 'Dados de utilizador inválidos.']);
            return;
        }

        if ($id === (int) ($_SESSION['user_id'] ?? 0)) {
            http_response_code(422);
            echo json_encode(['success' => false, 'message' => 'Não pode bloquear a própria conta.']);
            return;
        }

        echo json_encode(['success' => User::updateStatus($this->conn, $id, $status)]);
    }

    public function deleteUser() {
        header('Content-Type: application/json; charset=utf-8');

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            http_response_code(422);
            echo json_encode(['success' => false, 'message' => 'Utilizador inválido.']);
            return;
        }

        if ($id === (int) ($_SESSION['user_id'] ?? 0)) {
            http_response_code(422);
            echo json_encode(['success' => false, 'message' => 'Não pode excluir a própria conta.']);
            return;
        }

        echo json_encode(['success' => User::delete($this->conn, $id)]);
    }
}
?>
