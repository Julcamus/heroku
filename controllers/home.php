<?php
/*
        Les instructions contenu dans ce code consistent : 
        - A gerer toutes les opérations éffectués sur la home page
          
*/
require("../app/usine.php");


if (isset($_POST)) {

	foreach ($_POST as $nom => $value) {
		$value = usine::gendarme($value);
	}

	if($_POST["action"] =="envoie_mail"){
		echo "je suis cliqué";
	extract($_POST) ; 
	echo "cool" ; 
	echo $message ; 
	$to="julioakouete12@gmail.com" ; 
	$subject = 'Via info ';
	$from = 'julioledeveloppeur@gmail.com';
	//$reply =;
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Create email headers
	$headers .= 'From: '.$from."\r\n".
		'Reply-To: '.$from."\r\n" .
		'X-Mailer: PHP/' . phpversion();


 // Sending email
 if(mail($to, $subject, $message, $headers)){
	 echo "envoyé" ; 
 }
 else{ 
	 echo "non envoyé" ;
 }
	}



	if ($_POST["action"] == "trouver_montant") {
		extract($_POST);

		$connection = usine::lancer_une_connection();

		if ($connection != "data-base-connection-error") {
			$montant_abonnement = $connection->prepare("SELECT id,montant FROM abonnement WHERE lib_abonnement=? ");
			$montant_abonnement->execute([$libelle_abonnement]);
			$resultat = $montant_abonnement->fetch();

			echo $resultat["id"] . "," . $resultat["montant"];
		} else {
			echo "error";
		}
	}


	if ($_POST["action"] == "enregistrer_abonnement") {
		extract($_POST);

		$liste_client = explode(",", $clients);
		$separateur = '/ /';
		for ($i = 0; $i < count($liste_client); $i++) {
			$connection = usine::lancer_une_connection();
			
			if ($connection != "data-base-connection-error") {
				if (preg_match($separateur, $liste_client[$i])) {
					// le cas ou le client est de type personnele
					$info_client = explode(" ", $liste_client[$i]);
					$requette_id = $connection->prepare("SELECT id FROM client WHERE nom = ? AND prenom= ?");
					$requette_id->execute([$info_client[0], $info_client[1]]);
					$id_client = $requette_id->fetch();
					//$id_client = $id_client["id"] ;
					
					
				} else {

					// le cas ou le client est de type entreprise
					$requette_id = $connection->prepare("SELECT id FROM client WHERE nom_societe = ?");
					$requette_id->execute([$liste_client[$i]]);
					$id_client = $requette_id->fetch();
					//$id_client = $id_client["id"] ; 
				}




				$montant_total = $montant_mensuel * $duree;
				$date_debut = time();
				$date_fin = time() + 2592000;
				

				$enregistrer_abonnement = $connection->prepare("INSERT INTO abonner(client_id,abonnement_id,montant_mensuel,montant_total,date_debut,date_fin,status_payement) VALUES(?,?,?,?,?,?,?)  ");
				$enregistrer_abonnement->execute([$id_client["id"], $id_abonnement, $montant_mensuel, $montant_total, $date_debut, $date_fin,"non_solde"]);
				$get_abonnement_id = $connection->query("SELECT MAX(id) FROM abonner ");
				$id_abonnement_nouveau = $get_abonnement_id->fetch() ; 
				// 	update status clients

				$change_status_requette = $connection->prepare("UPDATE client SET status= 'debiteur' WHERE id = ? ") ;
				$change_status_requette->execute([$id_client["id"]]) ; 
				
				if ($montant_remis != 0) {
					$enregistrer_payement = $connection->prepare("INSERT  INTO  payements(date_payement,id_client,id_abonner,montant_du,montant_paye,montant_restant) VALUES(?,?,?,?,?,?)  ");
					$enregistrer_payement->execute([time(),$id_client["id"],$id_abonnement_nouveau["MAX(id)"],$montant_total,$montant_remis,$montant_total - $montant_remis]);
					
					if($montant_total - $montant_remis == 0){
						
						$update_status_payement = $connection->prepare("UPDATE abonner SET status_payement = ? WHERE id = ? ");
						$update_status_payement->execute(["solde",$id_abonnement_nouveau["MAX(id)"]]);

					}
					
				
				} 	


				
				echo "enregistrer" ; 
			} else {
				echo "error";
			}

		}
	}



if($_POST["action"] == "add_new_type_abonnement"){
	foreach ($_POST as $nom => $value) {
		$value = usine::gendarme($value);
	}
	extract($_POST) ; 
	$connection = usine::lancer_une_connection();
	if ($connection != "data-base-connection-error"){
		$requette = $connection->prepare("INSERT INTO abonnement(lib_abonnement,debit,montant) VALUES(?,?,?)") ; 
		$requette->execute([$libelle,$debit,$montant_mensuel]) ;
		$requette2 = $connection->query("SELECT MAX(id) FROM abonnement ");
		$id_abonnement_nouveau = $requette2->fetch() ; 
		echo $id_abonnement_nouveau["MAX(id)"] ; 
		
	}
	else{
		echo "error" ; 
	}

}


if($_POST["action"] == "get_info_abonnement_en_cours"){
	foreach ($_POST as $nom => $value) {
		$value = usine::gendarme($value);
	}
	extract($_POST) ; 
	$connection = usine::lancer_une_connection();
	if ($connection != "data-base-connection-error") {
		
		$abonnement_en_cours_info = $connection->prepare("SELECT MAX(id) FROM abonner WHERE client_id = ?") ; 
		$abonnement_en_cours_info->execute([$client]) ;
		$reponse = $abonnement_en_cours_info->fetch() ; 
		$max_id =  $reponse["MAX(id)"] ; 
		
		$abonnement_en_cours_info = $connection->prepare("SELECT abonnement_id,date_fin FROM abonner WHERE id = ?") ; 
		$abonnement_en_cours_info->execute([ $max_id]) ;
		$reponse = $abonnement_en_cours_info->fetch() ;
		$abonnement_id = $reponse["abonnement_id"] ;
		$date_fin = $reponse["date_fin"]  ;
		$id_abonnement = $reponse["abonnement_id"] ;

		//echo $id_abonnement."," ;
		//echo $date_fin.","; 

		$lib_abonnement_en_cours = $connection->prepare("SELECT  lib_abonnement ,montant FROM abonnement WHERE id = ?") ; 
		$lib_abonnement_en_cours->execute([$id_abonnement]) ;
		$reponse = $lib_abonnement_en_cours->fetch() ;
		echo $reponse["lib_abonnement"]."," ;  
		$nombre_jour_restant = ($date_fin - time() )/86400 ; 
		echo round($nombre_jour_restant)  ; 
		
		 
	} else {
		echo "error";
	}

}

if($_POST["action"] == "get_abonnement_montant"){
	extract($_POST) ; 
	$connection = usine::lancer_une_connection();
	if ($connection != "data-base-connection-error"){
		$requette = $connection->prepare("SELECT   montant FROM abonnement WHERE id = ?") ;
		$requette->execute([$id]) ; 
		$resultat = $requette->fetch() ; 
		echo round($resultat["montant"]/30)  ; 
	}
	else{
		echo "error" ;  
		}
}



if($_POST["action"] == "modifier_offre_actuelle"){
	extract($_POST) ; 
	$connection = usine::lancer_une_connection();
	if ($connection != "data-base-connection-error"){
		$date_debut = time() ; 
		$date_fin = time() + (86400*$nombre_jours_restant) ;

		
		$enregistrer_abonnement = $connection->prepare("INSERT INTO abonner(client_id,abonnement_id,montant_mensuel,montant_total,date_debut,date_fin) VALUES(?,?,?,?,?,?)  ");
		$enregistrer_abonnement->execute([$client, $abonnement,0, $montant_total, $date_debut, $date_fin]);
		$get_abonnement_id = $connection->query("SELECT MAX(id) FROM abonner ");
		$id_abonnement_nouveau = $get_abonnement_id->fetch() ;

		$change_status_requette = $connection->prepare("UPDATE client SET status= 'debiteur' WHERE id = ? ") ;
		$change_status_requette->execute([$client]) ; 

		if ($montant_paye != 0) {
			$enregistrer_payement = $connection->prepare("INSERT  INTO  payements(date_payement,id_client,id_abonner,montant_du,montant_paye,montant_restant) VALUES(?,?,?,?,?,?)  ");
			$enregistrer_payement->execute([time(),$client,$id_abonnement_nouveau["MAX(id)"],$montant_total,$montant_paye,$montant_total - $montant_paye]);
			
			if($montant_total - $montant_paye == 0){
				
				$update_status_payement = $connection->prepare("UPDATE abonner SET status_payement = ? WHERE id = ? ");
				$update_status_payement->execute(["solde",$id_abonnement_nouveau["MAX(id)"]]);

			}
		
		
		} 

		

		
		echo "enregistrer" ; 
	}
	else{
		echo "error" ;  
		}
}




if($_POST["action"] == "enregistrer_frais_installation"){
	foreach ($_POST as $nom => $value) {
		$value = usine::gendarme($value);

	}
	extract($_POST) ; 
	$liste_client = explode(",", $clients);
		$separateur = '/ /';
		for ($i = 0; $i < count($liste_client); $i++) {
			$connection = usine::lancer_une_connection();
			echo $liste_client[$i] ; 
			if ($connection != "data-base-connection-error") {
				if (preg_match($separateur, $liste_client[$i])) {
					// le cas ou le client est de type personnele
					echo $liste_client[$i] ; 
					$info_client = explode(" ", $liste_client[$i]);
					echo $info_client[0] ;
					echo $info_client[1] ;  
					$requette_id = $connection->prepare("SELECT id FROM client WHERE nom = ? AND prenom= ?");
					$requette_id->execute([$info_client[0], $info_client[1]]);
					$id_client = $requette_id->fetch();
					$id_client = $id_client["id"] ;
					echo  $id_client ; 
					
				} else {

					// le cas ou le client est de type entreprise
					$requette_id = $connection->prepare("SELECT id FROM client WHERE nom_societe = ?");
					$requette_id->execute([$liste_client[$i]]);
					$id_client = $requette_id->fetch();
					$id_client = $id_client["id"] ; 
				}
				
				

				
				$enregistrer_frais= $connection->prepare("INSERT INTO  frais_installation(date_operation,identifiant_client,montant,status_payement) VALUES(?,?,?,?)  ");
				$enregistrer_frais->execute([time(),$id_client,$montant,"non_solde"]);
				
				$change_status_requette = $connection->prepare("UPDATE client SET status= 'debiteur' WHERE id = ? ") ;
				$change_status_requette->execute([$id_client]) ; 
				
				if ($montant_paye != 0) { 
					
					$get_frais_installation_id = $connection->query("SELECT MAX(id) FROM frais_installation ");
					$id_frais_installation = $get_frais_installation_id->fetch() ;
					$enregistrer_payement = $connection->prepare("INSERT  INTO  payements(date_payement,id_client,id_frais_installation,montant_du,montant_paye,montant_restant) VALUES(?,?,?,?,?,?)  ");
					$enregistrer_payement->execute([time(),$id_client,$id_frais_installation["MAX(id)"],$montant,$montant_paye,$montant - $montant_paye]);
					
					if($montant - $montant_paye == 0){
						
						$update_status_payement = $connection->prepare("UPDATE frais_installation SET status_payement = ? WHERE id = ? ");
						$update_status_payement->execute(["solde",$id_frais_installation["MAX(id)"]]);

					}
				
				
				} 

				
				echo "enregistrer" ; 
				} else {
				echo "error";
			}

		}
		
}	




if($_POST["action"] == "get_client_dette"){
	
	$connection = usine::lancer_une_connection();
	if ($connection != "data-base-connection-error"){
		extract($_POST); 
		$liste_dettes = array() ;
		$dettes_frais_installation = $connection->prepare("SELECT  id ,date_operation, montant FROM  frais_installation WHERE identifiant_client = ?  AND status_payement = 'non_solde' ") ; 
		$dettes_frais_installation->execute([$id_client]) ;
		while($reponse = $dettes_frais_installation->fetch()){
            
			$date = getdate($reponse["date_operation"]) ;
			$date_chaine = $date["mday"] . "/" . $date["mon"] . "/" . $date["year"];
            
            
	
			$requette_montant_restant = $connection->prepare("SELECT  SUM(montant_paye) FROM payements WHERE id_client = ? AND id_frais_installation = ? ") ; 
			$requette_montant_restant->execute([$id_client, $reponse["id"]]) ; ; 
            $montant_restant = $requette_montant_restant->fetch() ;
            
            if($montant_restant["SUM(montant_paye)"] == ""){
                $restant = "vide" ; 
            } 
            else{
                $restant = $montant_restant["SUM(montant_paye)"] ; 
            }      
            
	
			$libelle_dette = "Frais d'installation éfféctué le ".$date_chaine ;
			$code=$reponse["id"]."-".$reponse["montant"]."-".$restant."-installation" ; 
			
			$liste_dettes[] = [
				"code" => $code,
				"libelle" => $libelle_dette ,
				"date" => $date_chaine
			] ; 
		}
		 ; 
	
	
		$dettes_abonnement_requette = $connection->prepare("SELECT  id ,montant_total,abonnement_id,date_debut,date_fin  FROM  abonner WHERE client_id = ? AND status_payement = ?") ; 
		$dettes_abonnement_requette->execute([$id_client , "non_solde"]) ;
		 
		while($reponse = $dettes_abonnement_requette->fetch()){
		   
			
			$date_debut = getdate($reponse["date_debut"]);
			$date_debut_chaine = $date_debut["mday"] . "/" . $date_debut["mon"] . "/" . $date_debut["year"];
	
			$date_fin = getdate($reponse["date_fin"]);
			$date_fin_chaine = $date_fin["mday"] . "/" . $date_fin["mon"] . "/" . $date_fin["year"];
	
			$requette_abonnement_libelle = $connection->prepare("SELECT lib_abonnement FROM abonnement WHERE id = ?") ; 
			$requette_abonnement_libelle->execute([$reponse["abonnement_id"]]) ;
			$lib_abonnement = $requette_abonnement_libelle->fetch() ; 
	
			$requette_montant_restant = $connection->prepare("SELECT  SUM(montant_paye) FROM payements WHERE id_client = ? AND id_frais_installation = ? ") ; 
			$requette_montant_restant->execute([$id_client,$reponse["id"]]) ; 
            $montant_restant = $requette_montant_restant->fetch() ;
            

            if($montant_restant["SUM(montant_paye)"] == ""){
                $restant = "vide" ; 
            } 
            else{
                $restant = $montant_restant["SUM(montant_paye)"] ; 
            }  
		   
			
			$libelle_dette = $lib_abonnement["lib_abonnement"]."  pour la durée du ".$date_debut_chaine." au ".$date_fin_chaine;
			$code=$reponse["id"]."-".$reponse["montant_total"]."-".$restant."-abonnement" ; 
			$liste_dettes[] = [
	
					"code" => $code ,
					"libelle" => $libelle_dette,
					"date" => $date_debut_chaine
			] ; 

		   
		}
		 ; 
		 	
            echo json_encode($liste_dettes) ; 
          
		}
		else{
			echo "error" ; 
		}
	
	
}






if($_POST["action"] =="get_client_info"){
	extract($_POST) ;
	$connection = usine::lancer_une_connection();
	if ($connection != "data-base-connection-error"){
    
        if($type_dette =='abonnement'){
            $dettes_abonnement_requette = $connection->prepare("SELECT abonnement_id, date_debut,date_fin  FROM  abonner WHERE id =? ") ; 
            $dettes_abonnement_requette->execute([$id_dette ]) ;
            $reponse1 = $dettes_abonnement_requette->fetch() ;
              

            $get_lib_abonnement= $connection->prepare("SELECT lib_abonnement  FROM  abonnement WHERE id = ? ") ; 
            $get_lib_abonnement->execute([$reponse1['abonnement_id'] ]) ;
            $reponse2 = $get_lib_abonnement->fetch() ;
           

            $date_debut = getdate($reponse1["date_debut"]);
            $date_debut_chaine = $date_debut["mday"] . "/" . $date_debut["mon"] . "/" . $date_debut["year"];
            
            $date_fin = getdate($reponse1["date_fin"]);
			$date_fin_chaine = $date_fin["mday"] . "/" . $date_fin["mon"] . "/" . $date_fin["year"];


            $info_utile['lib_dette'] = $reponse2["lib_abonnement"]."  du  ".$date_debut_chaine." au  ".$date_fin_chaine ; 
            


        }
        elseif($type_dette =='installation'){
            $info_utile['lib_dette']= "vide" ; 
        }

        $info_requette = $connection->prepare("SELECT * FROM client WHERE id=?  ") ;
		$info_requette->execute([$id_client]) ;
		$resultat = $info_requette->fetch() ; 
		if($resultat['type_client']=="entreprise"){
			$info_utile['identifiant'] =  $resultat["nom_societe"] ; 
		}
		elseif($resultat['type_client']=="personnel"){
            $info_utile['identifiant'] =   $resultat["nom"]."  ".$resultat["prenom"]  ; 
        }
        
        echo json_encode($info_utile) ; 

}
else{

    echo "error" ; 

}

}



if($_POST["action"] == "save_payement"){
	extract($_POST) ; 
	 echo $id_client."- <br> ".$id_dette."- <br>".$montant_restant ."- <br>".$montant_restant."- <br>".$montant_paye."- <br> ".$type_dette ; 
	$connection = usine::lancer_une_connection();
	if ($connection != "data-base-connection-error"){
        if($type_dette == "abonnement"){
            $save_payement = $connection->prepare("INSERT INTO payements(date_payement,id_client,id_abonner,montant_du,montant_paye,montant_restant) VALUES (?,?,?,?,?,?)" ); 
            $save_payement->execute([time(),$id_client,$id_dette,$montant_restant,$montant_paye,$montant_restant-$montant_paye]) ; 

            if($montant_restant - $montant_paye == 0 ){
               
                $update_stutus = $connection->prepare("UPDATE abonner SET status_payement = ? WHERE  id = ?") ; 
                $update_stutus->execute(["solde",$id_dette]) ; 

            }

            $dettes_client = array() ;
            
            $dette_abonnements = $connection->prepare("SELECT id FROM abonner WHERE  client_id = ? AND status_payement = 'non_solde' ") ; 
            $dette_abonnements->execute([$id_client]) ;
            while( $reponse = $dette_abonnements->fetch()){
                $dettes_client[] =$reponse['id']  ; 
            }
            $dette_installation = $connection->prepare("SELECT id FROM frais_installation WHERE  client_id = ?  AND status_payement = 'non_solde' ") ; 
            $dette_installation->execute([$id_client]) ;
            while( $reponse = $dette_installation->fetch()){
                $dettes_client[] =$reponse['id']  ; 
            }

            $tatus_payement = "" ; 
            $requette_status = $connection->prepare("SELECT status FROM client WHERE id = ?") ;
            $requette_status->execute([$id_client]) ; 
            $resultat = $requette_status->fetch()["status"] ; 
            

            if(count($dettes_client) == 0 && $resultat == "couper" ){
                $update_requette = $connection->prepare("UPDATE client SET status = ? WHERE id = ?") ; 
                $update_requette->execute(["regulier",$id_client]) ; 
            }
            
        }

        elseif($type_dette == "installation"){

            $save_payement = $connection->prepare("INSERT INTO payements(date_payement,id_client,id_frais_installation,montant_du,montant_paye,montant_restant) VALUES (?,?,?,?,?,?)" ); 
            $save_payement->execute([time(),$id_client,$id_dette,$montant_restant,$montant_paye,$montant_restant-$montant_paye]) ; 

            if($montant_restant - $montant_paye == 0 ){
                $update_stutus = $connection->prepare("UPDATE frais_installation SET status_payement = ? WHERE  id = ?") ; 
                $update_stutus->execute(["solde",$id_dette]) ; 

            }

            $dettes_client = array() ;
            
            $dette_abonnements = $connection->prepare("SELECT id FROM abonner WHERE  client_id = ? AND status_payement = 'non_solde' ") ; 
            $dette_abonnements->execute([$id_client]) ;
            while( $reponse = $dette_abonnements->fetch()){
                $dettes_client[] =$reponse['id']  ; 
            }
            $dette_installation = $connection->prepare("SELECT id FROM frais_installation WHERE  client_id = ?  AND status_payement = 'non_solde' ") ; 
            $dette_installation->execute([$id_client]) ;
            while( $reponse = $dette_installation->fetch()){
                $dettes_client[] =$reponse['id']  ; 
            }

            $tatus_payement = "" ; 
            $requette_status = $connection->prepare("SELECT status FROM client WHERE id = ?") ;
            $requette_status->execute([$id_client]) ; 
            $resultat = $requette_status->fetch()["status"] ; 
           

            if(count($dettes_client) == 0 && $resultat == "couper" ){
                $update_requette = $connection->prepare("UPDATE client SET status = ? WHERE id = ?") ; 
                $update_requette->execute(["regulier",$id_client]) ; 
            }
        }

        echo 'enregistrer' ; 
}
else{
    echo "error" ; 
}

}




if($_POST["action"] == "debloquer_client"){
	$client_coupes = array() ; 
	extract($_POST) ; 
	$connection = usine::lancer_une_connection();
	if ($connection != "data-base-connection-error"){
        
	   $update_requette = $connection->prepare("UPDATE client SET status = 'debiteur' WHERE id=? ") ; 
	   $update_requette->execute([$id_client]) ;
	   
	   $liste_client_bloque = $connection->query("SELECT id, nom,prenom,nom_societe,type_client FROM client WHERE status ='couper'") ;
	   $reponse = $liste_client_bloque->fetchAll() ; 

	   foreach($reponse as $un_client){
			if($un_client["type_client"] ==  "personnel"){
				$identifiant = $un_client["nom"]." ".$un_client["prenom"] ;
				$client_coupes[] = [
					"identifiant" => $identifiant ,
					"id" => $un_client["id"]
				] ;  
			}
			elseif($un_client["type_client"] ==  "entreprise"){
				$identifiant = $un_client["nom_societe"] ;
				$client_coupes[] = [
					"identifiant" => $identifiant ,
					"id" => $un_client["id"]
				] ;  
			}

	   }

	  	
	
		echo json_encode($client_coupes) ; 
	}
else{
    echo "error" ; 
	}

}






if($_POST["action"] == "bloquer_client"){
	$client_coupes = array() ; 
	extract($_POST) ;
	$clients = explode(",", $clients); 
	$connection = usine::lancer_une_connection();
	if ($connection != "data-base-connection-error"){
	for($i = 0 ; $i< count($clients) ; $i++){
		
	   $update_requette = $connection->prepare("UPDATE client SET status = 'couper' WHERE id=? ") ; 
	   $update_requette->execute([$clients[$i]]) ;
	   }
      

	   $liste_client_bloque = $connection->query("SELECT id, nom,prenom,nom_societe,type_client FROM client WHERE status ='couper'") ;
	   $reponse = $liste_client_bloque->fetchAll() ; 

	   foreach($reponse as $un_client){
			if($un_client["type_client"] ==  "personnel"){
				$identifiant = $un_client["nom"]." ".$un_client["prenom"] ;
				$client_coupes[] = [
					"identifiant" => $identifiant ,
					"id" => $un_client["id"]
				] ;  
			}
			elseif($un_client["type_client"] ==  "entreprise"){
				$identifiant = $un_client["nom_societe"] ;
				$client_coupes[] = [
					"identifiant" => $identifiant ,
					"id" => $un_client["id"]
				] ;  
			}

	   }
	      
	echo json_encode($client_coupes) ; 
	}
else{
    echo "error" ; 
	}

}



















/*if($_POST["action"] == "envoie_mail"){
	echo "je suis cliqué";
	extract($_POST) ; 
	echo "cool" ; 
	echo $message ; 
	$to="julioakouete12@gmail.com" ; 
	$subject = 'Via info ';
	$from = 'julioledeveloppeur@gmail.com';
	//$reply =;
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Create email headers
	$headers .= 'From: '.$from."\r\n".
		'Reply-To: '.$from."\r\n" .
		'X-Mailer: PHP/' . phpversion();
}

 // Sending email
 if(mail($to, $subject, $message, $headers)){
	 echo "envoyé" ; 
 }
 else{ 
	 echo "non envoyé" ;
 }

}*/
}

