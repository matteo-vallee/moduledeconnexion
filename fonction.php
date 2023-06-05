<?php
function passwordConditions($password) {
    if (strlen($password) < 8) {
        ?><p class="error">Le mot de passe doit contenir au moins 8 caractères</p><?php
        return false;
    }
    if (!preg_match("#[0-9]+#", $password)) {
        ?><p class="error">Le mot de passe doit contenir au moins 1 chiffre</p><?php
        return false;
    }
    if (!preg_match("#[a-z]+#", $password)) {
        ?><p class="error">Le mot de passe doit contenir au moins 1 minuscule</p><?php
        return false;
    }
    if (!preg_match("#[A-Z]+#", $password)) {
        ?><p class="error">Le mot de passe doit contenir au moins 1 majuscule</p><?php
        return false;
    }
    if (!preg_match("#\W+#", $password)) {
        ?><p class="error">Le mot de passe doit contenir au moins 1 caractère spécial</p><?php
        return false;
    }
    return true;
}

function register($db) {
    $regQuery = $db->prepare("INSERT INTO USER (username, prenom, nom, password) VALUES (:username, :prenom, :nom, :password)");
    $regQuery->execute([
        "username" => htmlspecialchars($_POST["reg_username"]),
        "prenom" => htmlspecialchars($_POST["reg_firstname"]),
        "nom" => htmlspecialchars($_POST["reg_lastname"]),
        "password" => password_hash($_POST["reg_password"], PASSWORD_DEFAULT)
    ]);
    header("Location: connexion.php");
    exit();
}
?>