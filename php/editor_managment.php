<?php global $pdo;
/**
 * Copyright (c) 2024 - Veivneorul. This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License (BY-NC-ND 4.0).
 */


// Handle form submission for adding an editor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editor_name'], $_POST['editor_website'])) {
    $editorName = $_POST['editor_name'] ?? '';
    $editorWebsite = $_POST['editor_website'] ?? '';

    if ($editorName !== '' && filter_var($editorWebsite, FILTER_VALIDATE_URL)) {
        $stmt = $pdo->prepare("INSERT INTO editor (editor_name, editor_website) VALUES (:name, :website)");
        $stmt->execute(['name' => $editorName, 'website' => $editorWebsite]);
    }
}

// Handle form submission for deleting an editor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_editor_id'])) {
    $editorId = $_POST['delete_editor_id'] ?? '';

    if ($editorId !== '') {
        $stmt = $pdo->prepare("DELETE FROM editor WHERE id = :id");
        $stmt->execute(['id' => $editorId]);
    }
}