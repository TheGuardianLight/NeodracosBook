<?php
global $pdo;
/**
 * Copyright (c) 2024 - Veivneorul.
 * This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License (BY-NC-ND 4.0).
 */

// Handle form submission for adding a book
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_name'], $_POST['book_author_id'], $_POST['book_series_id'], $_POST['book_editor_id'], $_POST['book_date'], $_POST['book_nbe'], $_POST['book_price'])) {
    $bookName = $_POST['book_name'];
    $bookAuthorId = $_POST['book_author_id'];
    $bookSeriesId = $_POST['book_series_id'];
    $bookEditorId = $_POST['book_editor_id'];
    $bookDate = $_POST['book_date'];
    $bookNbe = $_POST['book_nbe'];
    $bookPrice = $_POST['book_price'];

    $stmt = $pdo->prepare("INSERT INTO books (book_name, book_author_id, book_series_id, book_editor_id, book_date, book_nbe, book_price) VALUES (:book_name, :book_author_id, :book_series_id, :book_editor_id, :book_date, :book_nbe, :book_price)");
    $stmt->execute([
        'book_name' => $bookName,
        'book_author_id' => $bookAuthorId,
        'book_series_id' => $bookSeriesId,
        'book_editor_id' => $bookEditorId,
        'book_date' => $bookDate,
        'book_nbe' => $bookNbe,
        'book_price' => $bookPrice
    ]);
}

// Handle form submission for deleting a book
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_book_id'])) {
    $bookId = $_POST['delete_book_id'];

    $stmt = $pdo->prepare("DELETE FROM books WHERE id = :id");
    $stmt->execute(['id' => $bookId]);
}

// Fetch all authors
$stmt = $pdo->query("SELECT id, author_name FROM author");
$authors = $stmt->fetchAll();

// Fetch all series
$stmt = $pdo->query("SELECT id, series_name FROM series");
$series = $stmt->fetchAll();

// Fetch all editors
$stmt = $pdo->query("SELECT id, editor_name FROM editor");
$editors = $stmt->fetchAll();

// Fetch all books
$stmt = $pdo->query("SELECT books.*, author.author_name, series.series_name, editor.editor_name FROM books JOIN author ON books.book_author_id = author.id JOIN series ON books.book_series_id = series.id JOIN editor ON books.book_editor_id = editor.id");
$books = $stmt->fetchAll();