<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page Admin</title>
    <link rel="stylesheet" href="scss/style.css">
    <link href="https://fonts.googleapis.com/css?family=EB+Garamond:400i&display=swap" rel="stylesheet">
</head>
<body>
<header class="entete">
        <div class="bloc1">
            
            <a href="index.php?action=admin"><img src="images/logo.png" alt=""></a>
            <p>Le Succès dans vos Projets</p>
        </div>
        <div class="bloc2">
            <a href="index.php?action=profil">Gérer Profil</a>
            <a href="index.php?action=deconnexion">Déconnexion</a>
        </div>
    </header>
    <main>
    <main>
        <h1>Bienvenue utilisateur : <span class="title"> <?php echo $_SESSION["nomComplet"]; ?></span></h1>
        <h2>Type de compte : <?php echo $_SESSION["role"];?></h2>
        
        
        <div class=link>
            <p><a href="index.php?action=ajoutProjet">Ajouter un Projet</a></p>
            <p><a href="index.php?action=inscription">Créer un utilisateur</a></p>
        </div>
        <nav>
            <ul>
                <li><a href="#L1">Liste des projets</a></li>
                <li><a href="#L2">Liste des utilisateurs</a></li>
                <li><a href="#L3">Gérer les projets</a></li>
            </ul>
        </nav>
        <h2 id="L1">1/-Liste des projets</h2>
        <section>
            <div>
            <?php
                while($rangee=mysqli_fetch_assoc($donnees)){
                    echo "<article>";
                        echo "<h3> Projet : </h3>";
                        echo "<a href='index.php?action=suppression&idProjet=".$rangee["id"]."' class='supp'>Supprimer Projet</a>";
                        echo "<a href='index.php?action=modifierProjet&idProjet2=".$rangee["id"]."' class='supp'>Modifier Projet</a>";
                        if(etatProjet($rangee["id"]) == 1 ){
                            echo "<a href='index.php?action=modifierEtatProjet&idProjet=".$rangee["id"]."&etat=".etatProjet($rangee["id"])."' class='supp'>Désactiver le Projet</a>";
                        }else if(etatProjet($rangee["id"]) == 0) {
                            echo "<a href='index.php?action=modifierEtatProjet&idProjet=".$rangee["id"]."&etat=".etatProjet($rangee["id"])."' class='supp'>Activer le Projet</a>";
                        }
                        echo "<p> Nom : ". $rangee["nom"] . "</p>";
                                if($rangee2=mysqli_fetch_assoc(GetCategorie($rangee["id"]))){
                                    echo "<p>Catégorie : ".$rangee2["type"]."</p>";
                                }
                        echo "<p>Description : <br><br>" . $rangee["description"] . "</p>";
                    echo "</article>";
                }
            ?>
            </div>
        </section>
        
        <h2 id="L2">2/-Listes des utilisateurs</h2>
        <section>
            <div>
            <?php
                while($rangee=mysqli_fetch_assoc($donnees2)){
                    if($rangee["role"] !== "admin"){    
                        echo "<article>";
                            echo "<h3> Utilisateur: " . $rangee["nom"] . "</h3>";
                            echo "<a href='index.php?action=suppressionCompte&idCompte=".$rangee["id"]."' class='supp'>Supprimer Compte</a>";
                            if(getStateUser($rangee["id"]) == 0){
                                echo "<a href='index.php?action=etatUser&idUti=".$rangee["id"]."' class='supp'>Activer l'utilisateur</a>";
                            }else if(getStateUser($rangee["id"]) == 1){
                                echo "<a href='index.php?action=etatUser&idUti=".$rangee["id"]."' class='supp'>Désactiver l'utilisateur</a>";
                            }
                            
                            echo "<p> Username : " . $rangee["username"] . "</p>";
                            echo "<p> Nom Complet : " . $rangee["nom"]."</p>";
                            echo "<p> Email : " . $rangee["courriel"] . "</p>";
                            if($rangee["role"] !== "entreprise"){
                                echo "<p> Spécialité : " . $rangee["specialite"] . "</p>";
                            }
                            echo "<p> Role : " . $rangee["role"] . "</p>";
                        echo "</article>";
                    } 
                }
            ?>
            </div>
        </section>
        
        <h2 id="L3">3/-Gérer les Projets</h2>
        <section>
            <div>
            <?php
                while($range=mysqli_fetch_assoc($donnees3)){
                    echo "<article>";
                    echo "<h3>Nom du Projet : ".$range["nomProjet"]."</h3>";
                    echo "<p class='supp'>État de la demande : ".$range["etat"]."</p>";
                    echo "<br>";
                    echo "<a href='index.php?action=etat&idProjet=".$range["idProjet"]."&idUti=".$range["idUtilisateur"]."' class='supp'>Changer l'État de la demande</a>";
                    echo "<p>nom utilisateur : ". $range["nomUsager"]."</p>";
                    echo "<p>a postulé au projet : ". $range["nomProjet"]."</p>";
                    echo "</article>";
                    
                }
            ?>
            </div>
        </section>
        
    </main>
    <footer>
        <p>Site Web a été réalisé par Walid Drihem</p>
    </footer>
</body>
</html>