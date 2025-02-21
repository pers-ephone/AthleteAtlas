<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription</title>
    <link rel="stylesheet" href="../web/css/formulaire.css">
</head>

<body>
    <header>
        <nav>
            <a href="?action=login" class="login"><button type="submit">Se connecter</button></a>
        </nav>
    </header>

    <div class="container">
        <form action="?action=register" method="POST">
            <h2>Inscription</h2>

            <div class="groupe">
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="groupe">
                <label for="birthdate">Date d'anniversaire :</label>
                <input type="date" id="birthdate" name="birthdate" required>
            </div>

            <div class="groupe">
                <label for="email">E-mail :</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="groupe">
                <label for="pseudo">Pseudo :</label>
                <input type="text" id="pseudo" name="pseudo" required>

            </div>

            <div class="groupe">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>

            </div>

            <div class="groupe">
                <label for="passwordRetype">Confirmer mot de passe :</label>
                <input type="password" id="passwordRetype" name="passwordRetype" required>

            </div>
            <?php
            if (isset($errorMsg)) {
                echo "<div class='alert-warning'>$errorMsg</div>";
            }
            ?>
            <button type="submit">S'inscire</button>
        </form>
    </div>
</body>

</html>