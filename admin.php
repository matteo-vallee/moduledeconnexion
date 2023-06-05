<?php
$db = new PDO("mysql:host=localhost;dbname=moduleconnexion", "root", "");
session_start();

$query = $db->prepare("SELECT * FROM utilisateurs");
$query->execute();
$utilisateurs = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Page admin</title>
</head>
<body>

<?php include "header.php"; ?>

<?php if (isset($_SESSION["id"]) && $_SESSION["id"] == 1) { ?>
<table border="1">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>prenom</th>
            <th>nom</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($utilisateurs as $user) { ?>
            <tr>
                <td><?= $user["id"] ?></td>
                <td><?= $user["username"] ?></td>
                <td><?= $user["prenom"] ?></td>
                <td><?= $user["nom"] ?></td>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php } else { ?>
    <p class="error">Vous n'avez pas accès à cette page</p>
<?php } ?>
    
</body>
</html>

<?php
$db = null;
?>