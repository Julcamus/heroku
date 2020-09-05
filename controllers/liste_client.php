<?php
/*
        Les instructions contenu dans ce code consistent : 
        - A aller chercher les informations d'un client donné lorsque qu'on clique
          sur le boutton modifier puis les renvoyés au code liste_client.js qui sera chargé de les utiliser pour remplir les modaux
        - supprimer un client           

*/


require("../app/usine.php") ; 


if(isset($_POST)){
    foreach ($_POST as $nom => $value) {
        $value = usine::gendarme($value);
    }

    if($_POST["action"] == "modifier" || $_POST["action"] == "afficher" || $_POST["action"] == "supprimer" ){
   
    extract($_POST) ; 
    $connection = usine::lancer_une_connection() ;

    if($connection != "data-base-connection-error"){
        $requette_get_info = $connection->prepare("SELECT * FROM client WHERE id=? ");
        $requette_get_info->execute([$id]) ; 
        $resultat = $requette_get_info->fetch() ; 
       
        echo $resultat["id"].",".$resultat["date_enregistrement"].",".$resultat["nom"].",".$resultat["prenom"].",".$resultat["nom_societe"].",".$resultat["ip"].",".$resultat["adresse"].",".$resultat["email"].",".$resultat["numero"].",".$resultat["type_client"] ;
         
    }

    else{
        echo "error" ;
    }
    

    }
    else if($_POST["action"] == "confirmer_supprimer"){

         extract($_POST) ; 
        $connection = usine::lancer_une_connection() ;
       
         if($connection != "data-base-connection-error"){
        $requette_get_info = $connection->prepare("DELETE  FROM client WHERE id=? ");

        $requette_get_info->execute([$id]) ; 

       
        echo "le client est supprimé" ;
        
    }

    else{
        echo "error" ;
    }

    }
    
    
}






//$requette_afficher_infos = 



