<?php
require('usine.php');
/* classe representant un client */

class  ticket  extends usine
{
    private $date_ajout;
    private $libelle;
    private $categorie;
    private $description;
    private $photo;


    // Constucteur

    public function __construct()
    {
        $date_ajout = " ";
        $libelle  = " ";
        $categorie   = " ";
        $description  = " ";
        $photo  = " ";
        
    }


    /*
        Permet d'enregistrer un nouveau ticket  dans notre base de donnée 
        @param : date , libelle , categorie , id_client , description , photo , id_technicien
        @return string ; 
        */

  static  public function ouvrir_ticket($date, $libelle, $categorie,$id_client, $description, $photo, $id_technicien)
  {
      $connection = self::lancer_une_connection();
      if ($connection === 'data-base-connection-error') {
          return "error-data-base";
      } else {
          $requette = $connection->prepare('INSERT INTO tickets(date_ouverture,libelle,categorie,id_client,ticket_description,id_technicien,document) VALUES(?,?,?,?,?,?,?) ');
          $requette->execute(array($date, $libelle, $categorie, $id_client, $description, $id_technicien,$photo));
          

          return "success";
      }
  } // END OUVERTURE TICKET



   /*
        Permet d'enregistrer une intervention  dans notre base de donnée 
        @param : date , id_technicien, id_ticket,libelle_intervention,description,$resultat_obtenu,$photo
        @return string ; 
        */

        static  public function enregister_intervention($date,$id_technicien,$id_ticket, $libelle_intervention, $description, $resultat_obtenu, $photo)
        {
            $connection = self::lancer_une_connection();
            if ($connection === 'data-base-connection-error') {
                return "error-data-base";
            } else {
                $requette = $connection->prepare('INSERT INTO intervention(date_intervention,id_technicien,id_ticket,libelle_intervention,description,resultat_obtenu,photo) VALUES(?,?,?,?,?,?,?) ');
                $requette->execute(array($date,$id_technicien,$id_ticket,$libelle_intervention,$description,$resultat_obtenu,$photo));
                
      
                return "success";
            }
        } // END AJOUT INTERVENTION


        /*
        Permet d'enregistrer la fermeture d'un ticket dans notre base  dans notre base de donnée 
        @param : id_ticket,date_cloture,id_technicien,rapport
        @return string ; 
        */

        static  public function cloture_ticket($id_ticket,$date_cloture,$id_technicien, $rapport)
        {
            $connection = self::lancer_une_connection();
            if ($connection === 'data-base-connection-error') {
                return "error-data-base";
            } else {
                $requette = $connection->prepare('UPDATE tickets SET status=? ,rapport=? ,id_technicien_fermeture=?, date_cloture = ?  WHERE id=?') ;
                $requette->execute(array("resolu",$rapport,$id_technicien,$date_cloture,$id_ticket));
                
      
                return "success";
            }
        } // END CLOTURE TICKET


}

ticket::ouvrir_ticket(1599317280,"instabilite de la connection","-----Probleme d-----",54,"-----ffgfg-----","activité_ajout_payement.png-----",2) ; 
 
 
?>