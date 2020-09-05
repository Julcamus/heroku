<?php
/*
        Les instructions contenu dans ce code consistent : 
        - A faire le traitement concernant la modification des informations des clients 
          lorsqu'on clique sur le boutton "Enrégistrer les modifications" contenu dans le 
          modal de modification
                    

*/
//require_once("../app/usine.php") 
require_once("../app/client.php");

if (isset($_POST)) {

 
    foreach ($_POST as $nom => $value) {
        $value = usine::gendarme($value);
    }

    extract($_POST);
   // $verifier =   client::verifier_existence($type_client, $nom, $prenom, $nom_societe, $ip);

    $connection = usine::lancer_une_connection() ; 
    if( $connection == "data-base-connection-error"){
        $verifier = "data-base-error" ; 
    }
    else{
        $requette = $connection->prepare("SELECT id FROM client WHERE ip=? ") ;
        $requette->execute([$ip]) ; 
        $reponse = $requette->fetch() ;
        $verifier = "favorable" ; 
        if($reponse != NULL && $reponse["id"] != $id_client){
            $verifier =  "ip-utilise" ; 
        }

        if($type_client == "entreprise"){
            $requette = $connection->prepare("SELECT id FROM client WHERE nom_societe = ? ") ;
            $requette->execute([$nom_societe]) ; 
            $reponse = $requette->fetch() ;
            if($reponse != NULL && $reponse["id"] != $id_client){
                $verifier = "nom-societe-utilise" ; 
            }
        }


        if($type_client == "personnel"){
            $requette = $connection->prepare("SELECT id FROM client WHERE nom = ? AND prenom=? ") ;
            $requette->execute([$nom,$prenom]) ; 
            $reponse = $requette->fetch() ;
            if($reponse != NULL && $reponse["id"] != $id_client){
                $verifier =  "nom-prenom-utilise" ; 
            }
        }



    }

    if ($verifier == "data-base-error") {
        echo "data-base-connection-error";
    } else if ($verifier == "favorable") {

        if ($_FILES['piece']['name'] != '') {

            $upload_error = " ";
            $target_dir = "../piece_client/";
            $target_file = $target_dir . basename($_FILES["piece"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image

            

            // Check if file already exists
            if (file_exists($target_file)) {
                $upload_error = "file-exist";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["piece"]["size"] > 5000000000) {
                $upload_error = "fichier-trop-volumineux";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if (
                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != ""
            ) {
                $upload_error = "format-non-pris-en-charge";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo $upload_error;
            } else {
                if (move_uploaded_file($_FILES["piece"]["tmp_name"], $target_file)) {
                    
                    $new_client = new client();
                    $new_client->modifier_client($id_client, usine::gendarme($nom) , usine::gendarme($prenom), usine::gendarme($nom_societe), usine::gendarme($ip),usine::gendarme($adresse),usine::gendarme($email),usine::gendarme($telephone), $type_client, $_FILES["piece"]["name"]) ;
                    
                    echo "add-sucess";
                } else {
                    echo "reessayer-l-envoie";
                }
            }
        } /* end if pour charger les fichiers */
        else{
            $new_client = new client();
            $new_client->modifier_client2($id_client, usine::gendarme($nom) , usine::gendarme($prenom), usine::gendarme($nom_societe), usine::gendarme($ip),usine::gendarme($adresse),usine::gendarme($email),usine::gendarme($telephone), $type_client) ; 
            echo "add-sucess";
        }
    } else if ($verifier == "ip-utilise") {
        echo "ip-utilise";
    } else if ($verifier == "nom-societe-utilise") {
        echo "nom-societe-utilise";
    } else if ($verifier == "nom-prenom-utilise") {
        echo "nom-prenom-utilise";
    }
}
