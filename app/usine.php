<?php
    /*  classe permettant de gerer certaines actions*/
    
    abstract class usine {
       
        const DSN  = 'mysql:dbname=vaiapp;host=127.0.0.1'; 
        const IDENTIFIANT ="root" ; 
        const PASSWORD = "" ; 
        const CHARSET = "utf8_unicode_ci"; 

        /*
        Permet de lancer une connection à la base de donnée 
        @param : data_base_name,host,identifiant , charset
        @return PDO element  or string
        */ 

        public static function lancer_une_connection()
        {
               
                 
                try {
                   
                  
                   $connection = new PDO(self::DSN,self::IDENTIFIANT ,self::PASSWORD);
                   return $connection ; 
                  
                  
                } catch (PDOException $e) {
                   
                    return 'data-base-connection-error' ; 

                }

                
        }


     /*
        Permet de verifier la fiabilité d'un information rensignée 
        @param : data
        @return  boolean
        */ 
        
      static  public function gendarme($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    
    
    
    
    }
       
// Ce code te permettra de tester la valeur retourné par ta méthode :

$resultat_connection = usine::lancer_une_connection() ; 
    

?>