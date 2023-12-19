<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <title>modification</title>
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
        // Affichez le formulaire de modification avec les informations existantes
        ?>
        <div class="container mt-5">
            <h2>Modifier les informations du Livre</h2>
            <form action="enregistrer_modification.php" method="post">
                <input type="hidden" name="id_livre" value="<?php echo $row['ID_LIVRE']; ?>">
                <div class="form-group">
                    <label for="titre">Titre du Livre:</label>
                    <input type="text" class="form-control" id="titre" name="titre" value="<?php echo $row['TITRE']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="auteur">Auteur:</label>
                    <input type="text" class="form-control" id="auteur" name="auteur" value="<?php echo $row['AUTEUR']; ?>">
                </div>
                <div class="form-group">
                    <label for="date">Date de Publication:</label>
                    <input type="date" class="form-control" id="date" name="date" value="<?php echo $row['DATE_PUBLICATION']; ?>">
                </div>
                <div class="form-group">
                    <label for="pages">Nombre de Pages:</label>
                    <input type="number" class="form-control" id="pages" name="pages" value="<?php echo $row['NOMBRE_PAGES']; ?>">
                </div>
                <div class="form-group">
                    <label for="disponible">Disponible:</label>
                    <select class="form-control" id="disponible" name="disponible">
                        <option value="O" <?php echo ($row['DISPONIBLE'] == 'O' ? 'selected' : ''); ?>>Oui</option>
                        <option value="N" <?php echo ($row['DISPONIBLE'] == 'N' ? 'selected' : ''); ?>>Non</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer la modification</button>
            </form>
        </div>
        <?php
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