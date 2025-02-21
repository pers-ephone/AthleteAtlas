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
        <form action="?action=modifyProfile" method="POST">
            <h2>Modifier mes informations</h2>
            <div class="groupe">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="name" value="<?php echo $_SESSION['name']; ?>">
            </div>

            <div class="groupe">
                <label for="email">E-mail :</label>
                <input type="email" id="email" name="email" value=" <?php echo $_SESSION['email']; ?>">
            </div>
            <div class="groupe">
                <label for="pseudo">Pseudo :</label>
                <input type="text" id="pseudo" name="pseudo" value=" <?php echo $_SESSION['pseudo']; ?>">
            </div>

            <button type="submit">Modifier</button>
        </form>
    </div>
</body>

</html>