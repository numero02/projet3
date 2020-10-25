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
        <a href="index.php?action=admin"><img src="images/logo.png" alt="image logo de la page"></a>
    </header>
    <main>
        <div class="blc">
            <h3>Octroyé ou non un Projet</h3>
            
            <form method="post">
                <table>
                <tr>
                    <td>
                        <label for="state">Choisir un État</label>
                    </td>
                </tr>
                <tr>
                    <td>
                    <select name="state">
                            <option value="octroyé">Octroyé</option>
                            <option value="non-octroyé">Non-Octroyé</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="action" value="changeEtat">
                        <input type="hidden" name="idProjet" value=<?php echo $idProjet;?>>
                        <input type="hidden" name="idUti" value=<?php echo $idUti;?>>
                    </td>
                </tr>
                <tr>
                    <td class="btn">
                        <input type="submit" class="btn1" value="Changer">
                    </td>
                </tr>
                </table>
            </form>
        </div>
        <p class="lien">
        <a href="index.php?action=admin">Revenir à la page d'accueil</a>
        </p>
    </main>
</body>
</html>

<!--<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="scss/style.css">
    <title>Gérer les attributions de projets</title>
</head>
<body>
    <form method="post">
        <header class="logo">
            <a href="index.php?action=accueil"><img src="images/logo.png" alt="image logo de la page"></a>
        </header>
        <main>
        <div class="blc">
            <h3>Changer État</h3>
            <form method="post">
            <table>
                <tr>
                    <td>
                        <label for="state">Choisir un état</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <select name="state">
                            <option value="otroyé">Octroyé</option>
                            <option value="non-octroyé">Non-Octroyé</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="action" value="changeEtat">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Changer">
                    </td>
                </tr>
            </table>
            </form>
        </main>
</body>
</html>