<?php

session_start();

if(isset($_REQUEST["action"])){
    $action = $_REQUEST["action"];
}else{
    $action = "accueil";
}

require_once("function_db.php");

switch($action){
    case "accueil":
        $donnees=GetAllProject();
        if(isset($_SESSION["idUser"])){
            $donnees4=GetProjectId($_SESSION["idUser"]);
        }
        require_once("vues/accueil.php");
        break;
    
    case "connexion":
        require_once("vues/connexion.php");
    break;
    
    case "verification":
        if(isset($_POST["username"]) && isset($_POST["passwd"])
        && !empty($_POST["username"]) && !empty($_POST["passwd"])){
            if(verification($_POST["username"], $_POST["passwd"])){


                if(userActif($_POST["username"]) == 1){

                    $_SESSION["verification"]= "oui";
                    $_SESSION["user"]=$_POST["username"];
                    if(GetRole($_POST["username"]) !== false){
                        $_SESSION["role"]=GetRole($_POST["username"]);
                    }
                    $users=infoUser($_SESSION["user"]);
                    if($range=mysqli_fetch_assoc($users)){
                        $_SESSION["idUser"]=$range["id"];
                        $_SESSION["nomComplet"]=$range["nom"];
                    }
                    if( $_SESSION["role"] !== "admin"){
                        header("LOCATION:index.php?action=accueil");
                    }else{
                        header("LOCATION:index.php?action=admin");
                    }

                }else{
                    $erreur1="votre compte utilisateur a été désactivé par l'administrateur du site !";
                    require_once("vues/connexion.php");
                }

            }else{
                $erreur1="le mot de passe ou le nom d'utilisateur est erroné !";
                require_once("vues/connexion.php");
            }
        }else{
            $erreur1="veuillez rentrer correctement les champs Nom d'utilisateur/Mot de passe";
            require_once("vues/connexion.php");
        }
        
    break;

    case "inscription":
        require_once("vues/inscription.php");
    break;
    
    case "ajoutMembre":

            $erreur="";
    
            if(($_POST["pass"] !== $_POST["pass2"])){
                $erreur="* le premier mot de passe n'est pas similaire au deuxième ! <br>";
            }
           
            if(!is_numeric($_POST["numero"]) && !empty($_POST["numero"]) ){
                $erreur= $erreur . "* la donnée rentrée pour le numéro civique n'est pas une valeur numérique ! <br>"; 
            }

            if(empty($_POST["username"]) || empty($_POST["pass"]) 
            || empty($_POST["pass2"]) || empty($_POST["nom"]) 
            || empty($_POST["numero"]) || empty($_POST["rue"]) 
            || empty($_POST["ville"]) || empty($_POST["pays"])
            || empty($_POST["postal"]) || empty($_POST["mail"])){

                    $erreur= $erreur . "* veuillez remplir tous les champs ! <br>"; 
            }
            if(($_POST["role"] == "prestataire") && $_POST["spec"] == "" ){
                $erreur= $erreur . "* veuillez entrer une spécialité ! <br>";
            }

            if($erreur !== ""){
                require_once("vues/inscription.php");
            }else{
                $pass=password_hash($_POST["pass"],PASSWORD_DEFAULT);
                ajoutMembre($_POST["nom"],$_POST["numero"],$_POST["rue"],$_POST["ville"],$_POST["postal"],$_POST["pays"],$_POST["mail"],$_POST["role"],$_POST["username"],$pass,$_POST["spec"],1);
                if(!isset($_SESSION["verification"])){
                    header("LOCATION:index.php?action=accueil");
            
                }else if(isset($_SESSION["verification"]) && $_SESSION["role"] == "admin"){
                    header("LOCATION:index.php?action=admin");
                }
            }
    break;
    case "profil":
        if($_SESSION["verification"] == "oui"){
            $info=infoUser($_SESSION["user"]);
            require_once("vues/profil.php");
        }else{
            header("LOCATION:index.php?action=accueil");
        }
    break;
    case "modifier":
        if($_SESSION["verification"] == "oui"){
            $erreur="";

            if(!is_numeric($_POST["numero"]) && !empty($_POST["numero"]) ){
                $erreur= $erreur . "* la donnée rentrée pour le numéro civique n'est pas une valeur numérique ! <br>"; 
            }   
            if(empty($_POST["nom"])){
                $erreur=$erreur ."* veuillez remplir le champ du Nom Complet ! <br>";
            }
            if(empty($_POST["mail"])){
                $erreur=$erreur ."* veuillez remplir le champ de l'Email ! <br>";
            }
            if(empty($_POST["numero"])){
                $erreur=$erreur ."* veuillez remplir le champ du numéro civique ! <br>";
            }
            if(empty($_POST["rue"])){
                $erreur=$erreur ."* veuillez remplir le champ du nom de la rue ! <br>";
            }
            if(empty($_POST["ville"])){
                $erreur=$erreur ."* veuillez remplir le champ du nom de la ville ! <br>";
            }
            if(empty($_POST["postal"])){
                $erreur=$erreur ."* veuillez remplir le champ du code postal ! <br>";
            }
            if(empty($_POST["pays"])){
                $erreur=$erreur ."* veuillez remplir le champ pays ! <br>";
            }
            if(($_SESSION["role"]=="prestataire") && empty($_POST["spec"]) ){
                $erreur=$erreur ."* veuillez remplir le champ spécialité ! <br>";
            }
            if($erreur == ""){
                modifProfil($_SESSION["user"],$_POST["nom"],$_POST["mail"],$_POST["spec"],$_POST["numero"],$_POST["rue"],$_POST["ville"],$_POST["postal"],$_POST["pays"]);
                if($_SESSION["role"]!=="admin"){
                    header("LOCATION:index.php?action=accueil");
                }else{
                    header("LOCATION:index.php?action=admin");
                }
            }else{
                $info=infoUser($_SESSION["user"]);
                require_once("vues/profil.php");
            }
        }else{
            header("LOCATION:index.php?action=accueil");
        }
        
    break;

    case "modifierMotDePasse":
        if($_SESSION["verification"] == "oui" ){
            $erreur="";
            if(($_POST["pass"] !== $_POST["pass2"])){
                $erreur="* le premier mot de passe n'est pas similaire au deuxième ! <br>";
            
            }
            if(empty($_POST["pass"]) || empty($_POST["pass2"])){
                $erreur="* veuillez remplire tous les champs de mots de passe ! <br>";
            }
            if($erreur !== ""){
                $info=infoUser($_SESSION["user"]);
                require_once("vues/profil.php");
            }else{
                $pass=password_hash($_POST["pass"],PASSWORD_DEFAULT);
                modifPass($_SESSION["user"],$pass);
                if($_SESSION["role"] !== "admin"){
                    header("LOCATION:index.php?action=accueil");
                }else{
                    header("LOCATION:index.php?action=admin");
                }    
            }
        }else{
            header("LOCATION:index.php?action=accueil"); 
        }
    break;
    
    case "ajoutProjet":
        if($_SESSION["verification"] == "oui" && (($_SESSION["role"] == "entreprise")|| ($_SESSION["role"] == "admin"))){
            $donnees3 = GetAllCategorie();
            require_once("vues/ajoutProjet.php");
        }else{
            header("LOCATION:index.php?action=accueil");
        }
    break;

    case "suppression":
    if($_SESSION["verification"] == "oui" && ($_SESSION["role"] == "admin")){
        if(deletePostuler($_GET["idProjet"])){    
            if(deleteProject($_GET["idProjet"] , $_SESSION["idUser"]) && ($_SESSION["role"] == "entreprise")){
                header("LOCATION:index.php?action=accueil");
            }else if(deleteProject2($_GET["idProjet"]) && ($_SESSION["role"] == "admin")){
                header("LOCATION:index.php?action=admin");
            }
        }
    }else{
        header("LOCATION:index.php?action=accueil");
    }
    break;

    case "insertionProjet":
    if(($_SESSION["verification"] == "oui") && (($_SESSION["role"] == "entreprise") ||
    ($_SESSION["role"] == "admin") )){
        $act = 1;
        if(addProjet($_POST["titre"] , $_POST["txt"] ,$act,$_SESSION["idUser"], $_POST["cat"])){
            $reponse="Projet ajouter avec Succès";
        }else{
            $reponse="une erreur s'est produite le projet n'a pas été ajouté";
        }
        $donnees3 = GetAllCategorie();
        require_once("vues/ajoutProjet.php");
    }else{
        header("LOCATION:index.php?action=accueil");
    }
    break;

    case "modifProjetAdmin":
        if(($_SESSION["verification"] == "oui") &&(($_SESSION["role"] == "admin") || ($_SESSION["role"] == "entreprise"))){
            if($_SESSION["role"] == "entreprise"){
                modifProject($_POST["titre"] , $_POST["txt"],$_POST["cat"],1, $_POST["idUtilisateur"] , $_POST["idProjet"]);
            }else{
                modifProject($_POST["titre"],$_POST["txt"],$_POST["cat"],$_POST["act"] , $_POST["idUtilisateur"] , $_POST["idProjet"]);
            }
            
            header("LOCATION:index.php?action=admin");
        }else{
            header("LOCATION:index.php?action=accueil");
        }
    break;

    case "postuler":
        if($_SESSION["verification"] == "oui" && ($_SESSION["role"] == "prestataire")){
            postUser($_SESSION["idUser"] , $_GET["idProjet"]);
            header("LOCATION:index.php?action=accueil");
        }
    break;
    
    case "admin":
        if(($_SESSION["verification"] == "oui") && ($_SESSION["role"] == "admin")){
            $donnees=GetAllProject();
            $donnees2= GetUser();
            $donnees3=getAllPostuler();
            require_once("vues/admin.php");
        }else{
            header("LOCATION:index.php?action=accueil");
        }
        
    break;
    case "modifierProjet":
        if(($_SESSION["verification"] == "oui") && (($_SESSION["role"] == "entreprise")||($_SESSION["role"] == "admin"))  && (is_numeric($_GET["idProjet2"]))){
            $donnees3 = GetAllCategorie();
            $donnees=GetProject2($_GET["idProjet2"]);
            require_once("vues/modifProjet.php");
        }else{
            if($_SESSION["role"] !== "admin" ){
                header("LOCATION:index.php?action=accueil");  
            }else{
                header("LOCATION:index.php?action=admin");  
            }
              
        }
    break;

    case "modifierEtatProjet":
        
        if(($_SESSION["verification"] == "oui") && (($_SESSION["role"] == "entreprise")||($_SESSION["role"] == "admin")) 
        && ( isset($_GET["etat"]) && is_numeric($_GET["etat"]) 
        && is_numeric($_GET["idProjet"]) && isset($_GET["idProjet"]))){
            echo "test le numéro du projet :" .$_GET["idProjet"] ;
            if($_GET["etat"] == 0){
                changerEtatProjet(1,$_GET["idProjet"]);
            }else if($_GET["etat"] == 1){
                changerEtatProjet(0,$_GET["idProjet"]);
            }
            if(($_SESSION["role"] == "entreprise")){
                header("LOCATION:index.php?action=accueil");
            }else{
                header("LOCATION:index.php?action=admin");
            }
        }else{
            header("LOCATION:index.php?action=accueil");  
        }
    break;

    case "suppressionCompte":
        if(($_SESSION["role"] == "admin") &&($_SESSION["verification"] == "oui")){
            deleteUser($_GET["idCompte"]);
            header("LOCATION:index.php?action=admin");
        }else{
            header("LOCATION:index.php?action=accueil");
        }
    break;

    case "etat":
        if(isset($_GET["idUti"]) && isset($_GET["idProjet"]) && ($_SESSION["role"]=="admin") && ($_SESSION["verification"]=="oui")){
            $idProjet=$_GET["idProjet"];
            $idUti=$_GET["idUti"];
            require_once("vues/etat.php");
        }else if($_SESSION["role"]!== "admin"){
            header("LOCATION:index.php?action=accueil");
        }else{
            header("LOCATION:index.php?action=accueil");    
        }
        
    break;
    case "changeEtat":
        if(($_SESSION["role"]=="admin") && ($_SESSION["verification"]=="oui") ){
            changeState($_POST["idProjet"],$_POST["idUti"],$_POST["state"]);
            changeStateNoUser($_POST["idProjet"],$_POST["idUti"],"non-octroyé");
            header("LOCATION:index.php?action=admin");
        }else{
            header("LOCATION:index.php?action=accueil");
        }
    break;
    case "etatUser":
        if(($_SESSION["verification"] == "oui") && ($_SESSION["role"] == "admin")){
            if(getStateUser($_GET["idUti"]) == 0){
                changeUserEtat($_GET["idUti"] , 1);
            }else if(getStateUser($_GET["idUti"]) == 1){
                changeUserEtat($_GET["idUti"] , 0);
            }
            header("LOCATION:index.php?action=admin");
        }else{
            header("LOCATION:index.php?action=profil");
        }
        
        
    break;

    case "deconnexion":
        session_destroy();
        header("LOCATION:index.php?action=accueil");
    break;
}



?>