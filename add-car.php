<?php
require 'db.php';
/** @var PDO $pdo */

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
        $stmt = $pdo->prepare('INSERT INTO cars (category_id, model, engine_power, fuel, price, color, age, history) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$category_id, $model, $engine_power, $fuel, $price, $color, $age, $history]);

        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Adaugă Mașină Nouă</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <a href="index.php">Home</a>
    <a href="add-car.php">Adaugă Mașină</a>
    <a href="manage-categories.php">Gestionare Categorii</a>
</nav>

<h2>Adaugă o mașină nouă</h2>

<form action="add-car.php" method="POST" onsubmit="return validateForm()">

    <div class="form-group">
        <label for="model">Model Mașină:</label>
        <input type="text" name="model" id="model" placeholder="Ex: Volkswagen Golf 7" required>
    </div>

    <div class="form-group">
        <label for="category_id">Categorie:</label>
        <select name="category_id" id="category_id" required>
            <?php
            $stmt = $pdo->query("SELECT * FROM categories");
            while ($row = $stmt->fetch()) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="engine_power">Putere Motor (CP):</label>
        <input type="number" name="engine_power" id="engine_power" min="1" placeholder="Ex: 150" required>
    </div>

    <div class="form-group">
        <label for="fuel">Combustibil:</label>
        <input type="text" name="fuel" id="fuel" placeholder="Ex: Benzina / Diesel / Electric" required>
    </div>

    <div class="form-group">
        <label for="price">Preț (€):</label>
        <input type="number" step="0.01" name="price" id="price" min="0.1" placeholder="Ex: 8500" required>
    </div>

    <div class="form-group">
        <label for="color">Culoare:</label>
        <input type="text" name="color" id="color" placeholder="Ex: Albastru" required>
    </div>

    <div class="form-group">
        <label for="age">Vârstă (ani):</label>
        <input type="number" name="age" id="age" min="0" placeholder="Ex: 4" required>
    </div>

    <div class="form-group">
        <label for="history">Istoric / Descriere vehicul:</label>
        <textarea name="history" id="history" rows="4" placeholder="Detalii despre revizii, accidente, starea mașinii..."></textarea>
    </div>

    <button type="submit">Salvează Mașina</button>
    <button type="button" class="cancel" onclick="confirmCancel()">Anulează</button>
</form>

<script>
    function validateForm() {
        const model = document.getElementById('model').value.trim();
        const price = parseFloat(document.getElementById('price').value);
        const fuel = document.getElementById('fuel').value.trim();

        if (model.length < 2) {
            alert('Eroare: Numele modelului trebuie să aibă cel puțin 2 caractere.');
            return false;
        }
        if (isNaN(price) || price <= 0) {
            alert('Eroare: Prețul trebuie să fie un număr mai mare decât 0.');
            return false;
        }
        if (fuel.length < 3) {
            alert('Eroare: Introduceți un tip de combustibil valid.');
            return false;
        }

        return true;
    }

    function confirmCancel() {
        if (confirm("Sigur vrei să renunți? Toate datele completate în acest formular se vor pierde.")) {
            window.location.href = "index.php";
        }
    }
</script>
</body>
</html>