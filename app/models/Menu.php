<?php

class Menu {
    public static function ensureSchema($conn) {
        $columns = self::getColumns($conn);

        if (!in_array('image', $columns, true)) {
            $conn->exec("ALTER TABLE menu ADD image varchar(255) NOT NULL DEFAULT '' AFTER status");
            $columns[] = 'image';
        }

        if (!in_array('weekdays', $columns, true)) {
            $conn->exec("ALTER TABLE menu ADD weekdays varchar(30) NULL AFTER image");
            $columns[] = 'weekdays';
        }

        if (!in_array('tip', $columns, true)) {
            $conn->exec("ALTER TABLE menu ADD tip varchar(120) NULL AFTER weekdays");
            $columns[] = 'tip';
        }

        if (in_array('url', $columns, true) && in_array('image', $columns, true)) {
            $conn->exec("UPDATE menu SET image = url WHERE image = '' AND url <> ''");
        }

        return $columns;
    }

    public static function getAllMenu($conn) {
        self::ensureSchema($conn);
        $stmt = $conn->prepare("SELECT * FROM menu ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($conn, $id) {
        self::ensureSchema($conn);
        $stmt = $conn->prepare("SELECT * FROM menu WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $menu = $stmt->fetch(PDO::FETCH_ASSOC);

        return $menu ?: null;
    }

    public static function nameExists($conn, $name, $ignoreId = null) {
        self::ensureSchema($conn);
        $sql = "SELECT COUNT(*) FROM menu WHERE LOWER(name) = LOWER(:name)";
        $params = [':name' => $name];

        if ($ignoreId) {
            $sql .= " AND id <> :id";
            $params[':id'] = $ignoreId;
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn() > 0;
    }

    public static function create($conn, $name, $category, $description, $image, $status, $weekdays, $tip) {
        $columns = self::ensureSchema($conn);
        $insertColumns = ['name', 'category', 'description', 'image', 'status', 'weekdays', 'tip'];
        $params = [
            ':name' => $name,
            ':category' => $category,
            ':description' => $description,
            ':image' => $image,
            ':status' => $status,
            ':weekdays' => $weekdays,
            ':tip' => $tip,
        ];

        if (in_array('likes', $columns, true)) {
            $insertColumns[] = 'likes';
            $params[':likes'] = 0;
        }

        $placeholders = array_map(fn($column) => ':' . $column, $insertColumns);
        $sql = sprintf(
            "INSERT INTO menu (%s) VALUES (%s)",
            implode(', ', $insertColumns),
            implode(', ', $placeholders)
        );

        $stmt = $conn->prepare($sql);
        return $stmt->execute($params);
    }

    public static function update($conn, $id, $name, $category, $description, $image, $status, $weekdays, $tip) {
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

        if ($image !== '') {
            $sql .= ", image = :image";
            $params[':image'] = $image;
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

    private static function getColumns($conn) {
        return $conn->query("SHOW COLUMNS FROM menu")->fetchAll(PDO::FETCH_COLUMN);
    }
}
?>
