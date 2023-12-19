<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connexion.php';

    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $date = $_POST['date'];
    $pages = $_POST['pages'];
    $disponible = $_POST['disponible'];

    $query = "INSERT INTO LIVRE (ID_LIVRE, TITRE, AUTEUR, DATE_PUBLICATION, NOMBRE_PAGES, DISPONIBLE) 
              VALUES (SEQUENCE_LIVRE.NEXTVAL, :bv_titre, :bv_auteur, TO_DATE(:bv_date, 'YYYY-MM-DD'), :bv_pages, :bv_disponible)";

    $stid = oci_parse($conn, $query);

    oci_bind_by_name($stid, ":bv_titre", $titre);
    oci_bind_by_name($stid, ":bv_auteur", $auteur);
    oci_bind_by_name($stid, ":bv_date", $date);
    oci_bind_by_name($stid, ":bv_pages", $pages);
    oci_bind_by_name($stid, ":bv_disponible", $disponible);

    $result = oci_execute($stid);

    if ($result) {
        echo '<script>
                alert("Livre ajouté avec succès à la base de données.");
                window.location.href = "index.php#liste-livres";
              </script>';
    } else {
        $e = oci_error($stid);
        echo '<script>
                alert("Erreur lors de l\'ajout du livre : ' . htmlentities($e['message'], ENT_QUOTES) . '");
                window.location.href = "index.php";
              </script>';
    }

    oci_free_statement($stid);
    oci_close($conn);
}
?>
