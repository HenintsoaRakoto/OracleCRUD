<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connexion.php';

    $id_livre = $_POST['id_livre'];
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $date = $_POST['date'];
    $pages = $_POST['pages'];
    $disponible = $_POST['disponible'];

    $query = "UPDATE LIVRE SET 
              TITRE = :bv_titre,
              AUTEUR = :bv_auteur,
              DATE_PUBLICATION = TO_DATE(:bv_date, 'YYYY-MM-DD'),
              NOMBRE_PAGES = :bv_pages,
              DISPONIBLE = :bv_disponible
              WHERE ID_LIVRE = :bv_id";

    $stid = oci_parse($conn, $query);

    oci_bind_by_name($stid, ":bv_id", $id_livre);
    oci_bind_by_name($stid, ":bv_titre", $titre);
    oci_bind_by_name($stid, ":bv_auteur", $auteur);
    oci_bind_by_name($stid, ":bv_date", $date);
    oci_bind_by_name($stid, ":bv_pages", $pages);
    oci_bind_by_name($stid, ":bv_disponible", $disponible);

    $result = oci_execute($stid);

    if ($result) {
        echo '<script>
                alert("Modification enregistrée avec succès.");
                window.location.href = "index.php#liste-livres";
              </script>';
    } else {
        $e = oci_error($stid);
        echo '<script>
                alert("Erreur lors de l\'enregistrement de la modification : ' . htmlentities($e['message'], ENT_QUOTES) . '");
                window.location.href = "index.php";
              </script>';
    }

    oci_free_statement($stid);
    oci_close($conn);
}
?>
