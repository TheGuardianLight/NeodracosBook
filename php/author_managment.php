<?php global $pdo;
/**
 * Copyright (c) 2024 - Veivneorul. This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License (BY-NC-ND 4.0).
 */


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authorName = $_POST['author_name'] ?? '';

    if ($authorName !== '') {
        $stmt = $pdo->prepare("INSERT INTO author (author_name) VALUES (:author_name)");
        $stmt->execute(['author_name' => $authorName]);
    }
}

// Handle form submission for deleting an author
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_author_id'])) {
    $authorId = $_POST['delete_author_id'] ?? '';

    if ($authorId !== '') {
        $stmt = $pdo->prepare("DELETE FROM author WHERE id = :id");
        $stmt->execute(['id' => $authorId]);
    }
}