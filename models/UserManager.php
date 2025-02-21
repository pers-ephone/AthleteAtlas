<?php

use PHPMailer\PHPMailer\PHPMailer;

include_once "PDO.php";

function CreateNewUser($name, $birthdate, $email, $pseudo, $password)
{
    global $PDO;

    $token = bin2hex(random_bytes(16));
    $_SESSION['token'] = $token;
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (name, birthdate, email, pseudo, password, token) VALUES (:name, :birthdate, :email, :pseudo, :password, :token)";
    $pdo_prepare = $PDO->prepare($sql);
    $pdo_prepare->execute(['name' => $name, 'birthdate' => $birthdate, 'email' => $email, 'pseudo' => $pseudo, 'password' => $passwordHash, 'token' => $token]);

    return $PDO->lastInsertId();
}

function IsNickNameFree($pseudo)
{
    global $PDO;

    $sql = "SELECT * FROM user WHERE pseudo = :pseudo";
    $pdo_prepare = $PDO->prepare($sql);
    $pdo_prepare->execute([':pseudo' => $pseudo]);

    return $pdo_prepare->rowCount();
}

function IsEmailFree($email)
{
    global $PDO;

    $sql = "SELECT * FROM user WHERE email = :email";
    $pdo_prepare = $PDO->prepare($sql);
    $pdo_prepare->execute([':email' => $email]);

    return $pdo_prepare->rowCount();
}

function Login($email, $password)
{
    global $PDO;

    $sqlQuery = 'SELECT * FROM user WHERE email = :email';
    $pdo_prepare = $PDO->prepare($sqlQuery);
    $pdo_prepare->execute(['email' => $email]);
    $user = $pdo_prepare->fetch();

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    } else {
        return -1;
    }
}

function Send_mail(string $subject, string $body)
{

    //Load Composer's autoloader
    require __DIR__ . '/../web/PHPMailer/src/Exception.php';
    require __DIR__ . '/../web/PHPMailer/src/PHPMailer.php';
    require __DIR__ . '/../web/PHPMailer/src/SMTP.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    $email = $_POST['email'];

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'athleteatlas68@gmail.com';                     //SMTP username
        $mail->Password   = 'ifxphcwbtnirghfy';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($email, 'AthleteAtlas');
        $mail->addAddress($email);                              //Add a recipient

        //Variable passant dans les parametres de la fonction
        $mail->Subject = $subject;
        $mail->Body = $body;

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $subject = '';
        $body    = '';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function GetUserByTokenAndId($token, $id_user)
{

    global $PDO;
    $sqlQuery = 'SELECT * FROM user WHERE token = :token AND id_user = :id_user';
    $pdo_prepare = $PDO->prepare($sqlQuery);
    $pdo_prepare->execute(['token' => $token, 'id_user' => $id_user]);
    $user = $pdo_prepare->fetch();
    $_SESSION['mail_valide'] = $user['mail_valide'];

    return $pdo_prepare->rowCount();
}

function UpdateMail_Valide($id_user)
{
    global $PDO;
    $sqlQuery = ('UPDATE user SET mail_valide = :mail_valide WHERE id_user = :id_user');
    $pdo_prepare = $PDO->prepare($sqlQuery);
    $pdo_prepare->execute(['mail_valide' => 1, 'id_user' => $id_user]);

    return true;
}

function age()
{
    // On appelle la methode diff de l'objet $dateactuelle et on passe en argument dateanniversaore
    // $difference->y permet d'acceder à la propriété de l'objet présent dans $difference
    $dateAnniversaire = new DateTime($_SESSION['birthdate']);
    $dateActuelle = new DateTime();
    $difference = $dateActuelle->diff($dateAnniversaire);
    $age = $difference->y;

    return $age;
}

function getUserByMail($email)
{

    global $PDO;
    $email = $_POST['email'];

    $sqlQuery = 'SELECT * FROM user WHERE email = :email';
    $pdo_prepare = $PDO->prepare($sqlQuery);
    $pdo_prepare->execute(['email' => $email]);
    $user = $pdo_prepare->fetch();

    return $user;
}

function getResetTokenById($id_user)
{
    global $PDO;

    $sql = 'SELECT reset_token FROM user WHERE id_user = :id_user';
    $pdo_prepare = $PDO->prepare($sql);
    $pdo_prepare->execute(['id_user' => $id_user]);
    $new_token = $pdo_prepare->fetchColumn();

    return $new_token;
}

function getResetTokenByIdAndResetToken($id_user, $reset_token)
{
    global $PDO;

    $sqlQuery = 'SELECT * FROM user WHERE reset_token = :reset_token AND id_user = :id_user';
    $pdo_prepare = $PDO->prepare($sqlQuery);
    $pdo_prepare->execute(['reset_token' => $reset_token, 'id_user' => $id_user]);
    $reset = $pdo_prepare->rowCount();

    return $reset;
}
