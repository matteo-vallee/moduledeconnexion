<?php
require "fonction.php";

$db = new PDO("mysql:host=localhost;dbname=moduleconnexion", "root", "");
session_start();
$query = $db->prepare("SELECT username FROM utilisateurs");
$query->execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST["register"])) {
    $valid = true;

    foreach ($users as $user) { 
        if ($_POST["reg_username"] == $user["username"]) {
            ?><p class="error">Ce pseudo est déjà utilisé</p><?php
            $valid = false;
            break;
        }
    }

    if ($valid && $_POST["reg_password"] != $_POST["reg_password_confirm"]) {
        ?><p class="error">Les mots de passe ne correspondent pas</p><?php
        $valid = false;
    }

    if ($valid && !passwordConditions($_POST["reg_password"])) {
        $valid = false;
    }

    if ($valid) {
        register($db);
    }
}

$db = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>

<?php include "header.php"; ?>
    
<form action="" method="post">
    <label for="username">Pseudo</label>
    <input type="text" name="reg_username" required>
    <label for="firstname">Prénom</label>
    <input type="text" name="reg_firstname" required>
    <label for="lastname">Nom</label>
    <input type="text" name="reg_lastname" required>
    <label for="password">Mot de passe</label>
    <input type="password" name="reg_password" required>
    <label for="password_confirm">Confirmation du mot de passe</label>
    <input type="password" name="reg_password_confirm" required>
    <input type="submit" name="register" value="Inscription">
</form>
</body>
</html>