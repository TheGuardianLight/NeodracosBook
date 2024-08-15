<?php
/**
 * Copyright (c) 2024 - Veivneorul. This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License (BY-NC-ND 4.0).
 */

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Dotenv\Exception\PathException;

// Données reçues du formulaire
$dbname = $_POST['dbname'];
$dbuser = $_POST['dbuser'];
$dbpassword = $_POST['dbpassword'];
$dbhost = $_POST['dbhost'];
$dbport = $_POST['dbport'];

$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s', $dbhost, $dbport, $dbname);

try {
    $connection = new PDO($dsn, $dbuser, $dbpassword);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "
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
          `series_author` int NULL,
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
    ";

    $connection->exec($sql);

    $envPath = __DIR__ . '/../.env';
    $env = [];

    if (file_exists($envPath)) {
        try {
            $dotenv = new Dotenv();
            $env = $dotenv->parse(file_get_contents($envPath), $envPath);
        } catch (PathException $exception) {
            throw new Exception('Erreur de chemin du fichier .env: ' . $exception->getMessage());
        }
    }

    $env['DB_HOST'] = $host;
    $env['DB_PORT'] = $port;
    $env['DB_NAME'] = $dbname;
    $env['DB_USER'] = $dbuser;
    $env['DB_PASSWORD'] = $dbpassword;
    $env['ALLOW_SIGNUP'] = "true";

    $envData = '';
    foreach ($env as $key => $value) {
        $envData .= sprintf("%s=\"%s\"\n", $key, $value);
    }

    file_put_contents($envPath, $envData);

    touch('../install.lock');

    echo json_encode(['success' => 'La base de données a été configurée avec succès.']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de base de données', 'details' => 'Erreur de base de données: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur d\'installation', 'details' => $e->getMessage()]);
}