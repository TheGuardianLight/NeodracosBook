<?php
/**
 * Copyright (c) 2024 - Veivneorul. This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License (BY-NC-ND 4.0).
 */

// Données reçues du formulaire
$dbname = $_POST['dbname'];
$dbuser = $_POST['dbuser'];
$dbpassword = $_POST['dbpassword'];
$dbhost = $_POST['dbhost'];
$dbport = $_POST['dbport'];

$sql = <<<SQL
CREATE TABLE `author`  (
   `id` int NOT NULL AUTO_INCREMENT,
   `author_name` varchar(255) NULL COMMENT 'Nom de l\'autheur',
   PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `books`  (
   `id` int NOT NULL AUTO_INCREMENT,
   `book_name` varchar(255) NULL COMMENT 'Titre du livre',
   `book_nbe` int NULL COMMENT 'Numéro du tome',
   `book_author_id` int NULL COMMENT 'ID Auteur du livre',
   `book_series_id` int NULL COMMENT 'ID Série du livre',
   `book_date` date NULL DEFAULT NULL COMMENT 'Date de parution du livre',
   `book_ISBN` varchar(255) NULL COMMENT 'ISBN du livre',
   `book_price` decimal(10, 2) NULL COMMENT 'Prix du livre',
   `book_editor_id` int NULL COMMENT 'ID Editeur du livre',
   PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `editor`  (
   `id` int NOT NULL AUTO_INCREMENT,
   `editor_name` varchar(255) NULL,
   `editor_website` varchar(255) NULL,
   PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `series`  (
   `id` int NOT NULL AUTO_INCREMENT,
   `series_name` varchar(255) NULL COMMENT 'Nom de la série',
   `series_author` varchar(255) NULL,
   PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `users`  (
   `username` varchar(50) NOT NULL COMMENT 'Nom d\'utilisateur',
   `email` varchar(255) NULL COMMENT 'Email',
   `password` varchar(255) NULL COMMENT 'Mot de passe chiffré en Argon2',
   PRIMARY KEY (`username`)
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `users_book`  (
   `id` int NOT NULL AUTO_INCREMENT,
   `id_book` int NULL COMMENT 'ID du livre',
   `id_user` varchar(255) NULL COMMENT 'Nom d\'utilisateur',
   PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `users_info`  (
   `id` int NOT NULL AUTO_INCREMENT COMMENT 'id',
   `username` varchar(50) NULL COMMENT 'Nom d\'utilisateur',
   `firstname` varchar(255) NULL COMMENT 'Prénom',
   `lastname` varchar(255) NULL COMMENT 'Nom de famille',
   PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

ALTER TABLE `books` ADD CONSTRAINT `book_fk_1` FOREIGN KEY (`book_author_id`) REFERENCES `author` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT;
ALTER TABLE `books` ADD CONSTRAINT `book_fk_2` FOREIGN KEY (`book_series_id`) REFERENCES `series` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT;
ALTER TABLE `books` ADD CONSTRAINT `book_fk_3` FOREIGN KEY (`book_editor_id`) REFERENCES `editor` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT;
ALTER TABLE `series` ADD CONSTRAINT `series_fk_1` FOREIGN KEY (`series_author`) REFERENCES `author` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT;
ALTER TABLE `users_book` ADD CONSTRAINT `users_book_fk_1` FOREIGN KEY (`id_book`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT;
ALTER TABLE `users_book` ADD CONSTRAINT `users_book_fk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE RESTRICT;
ALTER TABLE `users_info` ADD CONSTRAINT `user_info_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE RESTRICT;
SQL;

// Connexion à la base de données
$conn = new mysqli($dbhost, $dbuser, $dbpassword, '', $dbport);

if ($conn->connect_error) {
    echo json_encode(['error' => true, 'details' => 'Erreur de connexion à la base de données : ' . $conn->connect_error]);
    exit;
}

// Création de la base de données
$sqlCreateDatabase = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sqlCreateDatabase) === TRUE) {
    // Sélection de la base de données nouvellement créée
    $conn->select_db($dbname);

    // Exécution du script SQL pour créer les tables
    if ($conn->multi_query($sql) === TRUE) {
        do {
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->next_result());
        echo json_encode(['success' => 'Base de données et tables créées avec succès !']);
    } else {
        echo json_encode(['error' => true, 'details' => 'Erreur de création des tables : ' . $conn->error]);
    }
} else {
    echo json_encode(['error' => true, 'details' => 'Erreur de création de la base de données : ' . $conn->error]);
}

$conn->close();
?>
