<?php
require 'db.php';
/** @var PDO $pdo */

header('Content-Type: application/json');

$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';

if ($category_id === '') {
    $stmt = $pdo->query('SELECT cars.*, categories.name as category_name 
                         FROM cars 
                         JOIN categories ON cars.category_id = categories.id');

    echo json_encode($stmt->fetchAll());
} else {
    $stmt = $pdo->prepare('SELECT cars.*, categories.name as category_name 
                           FROM cars 
                           JOIN categories ON cars.category_id = categories.id 
                           WHERE cars.category_id = ?');

    $stmt->execute([$category_id]);

    echo json_encode($stmt->fetchAll());
}
?>