
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Accueil</title>
    <link rel="stylesheet" href="scss/style.css">
    <link href="https://fonts.googleapis.com/css?family=EB+Garamond:400i&display=swap" rel="stylesheet">
    <script>
        
    </script>
</head>
<body>
    <header class="entete">
        <div class="bloc1">
        <?php
            if(isset($_SESSION["verification"]) && isset($_SESSION["role"])){    
                if($_SESSION["role"] !== "admin" ){
            ?>
            <a href="index.php?action=accueil"><img src="images/logo.png" alt=""></a>
            <?php
                }else if($_SESSION["role"] == "admin"){
            ?>
                    <a href="index.php?action=admin"><img src="images/logo.png" alt=""></a>
            <?php
                }
            }else{
            ?>
                <a href="index.php?action=accueil"><img src="images/logo.png" alt=""></a>
            <?php
            }
            ?>
            <p>Le Succès dans vos Projets</p>
        </div>
        <div class="bloc2">
            <?php
            if(isset($_SESSION["verification"])){    
                if($_SESSION["verification"] == "oui"){    
            ?>
            <a href="index.php?action=profil">Gérer Profil</a>
            <a href="index.php?action=deconnexion">Déconnexion</a>
            
            <?php
                }
            }else{
            ?>
                <a href="index.php?action=inscription">Inscription</a>
                <a href="index.php?action=connexion" class="b2">Connexion</a>
            <?php
            }
            ?>
        </div>
    </header>
    <main>
        <?php
            if(!isset($_SESSION["verification"])){
        ?>
        <h1>Bienvenue</h1>
        <?php
            }else if(isset($_SESSION["verification"]) && ($_SESSION["verification"] == "oui")){
        ?>
        <h1>Bienvenue utilisateur : <span class="title"> <?php echo $_SESSION["nomComplet"]; ?></span></h1>
        <h2>Type de compte : <?php echo $_SESSION["role"];?></h2>
        <?php
            }
            
        ?>  
        <h2>Liste des Projets</h2>
        <?php
             if(isset($_SESSION["verification"]) && ($_SESSION["verification"] == "oui")){
        ?>
        <?php
                if($_SESSION["role"] == "entreprise"){
        ?>
        
        <p><a href="index.php?action=ajoutProjet">Ajouter un Projet</a></p>
        <?php
                }
            }
        ?>      
        <section>
            <div>
                <!-- partie php pour afficher les projets pour un utilisateur non-authentifié -->
                <?php
                    
                    if(!isset($_SESSION["verification"])){
                        while($rangee=mysqli_fetch_assoc($donnees)){
                            if($rangee["actif"] == 1){
                                echo "<article>";
                                    echo "<h3> Projet : </h3>"; 
                                    echo "<p>Nom : ". $rangee["nom"] . "</p>";
                                    if($rangee2=mysqli_fetch_assoc(GetCategorie($rangee["id"]))){
                                        echo "<p>Catégorie : ".$rangee2["type"]."</p>";
                                    }
                                    echo "<p>Description : <br><br>" . $rangee["description"] . "</p>";
                                echo "</article>";
                            }
                        }
                    }else if(isset($_SESSION["verification"]) && ($_SESSION["verification"] == "oui")){
                        if($_SESSION["role"] == "entreprise"){
                            while($rangee=mysqli_fetch_assoc($donnees4)){
                                if($rangee["actif"] == 1){
                                    echo "<article>"; 
                                    echo "<h3> Projet : </h3>";
                                    echo "<a href='index.php?action=modifierProjet&idProjet2=".$rangee["id"]."' class='supp'>Modifier Projet</a>";
                                    if(etatProjet($rangee["id"]) == 1 ){
                                        echo "<a href='index.php?action=modifierEtatProjet&idProjet=".$rangee["id"]."&etat=".etatProjet($rangee["id"])."' class='supp'>Supprimer le projet</a>";
                                    }
                                    
                                    echo "<p> Nom : ". $rangee["nom"] . "</p>";
                                    if($rangee2=mysqli_fetch_assoc(GetCategorie($rangee["id"]))){
                                        echo "<p>Catégorie : ".$rangee2["type"]."</p>";
                                    }
                                    echo "<p>Description : <br><br>" . $rangee["description"] . "</p>";
                                    echo "</article>";
                                }
                        }
                        }else if($_SESSION["role"] == "prestataire"){
                            while($rangee=mysqli_fetch_assoc($donnees)){
                                if($rangee["actif"] == 1){
                                    echo "<article>";
                                        echo "<h3> Projet : </h3>";   
                                        if(GetAllEtatPost($_SESSION["idUser"] , $rangee["id"]) !== false){
                                            echo "<p class='supp'> État : ".GetAllEtatPost($_SESSION["idUser"] , $rangee["id"])."</p>";
                                        }else if(!changeEtatProjetOctroye($rangee["id"])){
                                            echo "<a href='index.php?action=postuler&idProjet=".$rangee["id"]."' class='supp'>Postuler</a>";    
                                        }else{
                                            echo "<p class='supp'>* Vous ne pouvez pas postuler à ce projet car il a déjà été octroyé à un autre prestataire !</p>";
                                        }
                                        echo "<p> Nom : ". $rangee["nom"] . "</p>";
                                    if($rangee2=mysqli_fetch_assoc(GetCategorie($rangee["id"]))){
                                        echo "<p>Catégorie : ".$rangee2["type"]."</p>";
                                    }
                                    echo "<p>Description : <br><br>" . $rangee["description"] . "</p>";
                                    echo "</article>";
                                }

                            }
                        }
                    }
                ?>
            </div>
        </section>
    </main>
    <!-- footer de la page -->
    <footer>
         <p>Site Web a été réalisé par Walid Drihem</p>           
    </footer>
</body>
</html>