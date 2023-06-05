<?php
if (isset($_POST["disconnect"])) {
    session_destroy();
    header("Location: index.php");
    exit;
}
?>

<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        
        <?php if (!isset($_SESSION["id"])) { ?>

            <li><a href="inscription.php">Inscription</a></li>
            <li><a href="connexion.php">Connexion</a></li>

        <?php } else { ?>

            <li><a href="profil.php">Mon Compte</a></li>
            <form action="" method="post">
                <li><input type="submit" name="disconnect" value="Déconnexion" id="disconnect"></li>
            </form>

        <?php } if (isset($_SESSION["id"]) && $_SESSION["id"] == 1) { ?>

            <li><a href="admin.php">Admin</a></li>

        <?php } ?>

    </ul>
</nav>