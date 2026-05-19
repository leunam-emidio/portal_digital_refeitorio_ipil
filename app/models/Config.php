<?php

    class Config {
        private static function ensureSchema($conn) {
            $conn->exec(
                "CREATE TABLE IF NOT EXISTS configuration (
                    id int(11) NOT NULL AUTO_INCREMENT,
                    nome_refeitorio varchar(100) NOT NULL DEFAULT 'Refeitório IPIL',
                    descricao_refeitorio varchar(255) NOT NULL DEFAULT '',
                    boas_vinda varchar(120) NOT NULL DEFAULT 'Bem-vindo',
                    titulo_index varchar(150) NOT NULL DEFAULT 'Portal Digital do Refeitório IPIL',
                    descricao_index text NULL,
                    titulo_home varchar(150) NOT NULL DEFAULT 'Explore o cardápio e compartilhe suas experiências.',
                    descricao_home text NULL,
                    PRIMARY KEY (id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
            );

            $columns = $conn->query("SHOW COLUMNS FROM configuration")->fetchAll(PDO::FETCH_COLUMN);
            $definitions = [
                'nome_refeitorio' => "ALTER TABLE configuration ADD nome_refeitorio varchar(100) NOT NULL DEFAULT 'Refeitório IPIL'",
                'descricao_refeitorio' => "ALTER TABLE configuration ADD descricao_refeitorio varchar(255) NOT NULL DEFAULT ''",
                'boas_vinda' => "ALTER TABLE configuration ADD boas_vinda varchar(120) NOT NULL DEFAULT 'Bem-vindo'",
                'titulo_index' => "ALTER TABLE configuration ADD titulo_index varchar(150) NOT NULL DEFAULT 'Portal Digital do Refeitório IPIL'",
                'descricao_index' => "ALTER TABLE configuration ADD descricao_index text NULL",
                'titulo_home' => "ALTER TABLE configuration ADD titulo_home varchar(150) NOT NULL DEFAULT 'Explore o cardápio e compartilhe suas experiências.'",
                'descricao_home' => "ALTER TABLE configuration ADD descricao_home text NULL",
            ];

            foreach ($definitions as $column => $sql) {
                if (!in_array($column, $columns, true)) {
                    $conn->exec($sql);
                }
            }

            $count = (int) $conn->query("SELECT COUNT(*) FROM configuration")->fetchColumn();
            if ($count === 0) {
                $conn->exec(
                    "INSERT INTO configuration
                    (nome_refeitorio, descricao_refeitorio, boas_vinda, titulo_index, descricao_index, titulo_home, descricao_home)
                    VALUES
                    ('Refeitório IPIL', 'Um ambiente acolhedor e nutritivo para estudantes.', 'Bem-vindo',
                     'Portal Digital do Refeitório IPIL',
                     'Consulte o cardápio do refeitório e planeie as suas refeições.',
                     'Explore o cardápio e compartilhe suas experiências.',
                     'Como usuário logado, você pode deixar feedbacks e acompanhar o cardápio.')"
                );
            }
        }

        public static function getAllConfig($conn) {
            self::ensureSchema($conn);
            $stmt = $conn->prepare("SELECT * FROM configuration");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function updateFirst($conn, $data) {
            self::ensureSchema($conn);

            $id = (int) $conn->query("SELECT id FROM configuration ORDER BY id ASC LIMIT 1")->fetchColumn();

            $stmt = $conn->prepare(
                "UPDATE configuration
                 SET nome_refeitorio = :nome_refeitorio,
                     descricao_refeitorio = :descricao_refeitorio,
                     boas_vinda = :boas_vinda,
                     titulo_index = :titulo_index,
                     descricao_index = :descricao_index,
                     titulo_home = :titulo_home,
                     descricao_home = :descricao_home
                 WHERE id = :id"
            );

            return $stmt->execute([
                ':id' => $id,
                ':nome_refeitorio' => $data['nome_refeitorio'],
                ':descricao_refeitorio' => $data['descricao_refeitorio'],
                ':boas_vinda' => $data['boas_vinda'],
                ':titulo_index' => $data['titulo_index'],
                ':descricao_index' => $data['descricao_index'],
                ':titulo_home' => $data['titulo_home'],
                ':descricao_home' => $data['descricao_home'],
            ]);
        }

    }
?>
