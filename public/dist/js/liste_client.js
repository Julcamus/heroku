
if($("#status_connection").val() == "non_etablie"){

 const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
 

 toastr.error('Impossible de se connecter à la base de donné') ; 

}


// Début gestion d'affichage des infos dans le modale de modification
var tous_les_bouttons_modifier = document.querySelectorAll(".modifier") ; 
for (var i = 0 ; i < tous_les_bouttons_modifier.length ; i++){
  var un_boutton = tous_les_bouttons_modifier[i] ;

 un_boutton.addEventListener("click",function(e) {
  
    e.preventDefault() ;
    var id = this.id.split("_")[1] ; 

 
    
    xhttp = initialisation() ; 
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        
        console.log(this.responseText) ;


        // traitement du résultat de la requette

        if(this.responseText != "error"){
          var resultat = this.responseText.split(",") ;

          var user_id = resultat[0] ; 
          var date = resultat[1];
          var nom = resultat[2] ; 
          var prenom = resultat[3] ; 
          var nom_societe = resultat[4];
          var ip = resultat[5] ; 
          var adresse = resultat[6] ; 
          var email = resultat[7];
          var numero = resultat[8] ;
          var type_client = resultat[9] ;

          $("#type").text(type_client) ; 
          $("#societe_nom").text(nom_societe);
          $("#nom").text(nom);
          $("#prenom").text(prenom) ; 
          $("#adresse").text(adresse);
          $("#email").text(email);
          $("#telephone").text(numero) ;
          $("#ip").text(ip) ;

          // Remplissage des champs input du formulaire de modification
          $("#type_client").val(type_client) ; 
          $("#id_client").val(user_id)  ;
          $("#societe_input").val(nom_societe);
          $("#nom_inpu").val(nom);
          $("#prenom_input").val(prenom);
          $("#adresse_input").val(adresse);
          $("#telephone_input").val(numero);
          $("#email_input").val(email);
          $("#ip_input").val(ip);



          // Remplissage des champs input du formulaire de modification

          if(type_client == "entreprise"){
            $("#personnel_div").hide() ;
            $('#societe_div').show();
            
             $("#societe_input_div").attr("placeholder",nom_societe) ;  
          }
          else if(type_client =="personnel"){
            $("#societe_div").hide() ;
             $("#personnel_div").show() ; 
          }

          // Remettre les éléements du modal à leur place
          /*Debut element concernant le nom*/
          $("#click_modifier_nom").show();
          $("#nom_input_div").hide() ; 
          $("#nom").show();
          $("#ok_nom").hide() ;
        /*Fin element concernant le nom*/

        /*Debut element concernant le prénom*/
          $("#click_modifier_prenom").show();
          $("#prenom_input_div").hide() ; 
          $("#prenom").show();
          $("#ok_prenom").hide() ;
        /*Fin element concernant le prénom*/


        /*Debut element concernant nom societe*/
          $("#click_modifier_societe").show();
          $("#societe_input_div").hide() ; 
          $("#societe_nom").show();
          $("#ok_societe").hide() ;
        /*Fin element concernant nom societe*/

        /*Debut element concernant adresse*/
          $("#click_modifier_adresse").show();
          $("#adresse_input_div").hide() ; 
          $("#adresse").show();
          $("#ok_adresse").hide() ;
        /*Fin element concernant adresse*/

         /*Debut element concernant email*/
          $("#click_modifier_email").show();
          $("#email_input_div").hide() ; 
          $("#email").show();
          $("#ok_email").hide() ;
        /*Fin element concernant email*/

         /*Debut element concernant le téléphone*/
          $("#click_modifier_telephone").show();
          $("#telephone_input_div").hide() ; 
          $("#telephone").show();
          $("#ok_telephone").hide() ;
        /*Fin element concernant le téléphone*/

         /*Debut element concernant l'ip*/
          $("#click_modifier_ip").show();
          $("#ip_input_div").hide() ; 
          $("#ip").show();
          $("#ok_ip").hide() ;
        /*Fin element concernant l'ip*/






          // Lancement du modal
          $("#modal-modif").modal('show') ; 


          // Gestion de la modification des infos

          /*Debut gestion modification du nom*/
          $("#click_modifier_nom").click(function(){
              $("#nom").hide();
              $(this).hide();
               $("#nom_input").val(nom) ; 
              $("#nom_input_div").css("display","block") ;
              $("#ok_nom").show() ;
              
          }) ;
          
         $("#ok_nom").click(function(){

             $("#nom_input_div").css("display","none") ;
              $("#nom").text( $("#nom_input").val() );
              $("#nom").show();
              $(this).hide();
               $("#click_modifier_nom").show() ; 


         }) ;

      /*Fin de la gestion de la modification du nom*/

      /*Debut gestion modification du prenom*/
          $("#click_modifier_prenom").click(function(){
              $("#prenom").hide();
              $(this).hide();
               $("#prenom_input").val(prenom) ; 
              $("#prenom_input_div").css("display","block") ;
              $("#ok_prenom").show() ;
              
          }) ;
          
         $("#ok_prenom").click(function(){

             $("#prenom_input_div").css("display","none") ;
              $("#prenom").text( $("#prenom_input").val() );
              $("#prenom").show();
              $(this).hide();
               $("#click_modifier_prenom").show() ; 


         }) ;

      /*Fin de la gestion de la modification du prenom*/


         
        /*Debut gestion modification du  nom de la  societe*/
          $("#click_modifier_societe").click(function(){
              $("#societe_nom").hide();
              $(this).hide();
               $("#societe_input").val(nom_societe) ; 
              $("#societe_input_div").css("display","block") ;
              $("#ok_societe").show() ;
              
          }) ;
          
         $("#ok_societe").click(function(){

             $("#societe_input_div").css("display","none") ;
              $("#societe_nom").text( $("#societe_input").val() );
              $("#societe_nom").show();
              $(this).hide();
               $("#click_modifier_societe").show() ; 


         }) ;

      /*Fin de la gestion de la modification du nom  de la societe*/


      /*Debut gestion modification de l'adresse*/
          $("#click_modifier_adresse").click(function(){
              $("#adresse").hide();
              $(this).hide();
               $("#adresse_input").val(adresse) ; 
              $("#adresse_input_div").css("display","block") ;
              $("#ok_adresse").show() ;
              
          }) ;
          
         $("#ok_adresse").click(function(){

             $("#adresse_input_div").css("display","none") ;
              $("#adresse").text( $("#adresse_input").val() );
              $("#adresse").show();
              $(this).hide();
               $("#click_modifier_adresse").show() ; 


         }) ;

      /*Fin de la gestion de la modification de l'adresse*/



       /*Debut gestion modification de l'adresse*/
          $("#click_modifier_email").click(function(){
              $("#email").hide();
              $(this).hide();
               $("#email_input").val(email) ; 
              $("#email_input_div").css("display","block") ;
              $("#ok_email").show() ;
              
          }) ;
          
         $("#ok_email").click(function(){

             $("#email_input_div").css("display","none") ;
              $("#email").text( $("#email_input").val() );
              $("#email").show();
              $(this).hide();
               $("#click_modifier_email").show() ; 


         }) ;

      /*Fin de la gestion de la modification de l'adresse*/


      /*Debut gestion modification du telephone*/
          $("#click_modifier_telephone").click(function(){
              $("#telephone").hide();
              $(this).hide();
               $("#telephone_input").val(numero) ; 
              $("#telephone_input_div").css("display","block") ;
              $("#ok_telephone").show() ;
              
          }) ;
          
         $("#ok_telephone").click(function(){

             $("#telephone_input_div").css("display","none") ;
              $("#telephone").text( $("#telephone_input").val() );
              $("#telephone").show();
              $(this).hide();
               $("#click_modifier_telephone").show() ; 


         }) ;

      /*Fin de la gestion de la modification du téléphone*/

     /*Debut gestion modification de l'ip*/
          $("#click_modifier_ip").click(function(){
              $("#ip").hide();
              $(this).hide();
               $("#ip_input").val(ip) ; 
              $("#ip_input_div").css("display","block") ;
              $("#ok_ip").show() ;
              
          }) ;
          
         $("#ok_ip").click(function(){

             $("#ip_input_div").css("display","none") ;
              $("#ip").text( $("#ip_input").val() );
              $("#ip").show();
              $(this).hide();
               $("#click_modifier_ip").show() ; 


         }) ;

      /*Fin de la gestion de la modification de l'ip*/

        }

      }
    };
    xhttp.open("POST", "controllers/liste_client.php", true);
    var formData = new FormData() ;
    formData.append("id",id) ; 
    formData.append("action","modifier") ; 
    xhttp.send(formData);
    
  });
    
} ; 
// Fin de la gestion des infos dans le modal de modification


