<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion</title>
    <link rel="stylesheet" href="scss/style.css">
    <link href="https://fonts.googleapis.com/css?family=EB+Garamond:400i&display=swap" rel="stylesheet">
</head>
<body>
    <header class="logo">
        <a href="index.php?action=accueil"><img src="images/logo.png" alt="image logo de la page"></a>
    </header>
    <main>
        <div class="blc">
            <h3>Connexion</h3>
            <?php
                    if(isset($erreur1)){
                        echo "<div class='erreur'>";
                        echo "<p class='red'>Erreurs :</p>";
                        echo "<p>".$erreur1."</p>";
                        echo "</div>";
                    }
                ?>
            <form method="post">
                <table>
                <tr>
                    <td>
                        <label for="username">Nom d'Utilisateur</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" class="champ" name="username" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="passwd">Mot de Passe</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="password" class="champ" name="passwd">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" class="champ" name="action" value="verification">
                    </td>
                </tr>
                <tr>
                    <td class="btn">
                        <input type="submit" class="btn1" value="Connexion">
                    </td>
                </tr>
                </table>
            </form>
        </div>
        <p class="lien">
        <a href="index.php?action=accueil">Revenir à la page d'accueil</a>
        </p>
    </main>
</body>
</html>