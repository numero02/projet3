<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="scss/style.css">
    <title>Inscription</title>
    <style>
        .remove{
            display:none;
        }
    </style>
    <script>
        window.addEventListener("load", function(){
            var selection = document.getElementById("sel");
            var champ = document.getElementById("sp");
            var champ1 = document.querySelector("#sp1");
            var champUser = document.getElementById("user");
            var btn = document.querySelector(".btn1");
            
            sel.addEventListener("change",function(){
                if(selection.value == "entreprise"){
                    champ.classList.add("remove");
                    champ1.classList.add("remove");
                }else{
                    champ.classList.remove("remove");
                    champ1.classList.remove("remove");
                }
            });
        });
    </script>
</head>
<body>
    <header class="logo">
        <?php
            if(!isset($_SESSION["verification"])){

            
        ?>
        <a href="index.php?action=accueil"><img src="images/logo.png" alt="image logo de la page"></a>
        <?php
            }else if(isset($_SESSION["verification"]) && ($_SESSION["role"] == "admin")){
            
        ?>
        <a href="index.php?action=admin"><img src="images/logo.png" alt="image logo de la page"></a>
        <?php
            }
        ?>
    
    </header>
    <main>
        <div class="blc2">
            <h3>Inscription</h3>
            
                <?php
                    if(isset($erreur)){
                        echo "<div class='erreur'>";
                        echo "<p class='red'>Erreurs :</p>";
                        echo "<p>".$erreur."</p>";
                        echo "</div>";
                    }
                ?>
            
            <form method="post" class="form2">
                <table>
                    <tr>
                        <td>
                            <label for="username">Nom d'Utilisateur</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="champ" name="username" id="user">
                        </td>
                    </tr>
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
                            <label for="nom">Nom Complet</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="champ" name="nom" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="mail">Email</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="champ" name="mail" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="role">Role</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="role" id="sel" class="champ">
                                <option value="prestataire">prestataire</option>
                                <option value="entreprise">entreprise</option>
                            </select>
                        </td>
                    </tr>
                    <tr >
                        <td>
                            <label for="spec" id="sp">Spécialité</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="champ" name="spec" id="sp1">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="numero">Numéro Civique</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="champ" name="numero" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="rue">Rue</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="champ" name="rue" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="ville">Ville</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="champ" name="ville" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="postal">Code Postal</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="champ" name="postal">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="pays">Pays</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="champ" name="pays">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="action" value="ajoutMembre">
                        </td>
                    </tr>
                    <tr>
                        <td class="btn">
                            <input type="submit" class="btn1" value="s'inscrire">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <p class="lien">
            <?php
            if(!isset($_SESSION["verification"])){
                echo "<a href='index.php?action=accueil' >Revenir à la page d'accueil</a>";
            }else if(isset($_SESSION["verification"]) && $_SESSION["verification"]=="oui" && $_SESSION["role"] == "admin" ){
                echo "<a href='index.php?action=admin'>Revenir à la page d'accueil</a>";
            }
            ?>
        </p>
        
</main>
</body>
</html>
