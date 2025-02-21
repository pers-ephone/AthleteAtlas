<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur - Mon Site de Sport</title>
    <link rel="stylesheet" href="../web/css/profil.css">

    <script src="../web/js/scripts.js"></script>
</head>

<body>
    <?php
    include __DIR__ . '/../templates/header.php';
    ?>
    <header>

        <h1>Profil Utilisateur</h1>

    </header>
    <div class="container">
        <div class="profile-info">
            <a href="?action=newActivity">Ajouter une activité</a></br>
            <a href="?action=modifyProfile">Modifier mes informations</a></br>
            <a href="?action=userActivity">Consulter mes activités</a></br>
            <?php
            if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
                echo '<a href="?action=admin">Espace admin</a>';
            }
            ?>
            <h2>Informations Personnelles</h2>
            <ul>
                <li><strong>Nom:</strong> <?php echo $_SESSION['name'] . '</p>'; ?></li>
                <li><strong>Âge:</strong><?php echo age(); ?></li>
                <li><strong>Pseudo:</strong> <?php echo $_SESSION['pseudo'] . '</p>'; ?></li>
                <li><strong>Email:</strong> <?php echo $_SESSION['email'] . '</p>'; ?></li>
            </ul>
        </div>
        <div class="profile-stats">
            <h2>Dernière activité</h2>
            <ul>
                <li><strong>Sport:</strong> <?php echo DisplayActivity($_SESSION['id_user'], "sport");
                                            '</p>'; ?></li>
                <li><strong>Temps:</strong> <?php echo DisplayActivity($_SESSION['id_user'], "duree");
                                            '</p>'; ?></li>
                <li><strong>Distance:</strong> <?php echo DisplayActivity($_SESSION['id_user'], "distance");
                                                '</p>'; ?> km</li>
                <li><strong>Vitesse Moyenne:</strong> <?php echo
                                                        DisplayActivity($_SESSION['id_user'], "average_speed");
                                                        '</p>';
                                                        ?> km/h</li>
            </ul>
        </div>
        <div class="profile-stats">
            <h2>Statistiques</h2>

            <div class="button-stats">
                <button onclick="showSport('natation')">Natation</button>
                <button onclick="showSport('velo')">Vélo</button>
                <button onclick="showSport('course-a-pied')">Course à pied</button>
                <button onclick="showSport('ski')">Ski</button>
                <button onclick="showSport('trail')">Trail</button>
                <button onclick="showSport('vtt')">VTT</button>
            </div>

            <ul class="sport-stats natation">
                <h3>Natation</h3>
                <li><strong>Distance Parcourue:</strong> <?php TotalStat("distance", "Natation");
                                                            '</p>'; ?> km</li>
                <li><strong>Nombre de sortie</strong> <?php TotalStat("sport", "Natation");
                                                        '</p>'; ?></li>
            </ul>
            <ul class="sport-stats velo">
                <h3>Vélo</h3>
                <li><strong>Distance Parcourue:</strong> <?php TotalStat("distance", "Velo");
                                                            '</p>'; ?> km</li>
                <li><strong>Nombre de sortie</strong> <?php TotalStat("sport", "Velo");
                                                        '</p>'; ?></li>
            </ul>
            <ul class="sport-stats course-a-pied">
                <h3>Course à pied</h3>
                <li><strong>Distance Parcourue:</strong> <?php TotalStat("distance", "Running");
                                                            '</p>'; ?> km</li>
                <li><strong>Nombre de sortie</strong> <?php TotalStat("sport", "Running");
                                                        '</p>'; ?></li>
            </ul>
            <ul class="sport-stats ski">
                <h3>Ski</h3>
                <li><strong>Distance Parcourue:</strong> <?php TotalStat("distance", "Ski");
                                                            '</p>'; ?> km</li>
                <li><strong>Nombre de sortie</strong> <?php TotalStat("sport", "Ski");
                                                        '</p>'; ?></li>
            </ul>
            <ul class="sport-stats trail">
                <h3>Trail</h3>
                <li><strong>Distance Parcourue:</strong> <?php TotalStat("distance", "Trail");
                                                            '</p>'; ?> km</li>
                <li><strong>Nombre de sortie</strong> <?php TotalStat("sport", "Trail");
                                                        '</p>'; ?></li>
            </ul>
            <ul class="sport-stats vtt">
                <h3>VTT</h3>
                <li><strong>Distance Parcourue:</strong> <?php TotalStat("distance", "VTT");
                                                            '</p>'; ?> km</li>
                <li><strong>Nombre de sortie</strong> <?php TotalStat("sport", "VTT");
                                                        '</p>'; ?></li>
            </ul>
        </div>
    </div>
</body>

</html>