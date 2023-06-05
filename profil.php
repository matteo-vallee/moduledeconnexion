<?php
require "functions.php";

$db = new PDO("mysql:host=localhost;dbname=moduleconnexion", "root", "");
session_start();

if (isset($_SESSION["id"])) {
    $query = $db->prepare("SELECT * FROM utilisateurs WHERE id = :id");
    $query->execute([
        "id" => $_SESSION["id"]
    ]);
    $self = $query->fetchAll(PDO::FETCH_ASSOC);
}

$query = $db->prepare("SELECT * FROM utilisateurs");
$query->execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST["save"])) {
    $valid = true;

    foreach ($users as $user) {
        if ($_POST["edit_username"] == $user["username"] && $_POST["edit_username"] != $self[0]["username"]) {
            ?><p class="error">Ce pseudo est déjà utilisé</p><?php
            $valid = false;
            break;
        }
    }

    if ($valid && !password_verify($_POST["current_password"], $self[0]["password"])) {
        ?><p class="error">Le mot de passe actuel est incorrect</p><?php
        $valid = false;
    }


    if ($valid && !passwordConditions($_POST["edit_password"])) {
        $valid = false;
    }


    if ($valid && $_POST["edit_password"] != $_POST["edit_password_confirm"]) {
        ?><p class="error">Les mots de passe ne correspondent pas</p><?php
        $valid = false;
    }

    if ($valid) {
        $query = $db->prepare("UPDATE utilisateurs SET username = :username, prenom = :prenom, nom = :nom, password = :password WHERE id = :id");
        $query->execute([
            "username" => $_POST["edit_username"],
            "prenom" => $_POST["edit_firstname"],
            "nom" => $_POST["edit_lastname"],
            "password" => password_hash($_POST["edit_password"], PASSWORD_DEFAULT),
            "id" => $_SESSION["id"]
        ]);
        header("Location: profil.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
</head>
<body>

<?php include "header.php"; ?>

<?php if (!isset($_POST["update"]) && isset($_SESSION["id"])) { ?>

    <p>Pseudo : <?php echo $self[0]["username"] ?></p>
    <p>Prénom : <?php echo $self[0]["prenom"] ?></p>
    <p>Nom : <?php echo $self[0]["nom"] ?></p>

    <form action="" method="post">
        <input type="submit" name="update" value="Modifier le profil">
    </form>

<?php } elseif (isset($_SESSION["id"])) { ?>

    <form action="" method="post">
        <label for="username">Pseudo</label>
        <input type="text" name="edit_username" value="<?php echo $self[0]["username"] ?>" required>
        <label for="firstname">Prénom</label>
        <input type="text" name="edit_firstname" value="<?php echo $self[0]["prenom"] ?>" required>
        <label for="lastname">Nom</label>
        <input type="text" name="edit_lastname" value="<?php echo $self[0]["nom"] ?>" required>
        <label for="password">Mot de passe actuel</label>
        <input type="password" name="current_password" required>
        <label for="password">Nouveau mot de passe</label>
        <input type="password" name="edit_password" required>
        <label for="password">Confirmation du mot de passe</label>
        <input type="password" name="edit_password_confirm" required>
        <input type="submit" name="save" value="Sauvegarder les modifications">
    </form>

<?php } else { ?>

    <p class="error">Vous devez être connecté pour accéder à cette page</p>

<?php } ?>
    
</body>
</html>

<?php
$db = null;
?>