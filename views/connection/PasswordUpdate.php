<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Connexion</title>
    <link rel="stylesheet" href="../web/css/formulaire.css">
</head>

<body>
    <header>

        <nav>
            <a href="?action=register" class="login"><button type="submit">S'inscrire</button></a>
        </nav>
    </header>

    <div class="container">
        <form action="?action=updatePassword&id_user=<?php echo isset($_GET['id_user']) ? $_GET['id_user'] : ''; ?>&reset_token=<?php echo isset($_GET['reset_token']) ? $_GET['reset_token'] : ''; ?>" method="POST">
            <h2>Connexion</h2>
            <div class="groupe">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="groupe">
                <label for="password_confirme">Confirmation du mot de passe :</label>
                <input type="password" id="password_confirme" name="password_confirme" required>
            </div>

            <button type="submit">Se connecter</button>
            <?php

            if (isset($errorMsg)) {
                echo "<div class='alert-warning'>$errorMsg</div>";
            }
            if (isset($success)) {
                echo "<div class='alert-success'>$success</div>";
            }
            ?>
        </form>
    </div>
</body>

</html>