// Code de la gestion du click sur le boutton "Enrégistrer les modifications"


  var formulaire = document.querySelector("#modif-form") ;
  formulaire.addEventListener("submit",function(e){

    var error = "" ; 
    e.preventDefault() ; 
    xhttp = initialisation() ; 
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      resultat = this.responseText ; 
     console.log(this.responseText)  ;
       
      switch (resultat) {
          case "data-base-connection-error":
              error ="Erreur de connection à la base de donné" ; 
              break;
         case "ip-utilise":
              error ="Cette adresse ip est déja utilisé pour un autre client" ; 
              break;
         case "le-fichier-est-corrompu":
              error ="Le fichier de la pièce est corrompu.Veuillez choisir un autre." ; 
              break;    
        case "file-exist":
                error ="Un fichier du même nom existe déja dans notre base de donné, veuillez renommer le fichier" ; 
                break; 
        case "fichier-trop-volumineux":
            error ="La taille de votre fichier , dépasse la taille prévu par fichier." ; 
            break; 
        
        case "format-non-pris-en-charge":
            error ="Nous n'acceptons pas ce type de fichier." ; 
            break;
        case "reessayer-l-envoie":
            error ="Veuillez réessayer l'envoie du fichier" ; 
            break;
        case "nom-societe-utilise":
            error ="Ce nom de socité est déja utilisé pour une autre entreprise." ; 
            break;    
        case "entreprise-exist":
                error ="Ce nom d'entreprise est déjà enrégistré dans notre base de donnée" ; 
                break; 
        case "nom-prenom-utilise":
            error ="Un client du meme nom et prénom existe déja." ; 
            break;     
          
      }
        if(resultat == "add-sucess"){
           // $("#error-message").hide() ;
           // $("#sucess-message").show() ;
           toastr.success('Modification éffectué avec success') ; 
           
        }
        else{
            toastr.error(error) ; 
           
        }

     
    }
  };
