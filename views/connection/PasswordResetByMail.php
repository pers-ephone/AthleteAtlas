<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="../web/css/formulaire.css">
</head>

<body>
    <header>

        <nav>
            <a href="?action=register" class="login"><button type="submit">S'inscrire</button></a>
        </nav>
    </header>

    <div class="container">
        <form action="?action=forgetPassword" method="POST">
            <h2>Mot de passe oublié</h2>
            <div class="groupe">
                <label for="email">Mail :</label>
                <input type="email" id="email" name="email" required>
            </div>

            <button type="submit">Envoyer</button>
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