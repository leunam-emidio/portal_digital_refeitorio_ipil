<?php

class Menu {
    public static function ensureSchema($conn) {
        $columns = $conn->query("SHOW COLUMNS FROM menu")->fetchAll(PDO::FETCH_COLUMN);

        if (!in_array('image', $columns, true)) {
            $conn->exec("ALTER TABLE menu ADD url varchar(255) NOT NULL DEFAULT '' AFTER status");
        }

        if (!in_array('weekdays', $columns, true)) {
            $conn->exec("ALTER TABLE menu ADD weekdays varchar(30) NULL AFTER url");
        }

        if (!in_array('tip', $columns, true)) {
            $conn->exec("ALTER TABLE menu ADD tip varchar(120) NULL AFTER weekdays");
        }
    }

    public static function getAllMenu($conn) {
        self::ensureSchema($conn);
        $stmt = $conn->prepare("SELECT * FROM menu ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($conn, $name, $category, $description, $image, $status, $weekdays, $tip) {
        self::ensureSchema($conn);
        $stmt = $conn->prepare(
            "INSERT INTO menu (name, category, description, url, status, weekdays, tip)
             VALUES (:name, :category, :description, :url, :status, :weekdays, :tip)"
        );

        return $stmt->execute([
            ':name' => $name,
            ':category' => $category,
            ':description' => $description,
            ':image' => $image,
            ':status' => $status,
            ':weekdays' => $weekdays,
            ':tip' => $tip,
        ]);
    }

    public static function update($conn, $id, $name, $category, $description, $url, $status, $weekdays, $tip) {
        self::ensureSchema($conn);
        $sql = "UPDATE menu
                SET name = :name, category = :category, description = :description,
                    status = :status, weekdays = :weekdays, tip = :tip";
        $params = [
            ':id' => $id,
            ':name' => $name,
            ':category' => $category,
            ':description' => $description,
            ':status' => $status,
            ':weekdays' => $weekdays,
            ':tip' => $tip,
        ];

        if ($url !== '') {
            $sql .= ", url = :url";
            $params[':url'] = $url;
        }

        $sql .= " WHERE id = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute($params);
    }

    public static function delete($conn, $id) {
        $deleteFeedbacks = $conn->prepare("DELETE FROM feedbacks WHERE id_menu = ?");
        $deleteFeedbacks->execute([$id]);

        $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
