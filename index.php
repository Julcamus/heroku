<?php 
		
		//require("vendor/autoload.php")  ;
		
		
		$page = $_SERVER["REQUEST_URI"] ;

		if($page === "/"){
		
		ob_start() ; 
		require("public/home.php") ; 
		$content = ob_get_clean() ;
		require("public/layout.php") ; 		 
		}

		elseif ($page === "/add_client") {
			ob_start() ; 
			require("public/add_client.php") ;
			$content = ob_get_clean() ; 
			require("public/layout.php") ; 		 
		} 
		
		elseif ($page === "/liste_client") {
			
			ob_start() ; 
			require("public/liste_client.php") ; 
			$content = ob_get_clean() ;
			require("public/layout.php") ; 		 
		
		}
		// A supprimer
		elseif ($page === "/test") {
			
			ob_start() ; 
			require("test.php") ; 
			$content = ob_get_clean() ;
			require("public/layout.php") ;  		 
		
		}

		// A supprimer
		elseif ($page === "/usine") {
			
			ob_start() ; 
			require("app/usine.php") ; 
			$content = ob_get_clean() ;
			require("public/layout.php") ;  		 
		
		}

		// A supprimer
		elseif ($page === "/client") {
			
			ob_start() ; 
			require("app/client.php") ; 
			$content = ob_get_clean() ;
			require("public/layout.php") ;  		 
		
		}
		// A supprimer
		elseif ($page === "/tickets") {
			
			
			require("app/tickets.php") ; 
			 		 
		
		}

		// A supprimer
		elseif ($page === "/abonnement") {
			
			ob_start() ; 
			require("app/abonnement.php") ; 
			$content = ob_get_clean() ;
			require("public/layout.php") ;  		 
		
		}
		// A supprimer
		elseif ($page === "/test_payement") {
			
			ob_start() ; 
			//require("app/abonnement.php") ; 
			//$content = ob_get_clean() ;
			require("public/test_payement.php") ;  
					 
		
		}

		elseif ($page === "/dashboard") {
		ob_start() ; 
		require("public/dashboard.php") ; 
		$content = ob_get_clean() ;
		require("public/layout.php") ; 
		}
		elseif($page === "/gestion-abonnement"){
			ob_start() ; 
			require("public/gestion-abonnement.php") ; 
			$content = ob_get_clean() ;
			require("public/layout.php") ;
		}

		elseif($page === "/gestion-tickets"){
			ob_start() ;
			 
			require("public/gestion-tickets.php") ; 
			$content = ob_get_clean() ;
			require("public/layout.php") ;
		}


		/* // A supprimer
		elseif ($page === "/controller-liste-client") {
			ob_start() ; 
		require("controllers/liste_client.php") ; 
		$content = ob_get_clean() ; 		 
		
		} */
	
		else  {
			echo '404' ; 
		}
		 


		
		

		 

		
				
					
		

		
 ?>