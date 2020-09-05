 $('#montant_paye').hide() ;
 var montant_paye_show = 0 ;  

  $('#show_montant_div').click(function(){

     
      if(montant_paye_show == 0){
      	 $('#montant_paye').show() ;
      	 montant_paye_show = 1 ;
      } 
      else {
      		 $('#montant_paye').hide() ;
      	 	  montant_paye_show = 0 ;
      }
  }) ; 


