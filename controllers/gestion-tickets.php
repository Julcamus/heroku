<?php   

// Code de gestion des traitements liés a la page de gestion de tickets

require_once("../app/tickets.php");

$liste_des_clients = array();
$liste_des_abonnements = array() ;
$info_clients = array() ;  

if (isset($_POST) && !empty($_POST)) {
       
        foreach ($_POST as $nom => $value) {
            $value = usine::gendarme($value);
        }
    
        if($_POST["action"] =="ouvrir_ticket"){ 
            print_r($_POST) ; 
            print_r($_FILES) ;
            extract($_POST) ; 
             
            
            if ($_FILES['capture']['name'] != '') {
                
                $upload_error = " ";
                $target_dir = "../capture_ticket/";
                $target_file = $target_dir . basename($_FILES["capture"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
                // Check if image file is a actual image or fake image
    
               
    
                // Check if file already exists
                if (file_exists($target_file)) {
                    $upload_error = "file-exist";
                    $uploadOk = 0;
                    
                }
    
                // Check file size
                if ($_FILES["capture"]["size"] > 5000000000) {
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
                    
                } 
                else 
                {
                    if (move_uploaded_file($_FILES["capture"]["tmp_name"], $target_file)) {
                        echo time()."-----".usine::gendarme($libelle)."-----".$categorie."-----".$client."-----".usine::gendarme($description)."-----".$_FILES["capture"]["name"]."-----".$id_ouvrant ; 
                        ticket::ouvrir_ticket(time(),usine::gendarme($libelle),'ffdggf',$client,usine::gendarme($description),$_FILES["capture"]["name"],$id_ouvrant) ;

                       // $date, $libelle, $categorie,$id_client, $description, $photo, $id_technicien
                    } 
                    else {
                        echo "reessayer-l-envoie";
                    }
                }
            }
        }
    
    
    } // END IF GENERAL


?>
