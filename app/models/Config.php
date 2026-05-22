<?php

    class Config {

        public static function getAllConfig($conn) {
            $stmt = $conn->prepare("SELECT * FROM configuration");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function updateFirst($conn, $data) {
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
