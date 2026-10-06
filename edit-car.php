<?php
require 'db.php';
/** @var PDO $pdo */

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $pdo->prepare('SELECT * FROM cars WHERE id = ?');
$stmt->execute([$id]);
$car = $stmt->fetch();

if (!$car) {
    die("Eroare: Mașina cu acest ID nu a fost găsită!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model = trim($_POST['model']);
    $category_id = $_POST['category_id'];
    $engine_power = intval($_POST['engine_power']);
    $fuel = $_POST['fuel'];
    $price = floatval($_POST['price']);
    $color = trim($_POST['color']);
    $age = intval($_POST['age']);
    $history = trim($_POST['history']);

    if (!empty($model) && !empty($color) && $price > 0) {
        $updateStmt = $pdo->prepare('UPDATE cars SET category_id = ?, model = ?, engine_power = ?, fuel = ?, price = ?, color = ?, age = ?, history = ? WHERE id = ?');
        $updateStmt->execute([$category_id, $model, $engine_power, $fuel, $price, $color, $age, $history, $id]);

        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Editează Mașină</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <a href="index.php">Home</a>
    <a href="add-car.php">Adaugă Mașină</a>
    <a href="manage-categories.php">Gestionare Categorii</a>
</nav>

<h2>Editează Mașina: <?php echo htmlspecialchars($car['model']); ?></h2>

<form method="POST" onsubmit="return confirm('Sigur vrei să salvezi modificările?')">

    <div class="form-group">
        <label>Model:</label>
        <input type="text" name="model" value="<?php echo htmlspecialchars($car['model']); ?>" required>
    </div>

    <div class="form-group">
        <label>Categorie:</label>
        <select name="category_id" required>
            <?php
            $catStmt = $pdo->query("SELECT * FROM categories");
            while ($row = $catStmt->fetch()) {
                $selected = ($row['id'] == $car['category_id']) ? 'selected' : '';
                echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label>Putere Motor (CP):</label>
        <input type="number" name="engine_power" value="<?php echo $car['engine_power']; ?>" required>
    </div>

    <div class="form-group">
        <label>Combustibil:</label>
        <input type="text" name="fuel" value="<?php echo htmlspecialchars($car['fuel']); ?>" required>
    </div>

    <div class="form-group">
        <label>Preț (€):</label>
        <input type="number" step="0.01" name="price" value="<?php echo $car['price']; ?>" required>
    </div>

    <div class="form-group">
        <label>Culoare:</label>
        <input type="text" name="color" value="<?php echo htmlspecialchars($car['color']); ?>" required>
    </div>

    <div class="form-group">
        <label>Vârstă (ani):</label>
        <input type="number" name="age" value="<?php echo $car['age']; ?>" required>
    </div>

    <div class="form-group">
        <label>Istoric / Descriere:</label>
        <textarea name="history" rows="4"><?php echo htmlspecialchars($car['history']); ?></textarea>
    </div>

    <button type="submit">Actualizează</button>
    <button type="button" class="cancel" onclick="window.location.href='index.php'">Anulează</button>
</form>
</body>
</html>