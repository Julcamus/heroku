<?php
/*
            Code pour gérer la liste des actions suivantes : 
            -Ajouter un client
            -Modifier un client
            -Supprimer un client
        */

//require_once("../app/usine.php") 
require_once("../app/client.php");

if (isset($_POST)) {

  
    


    foreach ($_POST as $nom => $value) {
        $value = usine::gendarme($value);
    }

    extract($_POST);
    $verifier =   client::verifier_existence($type_client, $nom, $prenom, $nom_societe, $ip);

    if ($verifier == "data-base-error") {
        echo "data-base-connection-error";
    } else if ($verifier == "ip-no-exist") {
        if($telephone2 != ""){
            $telephone = $telephone1."/".$telephone2 ; 
        }
        else{
            $telephone = $telephone1 ; 
        }

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
                    $new_client->ajouter_client(time(),usine::gendarme($nom) , usine::gendarme($prenom), usine::gendarme($nom_societe) , usine::gendarme($ip),usine::gendarme($adresse),usine::gendarme($email),usine::gendarme($telephone), $type_client, $_FILES["piece"]["name"]);
                  
                    
                    echo "add-sucess";
                } else {
                    echo "reessayer-l-envoie";
                }
            }
        } /* end if pour charger les fichiers */
        else{
            
            $new_client = new client();
            $new_client->ajouter_client(time(),usine::gendarme($nom) , usine::gendarme($prenom), usine::gendarme($nom_societe), usine::gendarme($ip),usine::gendarme($adresse),usine::gendarme($email),usine::gendarme($telephone), $type_client,"");
            echo "add-sucess";
        }
    } else if ($verifier == "ip-exist") {
        echo "ip-exist";
    } else if ($verifier == "entreprise-exist") {
        echo "entreprise-existe";
    } else if ($verifier == "personnel-exist") {
        echo "personnel-existe";
    }
}
