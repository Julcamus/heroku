<?php
require('usine.php');
/* classe representant un client */

class  client  extends usine
{
    private $date_ajout;
    private $type;
    private $nom;
    private $prenom;
    private $nom_societe;
    private  $telephone1;
    private   $telephone2;
    private  $email;
    private  $addresse;
    private  $ip;
    private  $piece;



    public function get_date_ajout()
    {
        return $this->date_ajout;
    }

    public function set_date_ajout($new_value)
    {
        $this->date_ajout = $new_value;
    }


    public function get_type()
    {
        return $this->type;
    }

    public function set_type($new_value)
    {
        $this->type = $new_value;
    }


    public function get_nom()
    {
        return $this->nom;
    }

    public function set_nom($new_value)
    {
        $this->nom = $new_value;
    }


    public function get_prenom()
    {
        return $this->prenom;
    }

    public function set_prenom($new_value)
    {
        $this->type = $new_value;
    }


    public function get_nom_societe()
    {
        return $this->nom_societe;
    }

    public function set_nom_societe($new_value)
    {
        $this->nom_societe = $new_value;
    }


    public function get_telephone1()
    {
        return $this->telephone1;
    }

    public function set_telephone1($new_value)
    {
        $this->telephone1 = $new_value;
    }

    public function get_telephone2()
    {
        return $this->telephone2;
    }

    public function set_telephone2($new_value)
    {
        $this->telephone2 = $new_value;
    }

    public function get_email()
    {
        return $this->email;
    }

    public function set_email($new_value)
    {
        $this->email = $new_value;
    }

    public function get_adresse()
    {
        return $this->adresse;
    }

    public function set_adresse($new_value)
    {
        $this->adresse = $new_value;
    }

    public function get_ip()
    {
        return $this->ip;
    }

    public function set_ip($new_value)
    {
        $this->ip = $new_value;
    }

    public function get_piece()
    {
        return $this->piece;
    }

    public function set_piece($new_value)
    {
        $this->piece = $new_value;
    }

    // Constucteur

    public function __construct()
    {
        $date_ajout = " ";
        $type  = " ";
        $nom   = " ";
        $prenom  = " ";
        $nom_societe  = " ";
        $telephone1   = " ";
        $telephone2  = " ";
        $email   = " ";
        $addresse  = " ";
        $ip  = " ";
        $piece  = " ";
    }


    /*
        Permet d'enregistrer les informations d'un client dans notre base de donnée 
        @param : date , nom , prenom , nom_societe , ip , adresse,email,numero,type_client,piece
        @return string ; 
        */

  static  public function ajouter_client($date, $nom, $prenom, $nom_societe, $ip, $adresse, $email, $numero, $type_client, $piece)
    {
        $connection = self::lancer_une_connection();
        if ($connection === 'data-base-connection-error') {
            return "error-data-base";
        } else {
            $requette = $connection->prepare('INSERT INTO client(date_enregistrement,nom,prenom,nom_societe,ip,adresse,email,numero,type_client,piece_identite) VALUES(?,?,?,?,?,?,?,?,?,?) ');
            $requette->execute(array($date, $nom, $prenom, $nom_societe, $ip, $adresse, $email, $numero, $type_client, $piece));
             
            return "success";
        }
    } // END AJOUTER_CLIENT




    /*
        Permet de modifier les informations d'un client dans notre base de donnée 
        @param : date , nom , prenom , nom_societe , ip , adresse,email,numero,type_client,piece
        @return string ; 
        */

    public function modifier_client($id, $nom, $prenom, $nom_societe, $ip, $adresse, $email, $numero, $type_client, $piece)
    {
        $connection = self::lancer_une_connection();
        if ($connection === 'data-base-connection-error') {
            return "error-data-base";
        } else {
            
            $requette = $connection->prepare('UPDATE client  SET  nom = ? , prenom = ? , nom_societe = ?, ip = ? , adresse = ? , email = ? , numero = ? , type_client = ? , piece_identite = ?  WHERE id=? ');
            $requette->execute(array( $nom, $prenom,$nom_societe,$ip, $adresse, $email,$numero,$type_client,$piece, $id));
            
            return "success";
            
            
        }
    } // END AJOUTER_CLIENT



     public function modifier_client2($id, $nom, $prenom, $nom_societe, $ip, $adresse, $email, $numero, $type_client)
    {
        $connection = self::lancer_une_connection();
        if ($connection === 'data-base-connection-error') {
            return "error-data-base";
        } else {
            
            $requette = $connection->prepare('UPDATE client  SET  nom = ? , prenom = ? , nom_societe = ?, ip = ? , adresse = ? , email = ? , numero = ? , type_client = ?  WHERE id=? ');
            $requette->execute(array( $nom, $prenom,$nom_societe,$ip, $adresse, $email,$numero,$type_client, $id));
            
            return "success";
            
            
        }
    } // END AJOUTER_CLIENT


    /*
        Permet de supprimer les informations d'un client dans notre base de donnée 
        @param : id
        @return string ; 
        */

        public function supprimer_client($id)
        {
            $connection = self::lancer_une_connection();
            if ($connection === 'data-base-connection-error') {
                return "error-data-base";
            } else {
                
                $requette = $connection->prepare('DELETE FROM client WHERE id= ? ');
                $requette->execute(array( $id));
                 
                return "success";
                
                
            }
        } // END SUPPRIMER_CLIENT




        /*
        Permet de vérifier les informations d'un client
        @param : nom,prenom,nom_societe,ip
        @return string ; 
        */

       static public function verifier_existence($type,$nom,$prenom,$nom_societe,$ip)
        {
            $etat = null ;  // cette variable renseigne sur le résultat de la vérification
            $connection = self::lancer_une_connection();
            if($connection === 'data-base-connection-error')
            {
                return "data-base-error" ; 
            }
            else
            {
               
                if($type === "personnel"){
                    $requette = $connection->prepare("SELECT nom , prenom  FROM client WHERE nom = ? AND prenom = ? ") ;
                    $requette->execute([$nom,$prenom]);
                    $resultat= $requette->fetch() ;
                    
                    if($resultat == false){
                        $etat= "no-exist";
                    }
                    else{
                        $etat= "personnel-exist";
                    }
                }
                else if($type === "entreprise"){
                    $requette = $connection->prepare("SELECT nom_societe  FROM client WHERE nom_societe = ?  ") ;
                    $requette->execute([$nom_societe]);
                    $resultat = $requette->fetch() ;
                    if($resultat == false ){
                        $etat= "no-exist";
                    }
                    else{
                        $etat= "entreprise-exist";
                    }
                }

                // verification pour l'unicité de l'adress ip
                if($etat == "no-exist" ){

                    $requette = $connection->prepare("SELECT ip  FROM client WHERE ip = ?  ") ;
                    $requette->execute([$ip]);
                    $resultat = $requette->fetch() ; 
                    if($resultat == false){
                        $etat = "ip-no-exist" ; 
                    }
                    else{
                            $etat = "ip-exist" ; 
                    }

                }

                    return $etat ; 


            }
        } // END VERIFIER EXCISTENCE


     

} // END CLASS








