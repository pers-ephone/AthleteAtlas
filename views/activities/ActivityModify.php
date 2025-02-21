<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier vos informations</title>
    <link rel="stylesheet" href="../web/css/formulaire.css">
</head>

<body>
    
    <div class="container">
        <form action="?action=modifyActivity" method="POST">
            <h2>Modifier mon activité</h2>

            <div class="groupe">
                <label for="sport">Sélectionnez votre sport :</label><br>
                <select id="sport" name="sport">
                    <option value="Natation">Natation</option>
                    <option value="Velo">Vélo</option>
                    <option value="Running">Course à pied</option>
                    <option value="Ski">Ski</option>
                    <option value="Vtt">VTT</option>
                    <option value="Trail">Trail</option>
                </select>
            </div>

            <div class="groupe">
                <label for="distance">Distance</label>
                <input type="distance" id="distance" name="distance" value=" <?php echo $_GET['distance']; ?>">
            </div>
            <div class="groupe">
                <label for="temps">Temps de l'activité :</label>
                <?php 
                $duree = $_GET['duree'];
                $_SESSION['id_performance'] = $_GET['id_performance'];
                list($hours, $minute, $seconde) = explode(':', $duree); 
                ?>
                <input type="number" id="heure" name="hours" min="0" placeholder="Heures" value="<?php echo $hours; ?>">
                <input type="number" id="minute" name="minute" min="0" max="59" placeholder="Minutes" value="<?php echo $minute; ?>">
                <input type="number" id="seconde" name="seconde" min="0" max="59" placeholder="Secondes" value="<?php echo $seconde; ?>">
            </div>

            <button type="submit">Modifier</button>
            <?php
                if (isset($errorMsg)) {
                    echo "<div class='alert-warning'>$errorMsg</div>";
                }
            ?>
        </form>
    </div>
</body>

</html>