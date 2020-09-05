<?php
require('usine.php');
/* classe representant un client */

class  abonnement  extends usine{
    private $lib_abonnement;
    private $debit;
    private $montant_mensuel;

    public function get_lib_abonnement()
    {
        return $this->debit;
    }

    public function set_lib_abonnement($new_value)
    {
        $this->debit = $new_value;
    }


    public function get_debit()
    {
        return $this->debit;
    }

    public function set_debit($new_value)
    {
        $this->debit = $new_value;
    }

    public function get_montant_mensuel()
    {
        return $this->montant_mensuel;
    }

    public function set_montant_mensuel($new_value)
    {
        $this->montant_mensuel = $new_value;
    }

     // Constucteur

     public function __construct()
     {
         $lib_abonnement = " ";
         $montant_mensuel  = " ";
         $debit   = " ";
         
     }

      /*
        Permet d'enregistrer les informations d'un nouvel abonnement dans notre base de donnée 
        @param : lib_abonnement, montant , debit 
        @return string ; 
        */

  static  public function ajouter_abonnement($lib_abonnement, $debit, $montant)
  {
    $connection = self::lancer_une_connection();
    if ($connection === 'data-base-connection-error') {
        return "error-data-base";
    } else {
        $requette = $connection->prepare('INSERT INTO abonnement(lib_abonnement,debit,montant) VALUES(?,?,?) ');
        $requette->execute(array($lib_abonnement, $debit , $montant));
        return "success";
    }    
  }


   /*
        Permet de modifier les informations à un abonnement dans notre base de donnée 
        @param : new_libelle , new_debit , new_montant 
        @return string ; 
        */

      static   public function modifier_abonnement($id_abonnement,$new_lib_abonnement,$new_debit,$new_montant)
        {
            $connection = self::lancer_une_connection();
            if ($connection === 'data-base-connection-error') {
                return "error-data-base";
            } else {
                
                $requette = $connection->prepare('UPDATE abonnement  SET  lib_abonnement = ? , debit = ? , montant = ?  WHERE id=? ');
                $requette->execute(array($new_lib_abonnement,$new_debit,$new_montant,$id_abonnement));
                
                return "success";
                
                
            }
        } // END MODIFIER CLIENT


        /*
        Permet de supprimer les informations relatives à un abonnement dans notre base de donnée 
        @param : id
        @return string ; 
        */

     static   public function supprimer_abonnement($id)
        {
            $connection = self::lancer_une_connection();
            if ($connection === 'data-base-connection-error') {
                return "error-data-base";
            } else {
                
                $requette = $connection->prepare('DELETE FROM abonnement WHERE id= ? ');
                $requette->execute(array( $id));
                 
                return "success";
                
                
            }
        } // END SUPPRIMER ABONNEMENT




} // END CLASS

