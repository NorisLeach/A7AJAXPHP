<?php
require 'db.php';
/** @var PDO $pdo */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['cat_name'])) {
    $cat_name = trim($_POST['cat_name']);

    $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
    $stmt->execute([$cat_name]);

    header('Location: manage-categories.php');
    exit;
}

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
    $stmt->execute([$delete_id]);

    header('Location: manage-categories.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Gestionare Categorii</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <a href="index.php">Home</a>
    <a href="add-car.php">Adaugă Mașină</a>
    <a href="manage-categories.php">Gestionare Categorii</a>
</nav>

<h2>Categorii de Mașini Disponibile</h2>
<p>Mai jos sunt categoriile salvate în sistem. Mașinile șterse dintr-o categorie vor dispărea automat.</p>

<ul style="background: white; padding: 20px; max-width: 400px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); list-style-position: inside;">
    <?php
    $stmt = $pdo->query("SELECT * FROM categories");
    while ($row = $stmt->fetch()) {
        echo "<li style='padding: 5px 0; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;'>
            <strong>" . htmlspecialchars($row['name']) . "</strong>
            <a href='manage-categories.php?delete_id={$row['id']}' 
               onclick='return confirm(\"Atenție! Ștergerea acestei categorii va șterge automat și toate mașinile din ea. Sigur vrei să continui?\")' 
               style='color: red; text-decoration: none; font-size: 12px; margin-left: 20px;'>
               [ Șterge ]
            </a>
          </li>";
    }
    ?>
</ul>

<br>
<h3>Adaugă o categorie nouă în sistem</h3>
<form action="manage-categories.php" method="POST">
    <div class="form-group">
        <label for="cat_name">Nume Categorie nouă:</label>
        <input type="text" name="cat_name" id="cat_name" placeholder="Ex: Cabrio / Pick-up" required>
    </div>
    <button type="submit">Adaugă Categoria</button>
</form>

</body>
</html>