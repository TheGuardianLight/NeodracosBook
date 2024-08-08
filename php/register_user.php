<?php
// register_user.php

// This script should be secure and prevent any kind of SQL injections
// You should properly handle exceptions and errors

// Use this library to work with .env file
global $pdo;
require __DIR__ . '/../vendor/autoload.php';
// Use the database connection script
require 'db_connect.php';

// Get POST data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Clean/prepare data to prevent XSS attack
    $firstname = htmlspecialchars($_POST["firstname"]);
    $lastname = htmlspecialchars($_POST["lastname"]);
    $username = htmlspecialchars($_POST["username"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $confirmpassword = htmlspecialchars($_POST["confirm-password"]);

    // Check if passwords match
    if ($password === $confirmpassword) {
        // Hash the password using Argon2
        $password = password_hash($password, PASSWORD_ARGON2I);

        try {
            // Prepare our SQL query to prevent SQL injection
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password)
                                   VALUES (:username, :email, :password)");

            // Execution of the SQL query
            $stmt->execute([
                ":username" => $username,
                ":email" => $email,
                ":password" => $password
            ]);

            $stmt = $pdo->prepare("INSERT INTO users_info (username, firstname, lastname)
                                   VALUES (:username, :firstname, :lastname)");

            // Execution of the SQL query
            $stmt->execute([
                ":username" => $username,
                ":firstname" => $firstname,
                ":lastname" => $lastname
            ]);

            echo json_encode(["message" => "User was successfully registered."]);

        } catch (PDOException $e) {
            echo json_encode(["message" => "Failed to register user: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["message" => "Passwords do not match."]);
    }
} else {
    echo json_encode(["message" => "This method only accept POST data."]);
}