<?php
require("app/usine.php");
$liste_des_proches = array();
$liste_des_abonnements = array() ;
$info_clients = array() ;  

$connection = usine::lancer_une_connection();

if ($connection == "data-base-connection-error") { 
  
  echo "error" ; 


}
else{
    $liste_des_proches = array();
    $liste_date_fin_requette = $connection->prepare("SELECT id,client_id , date_fin FROM abonner WHERE date_fin > ?  AND date_fin < ? ") ;
    $liste_date_fin_requette->execute([time()-(86400*5),time() + (86400*5)]) ;
    
    //$liste_date_fin_requette = $connection->query("SELECT  date_fin FROM abonner  ") ;
  
    $reponse = $liste_date_fin_requette->fetchAll() ; 
    foreach($reponse as $element){
        $date = getdate(time()) ;
        $aujourdhui = $date["mday"] . "-" . $date["mon"] . "-" . $date["year"];
        
        $date = getdate($element["date_fin"]) ;
		$date_fin = $date["mday"] . "-" . $date["mon"] . "-" . $date["year"];
        
        $identifiant_requette = $connection->prepare("SELECT nom,prenom,nom_societe,type_client FROM client WHERE id = ?") ; 
        $identifiant_requette->execute([$element["client_id"]]) ; 
        $reponse2 = $identifiant_requette->fetch() ; 
        if($reponse2["type_client"] ==  "personnel"){
            $identifiant = $reponse2["nom"]." ".$reponse2["prenom"] ; 
        }
        elseif($reponse2["type_client"] ==  "entreprise"){
            $identifiant = $reponse2["nom_societe"] ;
        }
       
        if($date_fin < $aujourdhui ){
            $jour = round(abs((time() - $element['date_fin'])/86400 ))   ;
            $liste_des_proches [] = [
                 "jour" => $jour ,
                 "status"  => "passe",
                 "identifiant" =>$identifiant
                  
            ] ; 
           
        }
        elseif($date_fin > $aujourdhui){
            $jour = round(abs((time() - $element['date_fin'])/86400 ))   ;
            $liste_des_proches [] = [
                 "jour" => $jour ,
                 "status"  => "futur",
                 "identifiant" =>$identifiant
            ] ; 
        }
        else{
            $liste_des_proches [] = [
                "jour" => 0 ,
                "status"  => "present" ,
                "identifiant" =>$identifiant
           ] ;  
        }
    }

print_r($liste_des_proches) ; 

}