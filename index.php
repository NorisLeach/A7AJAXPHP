<?php
require 'db.php';
/** @var PDO $pdo */
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Second-Hand Cars - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <a href="index.php">Home</a>
    <a href="add-car.php">Adaugă Mașină</a>
    <a href="manage-categories.php">Gestionare Categorii</a>
</nav>

<h2>Răsfoiește Mașini</h2>

<div class="form-group" style="max-width: 300px;">
    <label for="category-select">Filtrează după categorie:</label>
    <select id="category-select" onchange="fetchCars(this.value)">
        <option value="">Toate categoriile</option>
        <?php
        $stmt = $pdo->query("SELECT * FROM categories");
        while ($row = $stmt->fetch()) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
    </select>
</div>

<div id="filter-info"></div>

<table>
    <thead>
    <tr>
        <th>Model (Click pt. detalii)</th>
        <th>Categorie</th>
        <th>Preț (€)</th>
        <th>Culoare</th>
        <th>Acțiuni</th>
    </tr>
    </thead>
    <tbody id="cars-table-body">
    </tbody>
</table>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const savedCategory = localStorage.getItem('last_category_filter') || "";
        document.getElementById('category-select').value = savedCategory;

        fetchCars(savedCategory);
    });

    function fetchCars(categoryId) {
        localStorage.setItem('last_category_filter', categoryId);

        const selectElement = document.getElementById('category-select');
        const selectedText = selectElement.options[selectElement.selectedIndex].text;
        document.getElementById('filter-info').innerText = "Ultimul filtru utilizat: " + (categoryId ? selectedText : "Toate");

        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'get-cars.php?category_id=' + categoryId, true);

        xhr.onload = function() {
            if (this.status === 200) {
                const cars = JSON.parse(this.responseText);
                let output = '';

                if(cars.length === 0) {
                    output = '<tr><td colspan="5" style="text-align:center;">Nu există mașini în această categorie.</td></tr>';
                } else {
                    cars.forEach(car => {
                        output += `
                                <tr>
                                    <td><a href="car-details.php?id=${car.id}"><strong>${car.model}</strong></a></td>
                                    <td>${car.category_name}</td>
                                    <td>${car.price}</td>
                                    <td>${car.color}</td>
                                    <td>
                                        <a class="btn-edit" href="edit-car.php?id=${car.id}">Editează</a>
                                        <a class="btn-delete" onclick="confirmDelete(${car.id})">Șterge</a>
                                    </td>
                                </tr>
                            `;
                    });
                }
                document.getElementById('cars-table-body').innerHTML = output;
            }
        };
        xhr.send();
    }

    function confirmDelete(id) {
        if (confirm("Sigur dorești să ștergi această mașină?")) {
            window.location.href = "delete-car.php?id=" + id;
        }
    }
</script>
</body>
</html>