xhttp.open("POST", "controllers/modifier_client.php", true);
var formData = new FormData(formulaire);
xhttp.send(formData);



}) ;

// Fin de la gestion du click sur le boutton "Enrégistrer les modifications"
 


// Gestion de l'affichage des informations

var tous_les_bouttons_afficher = document.querySelectorAll(".afficher") ; 
for (var i = 0 ; i < tous_les_bouttons_afficher.length ; i++){
  var un_boutton_afficher = tous_les_bouttons_afficher[i] ;

 un_boutton_afficher.addEventListener("click",function(e) {
  
    e.preventDefault() ;
    var afficher_id = this.id.split("_")[1] ; 

   
    
    xhttp = initialisation() ; 
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        
       


        // traitement du résultat de la requette

        if(this.responseText != "error"){
          var resultat = this.responseText.split(",") ;
          var user_id = resultat[0] ; 
          var date = resultat[1];
          var nom = resultat[2] ; 
          var prenom = resultat[3] ; 
          var nom_societe = resultat[4];
          var ip = resultat[5] ; 
          var adresse = resultat[6] ; 
          var email = resultat[7];
          var numero = resultat[8] ;
          var type_client = resultat[9] ;

          $("#type_afficher").text(type_client) ; 
          $("#societe_nom_afficher").text(nom_societe);
          $("#nom_afficher").text(nom);
          $("#prenom_afficher").text(prenom) ; 
          $("#adresse_afficher").text(adresse);
          $("#email_afficher").text(email);
          $("#telephone_afficher").text(numero) ;
          $("#ip_afficher").text(ip) ;
            

          // Remplissage des champs input du formulaire de modification

          if(type_client == "entreprise"){
            $("#personnel_div_afficher").hide() ;
            $('#societe_div_afficher').show();
              
          }
          else if(type_client =="personnel"){
            $("#societe_div_afficher").hide() ;
             $("#personnel_div_afficher").show() ; 
          }

          // Lancement du modal
          $("#modal-afficher").modal('show') ; 

        }

      }
    };
    xhttp.open("POST", "controllers/liste_client.php", true);
    var formData = new FormData() ;
    formData.append("id",afficher_id) ; 
    formData.append("action","afficher") ; 
    xhttp.send(formData);
    


  });
    
} ; 



