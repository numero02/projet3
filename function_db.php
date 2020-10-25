<?php
    //connection à la base de données 
    function connectDB(){
        $c = mysqli_connect("localhost", "root", "", "enterpriseProject");
        //mysqli_connect("localhost", "e1895623", "0kL7tpXOMX15poAnWmfW", "e1895623");
        //mysqli_connect("localhost", "root", "", "enterpriseProject");
        if(!$c){
            trigger_error("Erreur de connexion... " . mysqli_connect_error());
        }
            
        mysqli_query($c, "SET NAMES 'utf8'");
        return $c;
    }
    
    $connexion = connectDB();
    
    
    // obtenir tous les projets
    function GetAllProject(){
        global $connexion;
        
        $requete ="SELECT * FROM projet";
        $resultat =mysqli_query($connexion,$requete);

        return $resultat;
    }
    // ajouter un memebre lors de l'inscription
    function AjoutMembre($nom,$numero,$rue,$ville,$pos,$pays,$courriel,$role,$user,$pass,$spec,$actif){
        
        global $connexion;
        
        $requete ="INSERT INTO utilisateur
        (nom,
        numero,
        rue,
        ville,
        codePostal,
        pays,
        courriel,
        role,
        username,
        password,
        specialite,
        actif) 
        VALUES('".filtre($nom)."',".filtre($numero).",'".filtre($rue)."','".filtre($ville)."','".filtre($pos)."','".filtre($pays)."','".filtre($courriel)."','".filtre($role)."','".filtre($user)."','".filtre($pass)."','".filtre($spec)."',".filtre($actif).")"; 
        $resultat =mysqli_query($connexion,$requete);
        /*
    VALUES(
            '$nom',
            '$numero'.",'".$rue."','".$ville."','".$pos."','".$pays."','".$courriel."','".$role."','".$user."','".$pass."','".$spec."',".$actif.")";
    */
    }

    // verifier les données rentré par l'utilisateur lors de la connexion
    function verification($user, $pass){
        global $connexion;
        
        $requete ="SELECT password FROM utilisateur WHERE username ='" . filtre($user) . "'"; 
        $resultat =mysqli_query($connexion,$requete);
        if($rangee= mysqli_fetch_assoc($resultat)){
            if(password_verify($pass ,$rangee["password"])){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    /* 
        verifier si le nom d'utilisateur existe dans la base de données 
        pour faire en sorte qu'il n'existe pas deux nom d'utilisateurs similaire 
        dans la base de données 
    */
    /************à revoir  */
    function verifUser($user){
        global $connexion;
        
        $requete ="SELECT id FROM utilisateur WHERE username= '".filtre($user)."'";
        $resultat =mysqli_query($connexion,$requete);

        if($rangee=mysqli_fetch_assoc($resultat)){

        }
        return $resultat;
    }

    function GetRole($user){
        
        global $connexion;
        
        $requete ="SELECT role FROM utilisateur WHERE username= '".filtre($user)."'";
        $resultat =mysqli_query($connexion,$requete);
        if($rangee=mysqli_fetch_assoc($resultat)){
            return $rangee["role"]; 
        }else{
            return false;
        }
    }
    // pour avoir toutes les catégorie et les rajouter dans un select dans la page Ajout article
    function GetAllCategorie(){
        global $connexion;
        
        $requete ="SELECT * FROM categorie";
        $resultat =mysqli_query($connexion,$requete);

        return $resultat;
    }

    /* fonction pour obtenir la catégorie pour un projet spécifique */
    
    function GetCategorie($id){
        global $connexion;
        
        $requete ="SELECT type FROM categorie 
        JOIN projet ON categorie.id = projet.id_categorie 
        AND projet.id=".filtre($id);
        $resultat =mysqli_query($connexion,$requete);

        return $resultat;
    }

    /*Obtenir des informations sur l'utilisateur authentifié pour la page profil */
    function infoUser($user){
        global $connexion;
        
        $requete ="SELECT * FROM utilisateur 
        where username='".filtre($user)."'";

        $resultat =mysqli_query($connexion,$requete);

        return $resultat;
    }
    /*pour obtenir toutes les informations sur un projet */
    function GetProjectId($id){
        global $connexion;
        
        $requete ="SELECT * FROM projet 
        WHERE id_utilisateur =".filtre($id);
        
        $resultat =mysqli_query($connexion,$requete);
        
        return $resultat;
    }
    function GetProject2($id){
        global $connexion;
        
        $requete ="SELECT * FROM projet WHERE id = ".filtre($id);
        $resultat =mysqli_query($connexion,$requete);
        
        return $resultat;
    }
    // supprimer un projet
    function deleteProject($id , $idUser){
        global $connexion;
        
        $requete ="DELETE FROM projet 
        WHERE id =".filtre($id) .
        " AND id_utilisateur =".filtre($idUser);
        $resultat =mysqli_query($connexion,$requete);
        if($resultat){
            return true;
        }else{
            return false;
        }
    }
    // pour ustilisateur admin on a pas besoin de l'id usager
    function deleteProject2($id){
        global $connexion;
        
        $requete ="DELETE FROM projet 
        WHERE id =".filtre($id);
        
        $resultat =mysqli_query($connexion,$requete);
        if($resultat){
            return true;
        }else{
            return false;
        }
    }
    /* 
    * supprimer dans la table postuler , afin de pouvoir supprimer les le projet , car sinon 
    * si y'a un projet que des prestataire ont déjà postuler ceci ne pourrait pas nous laisser 
    * supprimer le projet dans la table projet à cause d'une contrainte ajouté durant la création 
    * de la base de donnée
    */
    function deletePostuler($id){
        global $connexion;
        
        $requete ="DELETE FROM postuler WHERE id =".filtre($id);
        $resultat =mysqli_query($connexion,$requete);
        if($resultat){
            return true;
        }else{
            return false;
        } 
    }
    // ajouter un projet 
    function addProjet($titre , $txt ,$actif,$uti, $cat){
        global $connexion;
        
        $requete ="INSERT INTO projet(nom,description, actif , id_utilisateur,id_categorie)
        values('".filtre($titre)."','" . filtre($txt) . "',".filtre($actif).",".filtre($uti).",".filtre($cat).")";
        $resultat =mysqli_query($connexion,$requete);
        if($resultat){
            return true; 
        }else{
            return false;
        }
    }

    // modifier projet par l'utilisateur admin
    function modifProject($titre,$desc,$cat,$etat, $idUser , $idProject){
        global $connexion;
        
        $requete ="UPDATE projet SET 
        nom='".filtre($titre).
        "',description='"
        .filtre($desc).
        "',id_categorie=".
        filtre($cat).
        ",actif=".
        filtre($etat).
        " WHERE id_utilisateur=".
        filtre($idUser).
        " AND id=".
        filtre($idProject);

        $resultat =mysqli_query($connexion,$requete);
    }


    //mofidier le profil d'un utilisateur
    function modifProfil($username,$name,$email,$spec,$numero,$rue,$ville,$postal,$pays){
        
        global $connexion;
        
        $requete ="UPDATE utilisateur SET numero=".filtre($numero).",rue='".filtre($rue)."',ville='".filtre($ville)."',codePostal='".filtre($postal)."',pays='".filtre($pays)."',courriel='".filtre($email)."',nom='".filtre($name)."',specialite='".filtre($spec)."' WHERE username='".filtre($username)."'";
        $resultat =mysqli_query($connexion,$requete);
    }

    //fonction pour modifier le mot de passe
    function modifPass($user,$pass){
        global $connexion;
        
        $requete ="UPDATE utilisateur 
        SET password ='".filtre($pass).
        "' WHERE username ='".filtre($user)."'";
        $resultat =mysqli_query($connexion,$requete);
    }

    //fonction pour ajouter l'id du projet et l'id de l'utilisateur dans la table postuler
    function postUser($user , $post){
        global $connexion;
        
        $requete ="INSERT INTO postuler(id,id_utilisateur) 
        values(".filtre($post).",".filtre($user).")";
        $resultat =mysqli_query($connexion,$requete);
    }
    
    function GetAllEtatPost($id_usager , $id_projet){
        global $connexion;
        
        $requete ="SELECT * FROM postuler 
        WHERE id_utilisateur=".filtre($id_usager).
        " AND id =".filtre($id_projet);
        
        $resultat =mysqli_query($connexion,$requete);
        if($range= mysqli_fetch_assoc($resultat)){
            return $range["etat"];
        }else{
            return false;
        }
    }
    // obtenir des informations de la table utilisateur 
    function GetUser(){
        global $connexion;
        
        $requete ="SELECT * FROM utilisateur";
        $resultat =mysqli_query($connexion,$requete);
        return $resultat;
    }
    /* Supprimer un compte en utilisant le compte de l'admin */
    function deleteUser($id){
        global $connexion;
        
        $requete ="DELETE FROM utilisateur 
        WHERE id =".filtre($id);
        $resultat =mysqli_query($connexion,$requete);
    }
    // obtenir des informations sur la table postuler quis sera jointe à deux autres tables
    function GetAllPostuler(){
        global $connexion;
        
        $requete ="SELECT etat,
        projet.id AS idProjet ,
        utilisateur.id AS idUtilisateur,
        utilisateur.nom AS nomUsager ,
        projet.nom AS nomProjet
        FROM postuler JOIN utilisateur on 
        postuler.id_utilisateur = utilisateur.id 
        INNER JOIN projet ON
        postuler.id = projet.id";
        $resultat =mysqli_query($connexion,$requete);
        return $resultat;
    }
    /*
    $requete ="SELECT *,
        projet.id AS idProjet ,
        utilisateur.id AS idUtilisateur,
        utilisateur.nom AS nomUsager ,
        projet.nom AS nomProjet
        FROM postuler JOIN utilisateur on 
        postuler.id_utilisateur = utilisateur.id 
        INNER JOIN projet ON
        postuler.id = projet.id";
    */
    //changer les états du projets
    function changeState($idProjet,$idUtilisateur,$etat){
        global $connexion;
        
        $requete ="UPDATE postuler
                     SET etat = '".filtre($etat)."' 
                     WHERE id =".filtre($idProjet)." AND id_utilisateur =".filtre($idUtilisateur);
        $resultat =mysqli_query($connexion,$requete);
    }
    // pour non assigner le projet aux autres utilisateurs une fois que le projet a déjà été assigné
    function changeStateNoUser($idProjet,$idUtilisateur,$etat){
        global $connexion;
        
        $requete ="UPDATE postuler
                     SET etat = '".filtre($etat)."' 
                     WHERE id =".filtre($idProjet)." AND id_utilisateur !=".filtre($idUtilisateur);
        $resultat =mysqli_query($connexion,$requete);
    }
    
    //mettre l'état non octroyé pour un utilisateur qui veut postulé à un projet qui a déjà été octroyé à quelqu'un d'autre

    function changeEtatProjetOctroye($idProjet){
        global $connexion;
        
        $requete ="SELECT id FROM postuler 
        WHERE id=".filtre($idProjet).
        " AND etat = 'octroyé'";
        $resultat = mysqli_query($connexion,$requete);

        if($range=mysqli_fetch_assoc($resultat)){
            return true;
        }else{
            return false;
        }
    }



    //récupérer l'état du projet
    function etatProjet($idProjet){
        global $connexion;
        
        $requete ="SELECT actif FROM projet 
        WHERE id=".$idProjet;
        
        $resultat =mysqli_query($connexion,$requete);
        
        if($range=mysqli_fetch_assoc($resultat)){
            return $range["actif"];
        }else{
            return false;
        }
    }
    
    // activer ou désactiver un projet
    function changerEtatProjet($etat,$idProjet){
        global $connexion;
        
        $requete ="UPDATE projet
        SET actif = ".filtre($etat)." 
        WHERE id=".filtre($idProjet);
        $resultat =mysqli_query($connexion,$requete);
    }
    // fonction pour rendre actif ou non un utilisateur
    function changeUserEtat($idUser , $etat){
        global $connexion;
        
        $requete ="UPDATE utilisateur
        SET actif = ".filtre($etat)." 
        WHERE id=".filtre($idUser);
        $resultat =mysqli_query($connexion,$requete);
    }
    // fonction pour récupérer l'information si un tulisateur est actif ou non 
    function getStateUser($idUser){
        global $connexion;
        $requete="SELECT actif FROM utilisateur WHERE id=". $idUser;
        $resultat =mysqli_query($connexion,$requete);
        if($range=mysqli_fetch_assoc($resultat)){
            return $range["actif"];
        }else{
            return false;
        }
    }
    // fonction pour vérifier si l'utilisateur est actif ou non pour lui bloquer l'accès du site 
    function userActif($userName){
        global $connexion;
        
        $requete="SELECT actif FROM utilisateur 
        WHERE username='". filtre($userName)."'";
        
        $resultat =mysqli_query($connexion,$requete);
        
        if($range=mysqli_fetch_assoc($resultat)){
            return $range["actif"];
        }else{
            return false;
        }
    }

    /*pour protéger le site */
    function filtre($var)
    {
        global $connexion;
        
        $varFiltre = mysqli_real_escape_string($connexion, $var);
        $varFiltre = strip_tags($varFiltre, "<a><b><em>");
        
        return $varFiltre;
    }


    
?>