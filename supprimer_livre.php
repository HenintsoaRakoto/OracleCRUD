<?php
include 'connexion.php';

if (isset($_GET['id'])) {
    $id_livre = $_GET['id'];

    $query = "DELETE FROM LIVRE WHERE ID_LIVRE = :bv_id";
    $stid = oci_parse($conn, $query);

    oci_bind_by_name($stid, ":bv_id", $id_livre);
    $result = oci_execute($stid);

    if ($result) {
        echo '<script>
                alert("Livre supprimé avec succès.");
                window.location.href = "index.php#liste-livres";
              </script>';
    } else {
        $e = oci_error($stid);
        echo '<script>
                alert("Erreur lors de la suppression du livre : ' . htmlentities($e['message'], ENT_QUOTES) . '");
                window.location.href = "index.php";
              </script>';
    }

    oci_free_statement($stid);
    oci_close($conn);
} else {
    echo "<p>Paramètre ID non spécifié.</p>";
}
?>