// Fermerture du modal pour afficher les informations

$("#fermer_afficher_modal").click(function(e){ 
  $("#modal-afficher").modal('hide') ;

  })


/* Début du code pour l'affichage du modal de la suppresion */

var tous_les_bouttons_supprimer = document.querySelectorAll(".supprimer") ; 
for (var i = 0 ; i < tous_les_bouttons_supprimer.length ; i++){
  var un_boutton_supprimer = tous_les_bouttons_supprimer[i] ;

 un_boutton_supprimer.addEventListener("click",function(e) {

    e.preventDefault() ;
    var supprimer_id = this.id.split("_")[1] ;
    

    xhttp = initialisation() ; 
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {

          if(this.responseText != "error"){
          var resultat = this.responseText.split(",") ;
          var user_id = resultat[0] ; 
          var nom = resultat[2] ; 
          var prenom = resultat[3] ; 
          var nom_societe = resultat[4];
          var type_client = resultat[9] ;

          if(type_client == "personnel"){
            client = nom+" "+prenom ; 
          }
          else if( type_client == "entreprise"){
            client = nom_societe ; 
          }

          $("#id_client_supprimer").val(user_id) ;
          $("#client_supprimer_nom").text(client);
          $("#modal-supprimer").modal('show') ;

        


        }
     


      } 

    } ; 
   
    xhttp.open("POST", "controllers/liste_client.php", true);
    var formData = new FormData() ;
    formData.append("id",supprimer_id) ; 
    formData.append("action","supprimer") ; 
    xhttp.send(formData);

    }) ; 
}

/* Fin du code  pour l'affichage du modal de  suppression */



// Début gestion du click sur le boutton supprimé du modal de suppresion de client

$("#supprimer_client_button").click(function(e){
  e.preventDefault();
  
  var id = $("#id_client_supprimer").val() ;
   toastr.success('Suppression du client éffectué avec success') ;  

    

    xhttp = initialisation() ; 
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {

          if(this.responseText != "error"){
          
          $("#modal-supprimer").modal('hide') ;

        }
     


      } 

    } ; 


    xhttp.open("POST", "controllers/liste_client.php", true);
    var formData = new FormData() ;
    formData.append("id",id) ; 
    formData.append("action","confirmer_supprimer") ; 
    xhttp.send(formData);
});



// Gestion du click sur le boutton ignoré du modal de confirmation de suppression du client

$("#ignore_supprimer_client_button").click(function(e){
 e.preventDefault() ; 
 $("#modal-supprimer").modal('hide') ;
 })















function initialisation(){
  if (window.XMLHttpRequest) {
      // code for modern browsers
      xmlhttp = new XMLHttpRequest();
    } else {
      // code for old IE browsers
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
   }
   return xmlhttp ; 
} ; 


// Code pour affichage des toast

$(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
 }) ; 
 