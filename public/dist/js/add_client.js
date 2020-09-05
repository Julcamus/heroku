if($("#status_connection").val() == "non_etablie"){

 const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
 

 toastr.error('Impossible de se connecter à la base de donné') ; 

}



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


 
var  checkbox = $("#type_checkbox")  ;
var checkbox_value = document.querySelector("#type_checkbox_value") ;
var new_number = document.querySelector("#new_number") ; 
var telephone2= document.querySelector("#telephone2") ;
var error_message =document.querySelector("#error-message") ; 

 // gestion du switch de sélection du typpe du client
$('#switch').on("click",function(){
   
    if(checkbox_value.value === "personnel"){
         checkbox_value.value = "entreprise" ;
        $("#personnel").hide() ; 
        $("#societe").show() ;
        $("#nom-personnel").val(" ")   ;
        $("#prenom-personnel").val(" ") ;  

          
        
        }
    else if(checkbox_value.value === "entreprise"){ 
        checkbox_value.value =  "personnel"  ;
        $("#personnel").show() ; 
        $("#societe").hide() ;
        $("#nom-societe").val(" ")  ; 
      }
}) ;

// 
new_number.addEventListener("click",function(){ telephone2.style.display="block"; this.style.display= "none"}) ;


// Code pour affichage des toast

$(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
 }) ; 
 
 


// code ajax pour la gestion assynchrone de l'inscription


var form = document.querySelector("form") ;
form.addEventListener("submit",function(e){
    var error = "" ; 
    e.preventDefault() ; 

$("#telephone1").css("border-color","") ;
$("#telephone2").css("border-color","") ;
if($("#telephone1").val() != "" && verification_number($("#telephone1").val()) == "numero_non_valide"){
  $("#telephone1").css("border-color","red") ; 
}
else if($("#telephone2").val() != "" && verification_number($("#telephone2").val()) == "numero_non_valide"){
  $("#telephone2").css("border-color","red") ; 
}
else{

$("#telephone1").css("border-color","") ;
$("#telephone2").css("border-color","") ;
xhttp = initialisation() ; 
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      
      resultat= this.responseText ;
      console.log(resultat) ; 
       
      switch (resultat) {
          case "data-base-connection-error":
              error ="Erreur de connection à la base de donné" ; 
              break;
         case "entreprise-existe":
              error ="Ce nom d'entreprise existe déja dans notre base" ; 
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
        case "ip-exist":
            error ="Cette adresse IP est déjà enrégistré dans notre base de donnée." ; 
            break;    
        case "entreprise-exist":
                error ="Ce nom d'entreprise est déjà enrégistré dans notre base de donnée" ; 
                break; 
        case "personnel-existe":
            error ="Ce nom et prénom est déja enrégistré dans notre base de donnée" ; 
            break;     
          
      }

        if(resultat == "add-sucess"){
           // $("#error-message").hide() ;
           // $("#sucess-message").show() ;
           toastr.success('Enrégistrement du client éffectué avec succès') ; 
            $("#nom").val(" ");
            $("#nom").text(" ");
            $("#prenom").text(" ");
            $("#prenom").val(" ");
            $("#nom_societe").val(" ");
            $("#nom_societe").text(" ");
            $("#piece").val(" ");
            $("#exampleInputFile").val("") ; 
            

        }
        else{
            toastr.error(error) ; 
           
        }

     
    }
  };
xhttp.open("POST", "controllers/add_client.php", true);
var formData = new FormData(form)
xhttp.send(formData);

}

}) ; 





function verification_number(numero){
  var   regex = /^[0-9]{8}$/
  if(regex.test(numero) == true){
    return "numero_valide" ; 
  } 
  else{
    return "numero_non_valide" ; 
  }
}



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




