<?php

$action = $_GET["action"] ?? "display";

switch ($action) {

    case 'register':
        include "../models/UserManager.php";
        if (
            isset($_POST['pseudo']) &&
            isset($_POST['password']) &&
            isset($_POST['passwordRetype']) &&
            isset($_POST['name']) &&
            isset($_POST['birthdate']) &&
            isset($_POST['email'])
        ) {
            $errorMsg = NULL;
            if (IsNickNameFree($_POST['pseudo']) == 1) {
                $errorMsg = "Le pseudo est déjà utilisé";
            } else if ($_POST['password'] != $_POST['passwordRetype']) {
                $errorMsg = "Les mot de passes ne sont pas identiques";
            } else if (strlen(trim($_POST['password'])) < 8) {
                $errorMsg = "Le mot de passe doit contenir au minimum 8 caractéres";
            } elseif (IsEmailFree($_POST['email']) == 1) {
                $errorMsg = "Le mail est déjà utilisé";
            }
            if ($errorMsg) {
                include "../views/connection/RegisterForm.php";
            } else {
                $id_user = CreateNewUser($_POST['name'], $_POST['birthdate'], $_POST['email'], $_POST['pseudo'], $_POST['password']);
                $send_confirmation_mail = Send_mail('Validation email AthleteAtlas', 'https://athleteatlas.alwaysdata.net/?action=validateMail&id_user=' . $id_user . '&token=' . $_SESSION['token'] . '');
                if ($send_confirmation_mail) {
                    $success = "Un mail de confirmation a été envoyé par mail";
                    include "../views/connection/LoginForm.php";
                } else {
                    $errorMsg = "Erreur lors de l'envoi du mail de confirmation";
                    include "../views/connection/RegisterForm.php";
                }
            }
        } else {
            include "../views/connection/RegisterForm.php";
        }
        break;

    case 'logout':
        if (isset($_SESSION['id_user'])) {
            session_unset();
            session_destroy();
        }
        header('Location: ?action=display');
        break;

    case 'login':
        include "../models/UserManager.php";

        if (isset($_POST['email']) && isset($_POST['password'])) {
            $user = login($_POST['email'], $_POST['password']);

            if ($user > 0) {
                if ($user['mail_valide'] != 1) {
                    $errorMsg = "Le mail n'est pas validé";
                    include "../views/connection/LoginForm.php";
                } else {
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['id_user'] = $user['id_user'];
                    $_SESSION['is_admin'] = $user['is_admin'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['pseudo'] = $user['pseudo'];
                    $_SESSION['birthdate'] = $user['birthdate'];
                    $_SESSION['mail_valide'] = $user['mail_valide'];
                    header('Location: ?action=profile');
                    exit;
                }
            } else {
                $errorMsg = "Le mail et le mot de passe ne correspondent pas";
                include "../views/connection/LoginForm.php";
            }
        } else {
            include "../views/connection/LoginForm.php";
        }
        break;

    case 'forgetPassword':
        include "../models/UserManager.php";
        include "../models/PostManager.php";
        if (isset($_POST['email'])) {
            $user = getUserByMail($_POST['email']);
            if ($user) {
                $reset_token = bin2hex(random_bytes(30));
                $update = updateUserResetToken($user['id_user'], $reset_token);
                if ($update) {
                    getResetTokenById($user['id_user']);
                    $send_forget_password = Send_mail('AthleteAtlas', 'https://athleteatlas.alwaysdata.net/?action=updatePassword&id_user=' . $user['id_user'] . '&reset_token=' . $reset_token . '');
                    if ($send_forget_password) {
                        $success = "Merci de consulter vos mails pour la réuperation du mot de passe";
                        include "../views/connection/PasswordResetByMail.php";
                    } else {
                        $errorMsg = "Erreur lors de l'envoi du mail";
                        include "../views/connection/PasswordResetByMail.php";
                    }
                } else {
                    $errorMsg = "Erreur lors de la mise à jours de la BDD";
                    include "../views/connection/PasswordResetByMail.php";
                }
            } else {
                $errorMsg = "Aucun mail trouvé dans la base de donnée";
                include "../views/connection/PasswordResetByMail.php";
            }
        } else {
            include "../views/connection/PasswordResetByMail.php";
        }
        break;

    case 'updatePassword':
        include "../models/UserManager.php";
        include "../models/PostManager.php";
        if (isset($_GET['id_user']) && isset($_GET['reset_token'])) {

            $reset = getResetTokenByIdAndResetToken($_GET['id_user'], $_GET['reset_token']);
            if ($reset > 0) {
                if (isset($_POST['password']) && isset($_POST['password_confirme'])) {
                    if (strlen(trim($_POST['password'])) > 8) {
                        if ($_POST['password'] === $_POST['password_confirme']) {
                            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                            $update = updatePassword($_GET['id_user'], $password);
                            if ($update) {
                                $success = "Mot de passe mis à jour avec succés";
                                include "../views/connection/LoginForm.php";
                                exit();
                            } else {
                                $errorMsg = "Erreur lors du changement de mot de passe";
                                include "../views/connection/PasswordUpdate.php";
                            }
                        } else {
                            $errorMsg = "Les mot de passes ne correspondent pas";
                            include "../views/connection/PasswordUpdate.php";
                        }
                    } else {
                        $errorMsg = "Le mot de passe doit contenir au minimum 8 caractéres";
                        include "../views/connection/PasswordUpdate.php";
                    }
                } else {
                    include "../views/connection/PasswordUpdate.php";
                }
            } else {
                $errorMsg = "Aucun compte ne correspond";
                include "../views/connection/PasswordUpdate.php";
            }
        } else {
            $errorMsg = "Inforations manquantes";
            include "../views/connection/PasswordUpdate.php";;
        }
        break;

    case "validateMail":
        include "../models/UserManager.php";
        if (isset($_GET['id_user']) && isset($_GET['token'])) {
            $user = GetUserByTokenAndId($_GET['token'], $_GET['id_user']);
            if ($user > 0) {

                if ($_SESSION['mail_valide'] == 0) {
                    UpdateMail_Valide($_GET['id_user']);
                    $success = "Mail validé merci de vous connecter";
                    include "../views/connection/LoginForm.php";
                }
            } else {
                $errorMsg = "Votre mail n'est pas validé";
                include "../views/connection/LoginForm.php";
            }
        }

        break;

    case 'newActivity':
        include "../models/PostManager.php";

        // Vérifie si l'utilisateur est connecté et que son mail est validé
        if (isset($_SESSION['mail_valide']) && $_SESSION['mail_valide'] == 1 && isset($_SESSION['id_user'])) {
            // Vérifie si les données POST nécessaires sont définies
            if (isset($_POST['sport'])) {
                $timeString = sprintf('%02d:%02d:%02d', $_POST['hours'], $_POST['minute'], $_POST['seconde']);
                $duree_hours = intval($_POST['hours']) + intval($_POST['minute']) / 60 + intval($_POST['seconde']) / 3600;
                $vitesse = $_POST['distance'] / $duree_hours;
                // number_format on souhaite afficher uniquement 2 chiffres aprés la virgule
                $vitesse_formate = number_format($vitesse, 2);
                $postactivity = PostActivity($_SESSION['id_user'], $_POST['sport'], $_POST['distance'], $timeString, $vitesse_formate);
                if ($postactivity) {
                    header('Location: ?action=profile');
                    exit; // Assure de ne pas exécuter le code suivant après la redirection
                } else {
                    $errorMsg = "Echec de l'ajout de l'activité";
                    include "../views/activities/ActivityForm.php";
                }
            } else {

                include "../views/activities/ActivityForm.php";
            }
        } else {
            $errorMsg = "Merci de vous connecter pour accéder à la page";
            include "../views/connection/LoginForm.php";
        }
        break;

    case 'deleteActivity':

        include "../models/PostManager.php";
        if (isset($_SESSION['mail_valide']) && $_SESSION['mail_valide'] == 1 && isset($_SESSION['id_user'])) {
            if ($_GET['id_performance']) {
                $suppressActivity = SuppressCommentary($_GET['id_performance']);
                if ($suppressActivity) {
                    header('Location: ?action=userActivity');
                } else {
                    $errorMsg = "Une erreure s'est produite";
                    include "../views/activities/ActivityAll.php";
                }
            } else {
                $errorMsg = "Donnée(s) manquante(s)";
                include "../views/activities/ActivityAll.php";
            }
        } else {
            $errorMsg = "Merci de vous connecter pour accéder à la page";
            include "../views/connection/LoginForm.php";
        }

        break;

    case 'modifyActivity':
        include "../models/PostManager.php";
        if (isset($_SESSION['mail_valide']) && $_SESSION['mail_valide'] == 1 && isset($_SESSION['id_user'])) {

            if (isset($_POST['sport']) && isset($_POST['distance']) && isset($_POST['hours']) && isset($_POST['minute']) && isset($_POST['seconde'])) {
                $timeString = sprintf('%02d:%02d:%02d', $_POST['hours'], $_POST['minute'], $_POST['seconde']);
                $duree_hours = intval($_POST['hours']) + intval($_POST['minute']) / 60 + intval($_POST['seconde']) / 3600;
                $vitesse = $_POST['distance'] / $duree_hours;
                // number_format on souhaite afficher uniquement 2 chiffres aprés la virgule
                $vitesse_formate = number_format($vitesse, 2);
                $updateUser = updateUserActivity($_POST['sport'], $_POST['distance'], $timeString, $vitesse_formate, $_SESSION['id_performance']);
                if ($updateUser) {
                    // Si c'est l'admin on redirige vers le tableau de la communauté
                    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
                        header('Location: ?action=sport&sport=' . urlencode($_POST['sport']));
                    } else {
                        header('Location: ?action=userActivity');
                    }
                } else {
                    $errorMsg = "Donnée(s) manquante(s)";
                    include "../views/activities/ActivityModify.php";
                }
            } else {
                include "../views/activities/ActivityModify.php";
            }
        } else {
            $errorMsg = "Merci de vous connecter";
            include "../views/connection/LoginForm.php";
        }
        break;

    case 'modifyProfile':
        include "../models/PostManager.php";

        // Vérifie si l'utilisateur est connecté et si son mail est validé
        if (isset($_SESSION['mail_valide']) && $_SESSION['mail_valide'] == 1 && isset($_SESSION['id_user'])) {
            if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['pseudo'])) {
                $updateprofil = UpdateProfile($_POST['name'], $_POST['email'], $_POST['pseudo'], $_SESSION['id_user']);
                if ($updateprofil) {
                    // On reconfigure les superglobales pour mettre à jour le profil
                    $_SESSION['name'] = $_POST['name'];
                    $_SESSION['email'] = $_POST['email'];
                    $_SESSION['pseudo'] = $_POST['pseudo'];
                    header('Location: ?action=profile');
                    exit; // Assure de ne pas exécuter le code suivant après la redirection
                } else {
                    $errorMsg = "Erreur lors de la mise à jour des données";
                    include "../views/profile/ProfileModify.php";
                }
            } else {
                include "../views/profile/ProfileModify.php";
            }
        } else {
            $errorMsg = "Merci de vous connecter";
            include "../views/connection/LoginForm.php";
        }
        break;

    case 'userActivity':
        include "../models/DisplayManager.php";

        if (isset($_SESSION['id_user']) && $_SESSION['mail_valide'] == 1) {
            // Récupérer les données depuis le modèle
            $displayUserActivity = DisplayAllUserActivity($_SESSION['id_user']);
            // On appel la fonction pour pouvoir reutiliser la variable dans la vue
            if ($displayUserActivity) {
                // Passer les données à la vue
                include "../views/activities/ActivityAll.php";
            } else {
                $errorMsg = "Erreur lors de l'affichage des données";
                include "../views/activities/ActivityAll.php";
            }
        } else {
            $errorMsg = "Merci de vous connecter pour accéder à la page";
            include "../views/connection/LoginForm.php";
        }
        break;

    case 'sport':
        include "../models/DisplayManager.php";

        if (isset($_SESSION['id_user']) && $_SESSION['mail_valide'] == 1) {
            // Récupérer les données depuis le modèle

            if ($_GET['sport']) {
                $order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'distance';
                $displaySport = DisplaySport($order_by, $_GET['sport']);
                // On appel la fonction pour pouvoir reutiliser la variable dans la vue
                if ($displaySport) {
                    // Passer les données à la vue
                    include "../views/sport.php";
                } else {
                    $errorMsg = "Erreur lors de l'affichage des données";
                    include "../views/sport.php";
                }
            } else {
                $errorMsg = 'Il manque des informations pour charger la page';
                include "../views/home.php";
            }
        } else {
            $errorMsg = "Merci de vous connecter pour accéder à la page";
            include "../views/connection/LoginForm.php";
        }
        break;

    case 'profile':
        include "../models/DisplayManager.php";
        include "../models/UserManager.php";
        if (
            isset($_SESSION['name']) &&
            isset($_SESSION['id_user']) &&
            isset($_SESSION['email']) &&
            isset($_SESSION['pseudo']) &&
            isset($_SESSION['birthdate']) &&
            $_SESSION['mail_valide'] == 1
        ) {
            include "../views/profile/Profile.php";
        } else {
            $errorMsg = "Merci de vous connecter pour accéder à la page";
            include "../views/connection/LoginForm.php";
        }
        break;

    case 'admin':
        include "../models/DisplayManager.php";
        include "../models/PostManager.php";
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
            $displaypseudo = DisplayPseudoForAdmin();
            if ($displaypseudo) {
                include "../views/profile/AdminProfile.php";
                if (isset($_GET['id_user'])) {
                    $deletepseudo = DeletePseudoByAdmin($_GET['id_user']);
                    if ($deletepseudo) {
                        header('Location: ?action=admin');
                    }
                }
            } else {
                echo "Erreur lors de l'affichage de la page";
            }
        } else {
            $errorMsg = "Vous devez etre admin pour consulter cette page";
            include "../views/connection/LoginForm.php";
        }
        break;

    case 'about':
        include "../views/about.php";
        break;

    case 'verifuserapi':
        include "../models/APIManager.php";

        //check all parameters
        if (!isset($_GET['email'])) {
            echo "Missing parameter: email";
            break;
        }
        if (!isset($_GET['password'])) {
            echo "Missing parameter: password";
            break;
        }

        header('Content-Type: text/plain');
        VerifUser($_GET['email'], $_GET['password']);
        break;

    case 'getuserperfapi':
        include "../models/APIManager.php";
        if (isset($_GET['id_user'])) {
            header('Content-Type: application/json');
            echo GetUserPerformance($_GET['id_user']);
        } else {
            echo "Missing parameter: id_user";
        }
        break;

    case 'createuserapi':
        include "../models/APIManager.php";
        $data = json_decode(file_get_contents('php://input'), true);

        //check all parameters
        if (!isset($data['pseudo'])) {
            echo "Missing parameter: pseudo";
            break;
        }
        if (!isset($data['password'])) {
            echo "Missing parameter: password";
            break;
        }
        if (!isset($data['email'])) {
            echo "Missing parameter: email";
            break;
        }
        if (!isset($data['name'])) {
            echo "Missing parameter: name";
            break;
        }
        if (!isset($data['birthdate'])) {
            echo "Missing parameter: birthdate";
            break;
        }

        header('Content-Type: application/json');
        echo CreateUser(
            $data['pseudo'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['email'],
            $data['name'],
            $data['birthdate']
        );
        break;

    case 'createperfapi':
        include "../models/APIManager.php";
        $data = json_decode(file_get_contents('php://input'), true);

        //check all parameters
        if (!isset($data['distance'])) {
            echo "Missing parameter: distance";
            break;
        }
        if (!isset($data['duree'])) {
            echo "Missing parameter: duree";
            break;
        }
        if (!isset($data['sport'])) {
            echo "Missing parameter: sport";
            break;
        }
        if (!isset($data['id_user'])) {
            echo "Missing parameter: id_user";
            break;
        }

        header('Content-Type: application/json');
        // Convertir la durée au format HH:MM:SS en secondes
        list($hours, $minutes, $seconds) = explode(':', $data['duree']);
        $total_seconds = $hours * 3600 + $minutes * 60 + $seconds;

        // Calculer la vitesse moyenne (en km/h si distance est en km)
        $total_hours = $total_seconds / 3600;
        $average_speed = $data['distance'] / $total_hours;

        echo CreatePerf(
            $data['distance'],
            $data['duree'],
            $average_speed,
            $data['sport'],
            $data['id_user']
        );
        break;

    case 'display':
    default:

        include "../views/home.php";
        break;
}
