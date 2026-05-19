<?php
    
class User {

    public static function findByEmail($conn, $email) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bindValue(1, $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($conn, $name, $email, $password) {
        $check = self::findByEmail($conn, $email);

        if ($check) {
            header("Location: views/register.php?error=Email já registrado");
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
        );

        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, $hash);

        $stmt->execute();

        return $conn->lastInsertId();
    }

    public static function getallusers($conn) {
        $stmt = $conn->prepare("SELECT id, name, email, role, status, create_at FROM users ORDER BY create_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateStatus($conn, $id, $status) {
        $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public static function delete($conn, $id) {
        $deleteFeedbacks = $conn->prepare("DELETE FROM feedbacks WHERE id_user = ?");
        $deleteFeedbacks->execute([$id]);

        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
