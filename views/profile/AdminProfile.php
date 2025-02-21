<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="../web/css/all_activities.css">
    <script src="../web/js/scripts.js"></script>
</head>

<body>
    <div class="container">
        <h1>Pseudos</h1>
        <a href="?action=profile">Retour profil</a>
        <div class="activites">
            <table>
                <thead>
                    <tr>
                        <th>Pseudo</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    // On récuprere depuis le controlleur
                    if (isset($displaypseudo)) {
                        foreach ($displaypseudo as $user) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($user['pseudo']) . "</td>";
                            echo "<td><a href='?action=admin&id_user=" . htmlspecialchars($user['id_user']) . "' onclick='return confirmDeletion();' role='button'>supprimer</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Aucune activité trouvée</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</body>

</html>