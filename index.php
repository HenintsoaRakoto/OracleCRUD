<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <title>Bibliothèque</title>
</head>
<body>

<div class="container mt-5">
    <h2 class="container my-4 text-center">Gestion des Livres</h2>

    <!-- Formulaire d'ajout de livre -->
    <div class="card">
        <div class="h2 card-header">Ajouter un livre</div>
        <div class="card-body">
            <form action="ajouter_livre.php" method="post">
                <div class="form-group">
                    <label for="titre">Titre du livre:</label>
                    <input type="text" class="form-control" id="titre" name="titre" required>
                </div>
                <div class="form-group">
                    <label for="auteur">Auteur(s):</label>
                    <input type="text" class="form-control" id="auteur" name="auteur">
                </div>
                <div class="form-group">
                    <label for="date">Date de Publication:</label>
                    <input type="date" class="form-control" id="date" name="date">
                </div>
                <div class="form-group">
                    <label for="pages">Nombre de pages:</label>
                    <input type="number" class="form-control" id="pages" name="pages">
                </div>
                <div class="form-group">
                    <label for="disponible">Disponible:</label>
                    <select class="form-control" id="disponible" name="disponible">
                        <option value="O">Oui</option>
                        <option value="N">Non</option>
                    </select> <br>
                </div>
                <button type="submit" class="btn ms-auto float-end btn-primary">Ajouter Livre</button>
            </form>
        </div>
    </div>

    <!-- Liste des livres -->
    <div class="container mt-5 text-center" id="liste-livres">
    <h2 class="mb-4">Liste des Livres</h2>
    <a name="liste-livres"></a>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Auteur(s)</th>
            <th>Date de Publication</th>
            <th>Nombre de Pages</th>
            <th>Disponible</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <?php
                include 'connexion.php';

                $query = "SELECT * FROM LIVRE";
                $stid = oci_parse($conn, $query);
                oci_execute($stid);

                while ($row = oci_fetch_assoc($stid)) {
                    echo "<tr>";
                    echo "<td>" . $row['ID_LIVRE'] . "</td>";
                    echo "<td>" . $row['TITRE'] . "</td>";
                    echo "<td>" . $row['AUTEUR'] . "</td>";
                    echo "<td>" . $row['DATE_PUBLICATION'] . "</td>";
                    echo "<td>" . $row['NOMBRE_PAGES'] . "</td>";
                    echo "<td>" . ($row['DISPONIBLE'] == 'O' ? 'Oui' : 'Non') . "</td>";
                   
                    echo "<td>
                    <a class='btn btn-primary' href='afficher_livre.php?id=" . $row['ID_LIVRE'] . "'>Détails</a>
                    <a class='btn btn-warning' href='modifier_livre.php?id=" . $row['ID_LIVRE'] . "'>Modifier</a>
                    <button class='btn btn-danger delete-btn' data-id='" . $row['ID_LIVRE'] . "'>Supprimer</button>                    </td>";
            echo "</tr>";
                }
// Ajoutez cette fonction JavaScript pour confirmer la suppression
echo "
<script>
    function confirmDelete(id) {
        var confirmation = confirm('Voulez-vous vraiment supprimer ce livre?');

        if (confirmation) {
            window.location.href = 'supprimer_livre.php?id=' + id;
        }
    }
</script>";

                // Ajoutez cette fonction JavaScript pour confirmer la suppression
// echo "
// <script>
//     function confirmDelete(id) {
//         if (confirm('Voulez-vous vraiment supprimer ce livre?')) {
//             window.location.href = 'supprimer_livre.php?id=' + id;
//         }
//     }
// </script>";

                oci_free_statement($stid);
                oci_close($conn);
            ?>
        </tbody>
    </table>

</div>
<!-- Boîte de dialogue modale Bootstrap -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation de suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Voulez-vous vraiment supprimer ce livre?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Supprimer</button>
            </div>
        </div>
    </div>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('.delete-btn').click(function () {
            var id = $(this).data('id');

            // Afficher la boîte de dialogue modale Bootstrap
            $('#confirmationModal').modal('show');

            // Associer l'ID du livre à supprimer avec le bouton de confirmation
            $('#confirmDeleteBtn').data('id', id);
        });

        // Fonction de suppression appelée depuis la boîte de dialogue modale
        $('#confirmDeleteBtn').click(function () {
            var id = $(this).data('id');
            window.location.href = 'supprimer_livre.php?id=' + id;
        });
    });
</script>

</body>
</html>
