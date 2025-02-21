<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de connexion</title>
    <link rel="stylesheet" href="../web/css/formulaire.css">
</head>

<body>
    <header>
        <nav>
            <a href="?action=register" class="login"><button type="submit">S'inscrire</button></a>
        </nav>
    </header>

    <div class="container">
        <form action="?action=login" method="POST">
            <h2>Connexion</h2>

            <div class="groupe">
                <label for="email">Email :</label>
                <input type="text" id="email" name="email" required>

            </div>

            <div class="groupe">
                <label for="pseudo">Mot de passe :</label>
                <input type="password" id="password" name="password" required>

            </div>

            <?php

            if (isset($errorMsg)) {
                echo "<div class='alert-warning'>$errorMsg</div>";
            }
            if (isset($success)) {
                echo "<div class='alert-success'>$success</div>";
            }
            ?>
            <button type="submit">Se connecter</button>
            <a href="?action=forgetPassword" class="forget">Mot de passe oublié ?</a>
        </form>
    </div>
</body>

</html>