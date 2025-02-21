<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $_GET['sport'] ?></title>
    <link rel="stylesheet" href="../web/css/velo.css">
</head>

<body>
    <?php
    include 'templates/header.php';
    ?>
    <header>

        <h1><?php echo $_GET['sport'] ?></h1>

    </header>

    <div class="main">
        <div class="sidebar">
            <div class="profile-summary">
                <h2><?php echo htmlspecialchars($_SESSION['pseudo']); ?></h2>
                <p>Nombre d'activités : <?php TotalStat("sport", $_GET['sport']); ?></p>
            </div>

        </div>
        <div class="commu">
            <a href="?action=sport&sport=<?php echo $_GET['sport']; ?>&order_by=distance">Trier par distance</a>
            <a href="?action=sport&sport=<?php echo $_GET['sport']; ?>&order_by=average_speed">Trier par vitesse</a>
            <table>
                <thead>
                    <tr>
                        <th>Classement</th>
                        <th>Pseudo</th>
                        <th>Distance</th>
                        <th>Durée</th>
                        <th>Vitesse moyenne (km/h)</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($displaySport)) {
                        $count = 0;
                        foreach ($displaySport as $user) {
                            $count++;
                            echo "<tr>";
                            echo "<td>" . $count . "</td>";
                            echo "<td>" . htmlspecialchars($user['pseudo']) . "</td>";
                            echo "<td>" . htmlspecialchars($user['distance']) . "</td>";
                            echo "<td>" . htmlspecialchars($user['duree']) . "</td>";
                            echo "<td>" . htmlspecialchars($user['average_speed']) . "</td>";
                            if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
                                echo "<td><a href='?action=modifyActivity&id_performance=" . htmlspecialchars($user['id_performance']) . "&distance=" . htmlspecialchars($user['distance']) . "&duree=" . htmlspecialchars($user['duree']) . "&average_speed=" . htmlspecialchars($user['average_speed']) . "'>Modifier</a></td>";
                                echo "<td><a href='?action=deleteActivity&id_performance=" . htmlspecialchars($user['id_performance']) . "' onclick='return confirmDeletion();' role='button'>Supprimer</a></td>";
                            }

                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <?php
        include 'templates/footer.php';
        ?>
    </footer>
</body>

</html>