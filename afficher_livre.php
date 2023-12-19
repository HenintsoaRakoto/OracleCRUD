<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <title>detail du livre</title>
</head>
<body>

<?php
include 'connexion.php';

if (isset($_GET['id'])) {
    $id_livre = $_GET['id'];

    $query = "SELECT * FROM LIVRE WHERE ID_LIVRE = :bv_id";
    $stid = oci_parse($conn, $query);

    oci_bind_by_name($stid, ":bv_id", $id_livre);
    oci_execute($stid);

    $row = oci_fetch_assoc($stid);

    if ($row) {
        // Affichez les détails du livre
        echo "<h2 class='mb-4'>Détails du Livre</h2>";
        echo "<p class='lead'><strong>Titre:</strong> " . $row['TITRE'] . "</p>";
        echo "<p class='lead'><strong>Auteur:</strong> " . $row['AUTEUR'] . "</p>";
        echo "<p class='lead'><strong>Date de Publication:</strong> " . $row['DATE_PUBLICATION'] . "</p>";
        echo "<p class='lead'><strong>Nombre de Pages:</strong> " . $row['NOMBRE_PAGES'] . "</p>";
        echo "<p class='lead'><strong>Disponible:</strong> " . ($row['DISPONIBLE'] == 'O' ? 'Oui' : 'Non') . "</p>";
          } else {
        echo "<p>Livre non trouvé.</p>";
    }

    oci_free_statement($stid);
    oci_close($conn);
} else {
    echo "<p>Paramètre ID non spécifié.</p>";
}
?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>

    </body>
</html>
