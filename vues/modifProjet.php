<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modifier un Projet</title>
    <link rel="stylesheet" href="scss/style.css">    
</head>
<body>
    <header class="logo">
        <?php
        if($_SESSION["role"] !== "admin"){
            echo "<a href='index.php?action=accueil'><img src='images/logo.png' alt='image logo de la page'></a>";
        }else{
            echo "<a href='index.php?action=admin'><img src='images/logo.png' alt='image logo de la page'></a>";
        
        }
            ?>
    </header>
    <main>
        <div class="blc">
            <h3>Modifier un Projet</h3>
            <?php
                if(isset($reponse)){
                    echo $reponse;
                }
            ?>
            <?php
            
                if($range=mysqli_fetch_assoc($donnees)){
                    
            ?>
            <form method="post">
                <table>
                    <tr>
                        <td>
                            <label for="titre">Titre</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="titre" class="champ" value="<?php echo $range["nom"] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="txt">Description</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <textarea rows="10" cols="50" name="txt" class="champ txt" > <?php echo $range["description"]; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="action" value="modifProjetAdmin">    
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="idUtilisateur" value= <?php echo $range["id_utilisateur"]; ?> >    
                            <input type="hidden" name="idProjet" value= <?php echo $range["id"]; ?> >    
                        
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="cat">Catégorie</label>    
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <select name="cat" class="champ">
                        <?php
                            while($range=mysqli_fetch_assoc($donnees3)){
                                echo "<option value='".$range["id"]."'>".$range["id"]."-".$range["type"]."<option>";
                            }
                        ?>
                    </select>
                        </td>
                    </tr>
                    <?php
                    if($_SESSION["role"]=="admin"){
                    ?>
                    <tr>
                        <td>
                            <label for="etat">État</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="act" class="champ">
                                <option value="1">actif</option>
                                <option value="0">non-actif</option>
                            </select>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>   
                    <tr>
                        <td class="btn">
                            <input type="submit" class="btn1" value="Modifier">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <?php    
            }
        ?>
        <p class="lien">
        <?php
            if(isset($_SESSION["verification"]) && $_SESSION["verification"]=="oui" && $_SESSION["role"] == "admin" ){
                echo "<a href='index.php?action=admin'>Revenir à la page d'accueil</a>";
            }else if(isset($_SESSION["verification"]) && $_SESSION["verification"]=="oui" && $_SESSION["role"] == "entreprise"){
                echo "<a href='index.php?action=accueil'>Revenir à la page d'accueil</a>";
            }
            ?>
            
        </p>
    </main>
</body>
</html>