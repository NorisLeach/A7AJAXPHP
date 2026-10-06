<?php
require 'db.php';
/** @var PDO $pdo */

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $stmt = $pdo->prepare('DELETE FROM cars WHERE id = ?');
    $stmt->execute([$id]);
}

header('Location: index.php');
exit;
?>