<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="scss/style.css">
    <title>Inscription</title>    
</head>
<body>
    <header class="logo">
        <?php
            if($_SESSION["role"]!=="admin"){
        ?>    
            <a href="index.php?action=accueil"><img src="images/logo.png" alt="image logo de la page"></a>
        <?php
            }else if($_SESSION["role"] =="admin"){
        ?>
            <a href="index.php?action=admin"><img src="images/logo.png" alt="image logo de la page"></a>
        <?php
            }
        ?>
    </header>
    <main>
        <div class="blc2">
            <h3>Modifier Profil : <?php echo $_SESSION["user"]; ?></h3>
            <?php
                if(isset($erreur)){
                    echo "<div class='erreur'>";
                    echo "<p class='red'>Erreurs :</p>";
                    echo "<p>".$erreur."</p>";
                    echo "</div>";
                }
                if($range=mysqli_fetch_assoc($info)){
                    
            ?>
            <form method="post" class="form2">
                <table>
                    <tr>
                        <td>
                            <label for="nom" class="label">Nom Complet</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="champ" name="nom" value="<?php echo $range["nom"] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="mail">Email</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="champ" name="mail" value="<?php echo $range["courriel"] ?>">
                        </td>
                    </tr>
                    <?php
                        if($range["role"] == "prestataire"){
                    ?>
                    <tr>
                        <td>
                            <label for="spec" id="sp">Spécialité</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="champ" name="spec" id="sp1" value="<?php echo $range["specialite"] ?>">
                        </td>
                    </tr>
                    <?php
                    }  
                    ?>
                    <tr>
                        <td>
                            <label for="numero">Numéro Civique</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="champ" name="numero" value="<?php echo $range["numero"] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="rue">Rue</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="champ" name="rue" value="<?php echo $range["rue"] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="ville">Ville</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="champ" name="ville" value="<?php echo $range["ville"] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="postal">Code Postal</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="champ" name="postal" value="<?php echo $range["codePostal"] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="pays">Pays</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="champ" name="pays" value="<?php echo $range["pays"] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="action" value="modifier">
                        </td>
                    </tr>
                    <tr>
                        <td class="btn">
                            <input type="submit" class="btn1" value="Modifier">
                        </td>
                    </tr>
                </table>
            </form>
            
        </div>
        <div class="blc2">
        <h3>Modifier Mot de Passe</h3>
            <form method="post" class="form2">
            <table>
                    <tr>
                        <td>
                            <label for="pass">Mot de passe</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" class="champ" name="pass" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="pass2">Réécrire votre Mot de Passe</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" class="champ" name="pass2" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="action" value="modifierMotDePasse">
                        </td>
                    </tr>
                    <tr>
                        <td class="btn">
                            <input type="submit" class="btn1" value="Modifier">
                        </td>
                    </tr> 
                </table>
            </form>
        </div>

        <p class="lien">
        <?php
            if($_SESSION["role"] !== "admin"){
        ?>
            <a href="index.php?action=accueil">Revenir à la page d'accueil</a>
        <?php
            }else if($_SESSION["role"] == "admin"){
        ?>

        <a href="index.php?action=admin">Revenir à la page d'accueil</a>

        <?php
            }
        ?>
        </p>
        <?php
            }   
        ?>
</main>
</body>
</html>
