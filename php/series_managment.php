<?php global $pdo;
/**
 * Copyright (c) 2024 - Veivneorul. This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License (BY-NC-ND 4.0).
 */

// Handle form submission for adding a series

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['series_name'], $_POST['series_author'])) {
    $seriesName = $_POST['series_name'] ?? '';
    $seriesAuthor = $_POST['series_author'] ?? '';

    if ($seriesName !== '' && $seriesAuthor !== '') {
        $stmt = $pdo->prepare("INSERT INTO series (series_name, series_author) VALUES (:series_name, :series_author)");
        $stmt->execute(['series_name' => $seriesName, 'series_author' => $seriesAuthor]);
    }
}

// Handle form submission for deleting a series
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_series_id'])) {
    $seriesId = $_POST['delete_series_id'] ?? '';

    if ($seriesId !== '') {
        $stmt = $pdo->prepare("DELETE FROM series WHERE id = :id");
        $stmt->execute(['id' => $seriesId]);
    }
}