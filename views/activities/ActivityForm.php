<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisie activité</title>
    <link rel="stylesheet" href="../web/css/activity.css">
</head>

<body>
    <header>
        <nav>
            <a href="?action=profil" class="login"><button type="submit">Retour</button></a>
        </nav>
    </header>

    <div class="container">
        <form action="?action=newActivity" method="POST">

            <div class="groupe">
                <label for="sport">Sélectionnez votre sport :</label><br>
                <select id="sport" name="sport">
                    <option value="Velo">Vélo</option>
                    <option value="Natation">Natation</option>
                    <option value="Running">Course à pied</option>
                    <option value="Ski">Ski</option>
                    <option value="VTT">VTT</option>
                    <option value="Trail">Trail</option>
                </select>
            </div>

            <div class="groupe">
                <label for="distance">Distance :</label>
                <input type="number" id="distance" name="distance" step="0.1" min="0" placeholder="Distance" required>
            </div>
            <div class="groupe">
                <label for="temps">Temps de l'activité :</label>
                <input type="number" id="heure" name="hours" min="0" placeholder="Heures">
                <input type="number" id="minute" name="minute" min="0" max="59" placeholder="Minutes">
                <input type="number" id="seconde" name="seconde" min="0" max="59" placeholder="Secondes">
            </div>

            <?php
                if (isset($errorMsg)) {
                    echo "<div class='alert-warning'>$errorMsg</div>";
                }
            ?>

            <button type="submit">Envoyer l'activité</button>
        </form>
    </div>
</body>