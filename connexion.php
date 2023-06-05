<?php
$db = new PDO("mysql:host=localhost;dbname=moduleconnexion", "root", "");
session_start();
$query = $db->prepare("SELECT username, password, id FROM utilisateurs");
$query->execute();
$utilisateurs = $query->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST["login"])) {

    foreach ($users as $user) {

        if ($_POST["log_username"] == $utilisateurs["username"]) {
            $valid = true;

            if (!password_verify($_POST["log_password"], $utilisateurs["password"])) {
                ?><p class="error">Le mot de passe est incorrect</p><?php
                $valid = false;
            }
        
            if ($valid) {
                $_SESSION["id"] = $utilisateurs["id"];
                header("Location: profil.php");
                exit();
            }
        }
    }

}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Connexion</title>
</head>
<body>

<?php include "header.php"; ?>

<form action="" method="post">
    <label for="username">Pseudo</label>
    <input type="text" name="log_username" required>
    <label for="password">Mot de passe</label>
    <input type="password" name="log_password" required>
    <input type="submit" name="login" value="Connexion">
</form>
    
</body>
</html>

<?php
$db = null;
?>