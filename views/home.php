<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AthleteAtlas</title>
    <link rel="stylesheet" href="/web/css/home.css">
    <link rel="stylesheet" href="web/css/header.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
</head>

<body>
    <header>
        <?php include 'templates/header.php'; ?>
    </header>

    <main>
        <div class="choose">
            <h2>Choisissez votre sport</h2>
        </div>

        <?php
        // Exemple d'affichage d'un message d'erreur
        if (isset($errorMsg)) {
            echo "<div class='alert-warning'>$errorMsg</div>";
        }
        ?>

        <div class="sports-container">
            <a href="?action=sport&sport=Velo" class="sport">
                <img src="web/img/velo.png" alt="velo">
                <p>Vélo</p>
            </a>

            <a href="?action=sport&sport=Natation" class="sport">
                <img src="/web/img/natation.png" alt="natation">
                <p>Natation</p>
            </a>

            <a href="?action=sport&sport=Running" class="sport">
                <img src="web/img/cap.png" alt="cap">
                <p>Course à pied</p>
            </a>

            <a href="?action=sport&sport=VTT" class="sport">
                <img src="web/img/vtt.png" alt="vtt">
                <p>VTT</p>
            </a>

            <a href="?action=sport&sport=Trail" class="sport">
                <img src="web/img/trail.png" alt="trail">
                <p>Trail</p>
            </a>

            <a href="?action=sport&sport=Ski" class="sport">
                <img src="web/img/ski.png" alt="ski">
                <p>Ski</p>
            </a>
        </div>
    </main>

</body>
<footer>
    <?php include 'templates/footer.php'; ?>
</footer>

</html>