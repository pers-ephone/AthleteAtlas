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
        <h1>Tableau des activités</h1>
        <a href="?action=profile">Retour profil</a>
        <div class="activites">
            <table>
                <thead>
                    <tr>
                        <th>Sport</th>
                        <th>Distance</th>
                        <th>Durée</th>
                        <th>Vitesse(km/h)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // On récuprere depuis le controlleur
                    if (isset($displayUserActivity)) {
                        foreach ($displayUserActivity as $user) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($user['sport']) . "</td>";
                            echo "<td>" . htmlspecialchars($user['distance']) . "</td>";
                            echo "<td>" . htmlspecialchars($user['duree']) . "</td>";
                            echo "<td>" . htmlspecialchars($user['average_speed']) . "</td>";
                            echo "<td><a href='?action=modifyActivity&id_performance=" . htmlspecialchars($user['id_performance']) . "&distance=" . htmlspecialchars($user['distance']) . "&duree=" . htmlspecialchars($user['duree']) . "&average_speed=" . htmlspecialchars($user['average_speed']) . "'>Modifier</a></td>";
                            echo "<td><a href='?action=deleteActivity&id_performance=" . htmlspecialchars($user['id_performance']) . "' onclick='return confirmDeletion();' role='button'>supprimer</a></td>";
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