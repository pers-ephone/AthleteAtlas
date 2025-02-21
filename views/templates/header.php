<div class="logo-titre">
    <link rel="stylesheet" href="../web/css/header.css">
    <a href="?action=display">
        <img src="web/img/logo.png" alt="logo" class="logovelo">
    </a>
    <h1 class="title">AthleteAtlas</h1>
    <div class="nav-container">
        <?php if (isset($_SESSION['id_user']) && $_SESSION['mail_valide'] == 1) { ?>
            <nav>
                <a href="?action=logout" class="login"><button type="submit">Se Déconnecter</button></a>
            </nav>
            <nav>
                <a href="?action=profile">
                    <img src="web/img/profile.logo.png" alt="logo" class="logo_profile">
                </a>
            </nav>
        <?php } else { ?>
            <nav>
                <a href="?action=login" class="login"><button type="submit">Se connecter</button></a>
            </nav>
        <?php } ?>
    </div>

</div>