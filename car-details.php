<?php
require 'db.php';
/** @var PDO $pdo */

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $pdo->prepare('SELECT cars.*, categories.name as category_name 
                       FROM cars 
                       JOIN categories ON cars.category_id = categories.id 
                       WHERE cars.id = ?');
$stmt->execute([$id]);
$car = $stmt->fetch();

if (!$car) {
    die("Eroare: Mașina solicitată nu există!");
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Detalii - <?php echo htmlspecialchars($car['model']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <a href="index.php">⬅ Înapoi la listă</a>
</nav>

<h2>Specificații: <?php echo htmlspecialchars($car['model']); ?></h2>

<div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); max-width: 600px;">
    <p><strong>Categorie:</strong> <?php echo htmlspecialchars($car['category_name']); ?></p>
    <p><strong>Putere Motor:</strong> <?php echo $car['engine_power']; ?> CP</p>
    <p><strong>Combustibil:</strong> <?php echo htmlspecialchars($car['fuel']); ?></p>
    <p><strong>Preț curent:</strong> <?php echo number_format($car['price'], 2); ?> €</p>
    <p><strong>Culoare:</strong> <?php echo htmlspecialchars($car['color']); ?></p>
    <p><strong>Vârstă vehicul:</strong> <?php echo $car['age']; ?> ani</p>
    <hr style="border: 0; border-top: 1px solid #ddd; margin: 20px 0;">
    <h3>Istoric și Descriere completă:</h3>
    <p style="line-height: 1.6; background: #fafafa; padding: 15px; border-left: 4px solid #28a745;">
        <?php echo nl2br(htmlspecialchars($car['history'])); ?>
    </p>
</div>

</body>
</html>