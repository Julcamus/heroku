

// loader
var loader = function () {
  setTimeout(function () {
    if ($('#ftco-loader').length > 0) {
      $('#ftco-loader').removeClass('show');
    }
  }, 1);
};


$(".select2").ready(function(){  
  console.log('chargé') ; 
  loader() ; 
}) ;



$(function () {
  $('.data_table_element').DataTable({
    'responsive': true,
    'autoWidth': false,
  });

});

$(function(){
  $('[data-toggle="tooltip"]').tooltip();
})



if ($("#status_connection").val() == "non_etablie") {

  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });


  toastr.error('Impossible de se connecter à la base de donné');

}






$(".paginate_button").css("background-color", "yellow");
$('#montant_paye').hide();
var montant_paye_show = 0;

$('#show_montant_div').click(function () {


  if (montant_paye_show == 0) {
    $('#montant_paye').show();
    montant_paye_show = 1;
    $("#montant_remis").val(0);
  }
  else {
    $('#montant_paye').hide();
    montant_paye_show = 0;
    $("#montant_remis").val(0);
  }
});




$('#debit').hide();
var debit_show = 0;

$('#autre').click(function () {
  alert("je suis cliqué");

  if (debit_show == 0) {
    $('#debit').show();
    debit_show = 1;
  }
  else {
    $('#debit').hide();
    debit_show = 0;
  }
});




// Gestion de l'evenement du click du boutton enrégistrer l'abonnement de la home page
$("#valider_abonnement").click(function (e) {
  e.preventDefault();
  var je_peux_valider = 0;

  id_abonnement = $("#id_abonnement").val();


  if ($("#abonnement_choisi").val() == "Autre" && $("#libelle_autre").val() == "" && $("#debit_autre").val() == "") {
    // Cas ou toutes les informations concernant la nouvelle offre d'abonnement ne sont pas tous renseigné
    toastr.error("Veuillez fournir toutes les informations concernant le nouvel abonnement avant de continuer");
  }

  else if ($("#abonnement_choisi").val() == "Autre" && $("#libelle_autre").val() != "" && $("#debit_autre").val() != "") {
    // Cas ou toutes les informations concernant la nouvelle offre d'abonnement sont bien renseigné

    $("#libelle_abonnement").text($("#libelle_autre").val());
    $("#debit_abonnement").text($("#debit_autre").val());
    $("#montant_abonnement").text($("#montant_mensuel").val());

    if (getCookie("afficher_confirmation_ajout_new_abonnement") == "oui") {
      // Cas ou la cookie du refus d'affichage du modale de confirmation de l'ajout du nouvel abonnement

      xhttp = initialisation();
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          if (this.responseText == "error") {
            toastr.error('Impossible de se connecter à la base de donné');
          }
          else {
            id_abonnement = this.responseText;
          }
        }

      }

      xhttp.open("POST", "controllers/home.php", true);
      var formData = new FormData();
      formData.append("action", "add_new_type_abonnement");
      formData.append("montant_mensuel", $("#montant_mensuel").val());
      formData.append("libelle", $("#libelle_autre").val());
      formData.append("debit", $("#debit_autre").val());
      xhttp.send(formData);

    }
    else {
      // Cas ou la cookie n'existe pas  
      $("#modal-sauvegarde-nouveau-abonnement").modal('show');  // Affichage du modal de confirmation de l'ajout du nouvel abonnement    
      if ($("#rapelle").val() == "oui") {
        setCookie("afficher_confirmation_ajout_new_abonnement", "oui", 30);
      }

      $("#add_new_abonnement").click(function () {
        $("#modal-sauvegarde-nouveau-abonnement").modal('hide');
        xhttp = initialisation();
        xhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == "error") {

              toastr.error('Impossible de se connecter à la base de donné');
            }
            else {
              id_abonnement = this.responseText;
              
            }
          }

        }

        xhttp.open("POST", "controllers/home.php", true);
        var formData = new FormData();
        formData.append("action", "add_new_type_abonnement");
        formData.append("montant_mensuel", $("#montant_mensuel").val());
        formData.append("libelle", $("#libelle_autre").val());
        formData.append("debit", $("#debit_autre").val());
        xhttp.send(formData);
      });

    }

  } // FIN DE LA GESTION DU CAS OU LE TYPE D'ABONNEMENT CHOISI EST NOUVEAU

  clients = $("#client_a_abonner").val();
   
  montant_mensuel = $("#montant_mensuel").val();
  montant_remis = $("#montant_remis").val();
  duree = $("#duree").val();
  for (var i = 0; i < clients.length; i++) {

    clients[i] = clients[i].replace("_", " ");
  }
  clients_text = clients.toString(); // clients_text contient la liste des clients sélectionnés à afficher dans le modal de confirmation

  if (duree == "" || montant_mensuel == "" || $("#client_a_abonner").val().length == 0) {
    // dans le cas ou des informations ne sont pas renseigné par rapport à l'abonnement à effectuer
    toastr.error("Veuillez fournir toutes les informations néccessaires");

  }
  else {
    // Dans le cas ou toutes les informations concernant l'abonnement sont renseignées
    if (clients.length == 1) {
      $("#accord_client").text("au client");
      $("#liste_client").text(clients_text);


    }
    else if (clients.length > 1) {
      $("#accord_client").text("aux clients");
      $("#liste_client").text(clients_text);
    }


    $("#modal-confirmer-abonnement").modal('show');

  }
})

// Gestion du cllck sur les deux bouttons oui et non du modal de confirmation
$("#infirm").click(function () {
  $("#modal-confirmer-abonnement").modal('hide');
});

$("#confirm").click(function () {

  xhttp = initialisation();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {

      if (this.responseText == "error") {
        toastr.error("Désolé un soucis technique est survenu, veuillez rafraichir la page et reprendre l'opération");

      }
      else {
        console.log(this.responseText);
        $("#modal-confirmer-abonnement").modal('hide');
        toastr.success("Enrégistrement de l'abonnement éffectué  avec succès");

      }

    }


  }

  xhttp.open("POST", "controllers/home.php", true);
  var formData = new FormData();
  formData.append("clients", clients);
  formData.append("action", "enregistrer_abonnement");
  formData.append("id_abonnement", id_abonnement);
  formData.append("montant_mensuel", montant_mensuel);
  formData.append("duree", duree);
  formData.append("montant_remis", montant_remis);
  xhttp.send(formData);
});




var toutes_les_offres = document.querySelectorAll(".normal_abonnement");
for (var i = 0; i < toutes_les_offres.length; i++) {
  un_abonnement = toutes_les_offres[i];
  un_abonnement.addEventListener("click", function (e) {
    e.preventDefault()
    console.log("ca marche");

  });
}






//Gestion de la variation de valeur du champ de séléction du type d'offre

$("#abonnement_choisi").change(function () {

  if ($(this).val() == "Autre") {
    $("#abonnement_info_et_selection_client").css("display","block") ;
    $("#body_abonnement_info").css("display","block")
    $("#autre_abonnement").css("display", "block");
    $("#montant_mensuel").val(0);
    $("#body_abonnement_info").css("display","block") ;
    $("#frais_installation_zone").css("display","none") ;
    $("#frais_installation_button_container").css("display","none") ;
    $("#changement_offre_zone").css('display',"none");
    $("#modifer_offre_button_container").css('display',"none") ;
    $("#abonnement_button_container").css("display","block") ;
    $("#frais_installation_button_container").css("display","none") ;  
    
  }
  else if($(this).val()=="changement_offre"){
    $("#abonnement_info_et_selection_client").css("display","none") ;
    $("#changement_offre_zone").css('display',"block") ;
    $("#modifer_offre_button_container").css('display',"block") ;
    $("#abonnement_button_container").css("display","none") ;
    $("#frais_installation_button_container").css("display","none") ; 
  }
  else if($(this).val() == "frais-installation"){
    $("#changement_offre_zone").css('display',"none") ;
    $("#abonnement_info_et_selection_client").css("display","block") ;
    $("#body_abonnement_info").css("display", "none");
    $("#montant_mensuel").val(0);
    $("#body_abonnement_info").css("display","none") ;
    $("#frais_installation_zone").css("display","block") ;
    $("#valider_abonnement").css("display","none") ;
    $("#abonnement_button_container").css("display","none") ;
    $("#frais_installation_button_container").css("display","block") ;
    $("#modifer_offre_button_container").css('display',"none") ;
    

 
    
    xhttp = initialisation();
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {

        var resultat_tableau = this.responseText.split(",");
        $("#id_abonnement").val(resultat_tableau[0]);
        $("#montant_mensuel").val(resultat_tableau[1]);

      }
    }

    xhttp.open("POST", "controllers/home.php", true);
    var formData = new FormData();
    formData.append("libelle_abonnement", $(this).val());
    formData.append("action", "trouver_montant");
    formData.append("id_abonnement", $("#id_abonnement").val());

    xhttp.send(formData);

  }
  else if ($(this).val() != "Autre" && $(this).val() != "frais-installation") {
    $("#abonnement_info_et_selection_client").css("display","block") ;
    $("#body_abonnement_info").css("display","block") 
    $("#autre_abonnement").css("display", "none");
    $("#frais_installation_zone").css("display","none") ;
    $("#frais_installation_button_container").css("display","none") ;
    $("#valider_abonnement").css("display","block") ;
    $("#abonnement_button_container").css("display","block") ;
    $("#changement_offre_zone").css('display',"none") ; 

    
    
    xhttp = initialisation();
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {

        var resultat_tableau = this.responseText.split(",");
        $("#id_abonnement").val(resultat_tableau[0]);
        $("#montant_mensuel").val(resultat_tableau[1]);

      }
    }

    xhttp.open("POST", "controllers/home.php", true);
    var formData = new FormData();
    formData.append("libelle_abonnement", $(this).val());
    formData.append("action", "trouver_montant");
    formData.append("id_abonnement", $("#id_abonnement").val());

    xhttp.send(formData);
  }
  else if ($(this).val() == "vide") {
    $("#autre_abonnement").css("display", "none");

  }
})
//  Fin de la gestion de la variation de valeur du champ de séléction du type d'offre


// Gestion de l'enregistrement des frais d'installation
$("#enregistrer_frais_installation").click(function(){
  var montant = $("#installation_montant").val() ; 
 var  clients = $("#client_a_abonner").val();

  for (var i = 0; i < clients.length; i++) {

    clients[i] = clients[i].replace("_", " ");
  }

  var montant_paye = $("#montant_remis").val() ;

  xhttp = initialisation();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText) ; 
     // Dans le cas ou l'enregistrement a été éffectué
     if(this.responseText == "error"){
      
      toastr.error("Impossible d'enregistrer les frais d'installation , veuillez réessayer");
     }
     else{
      toastr.success("Enrégistrement de l'abonnement éffectué  avec succès");
     }

    }
  }

  xhttp.open("POST", "controllers/home.php", true);
  var formData = new FormData();
  formData.append("clients", clients);
  formData.append("action", "enregistrer_frais_installation");
  formData.append("montant",montant);
  formData.append("montant_paye", montant_paye);


  xhttp.send(formData);






})

// Fin enregistrement frais installations
 
// Gestion changement d'offre

$("#client_a_modifier_offre").change(function(){
 var client =  $(this).val()

    xhttp = initialisation();
        xhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == "error") {

              toastr.error('Impossible de se connecter à la base de donné');
            }
            else {
              console.log(this.responseText) ; 
              var result = this.responseText.split(",") ;
              $("#montant_par_jour").val(0) ; 
              if(result[0] != ""){
                $("#offre_en_cours").text(result[0]) ;
                $("#nombre_jours_restant").text(result[1]) ;
                $("#jours").text("  jours") ;
                $("#nombre_jours_restant_value").val(result[1]) ; 
              }
              else{
                $("#offre_en_cours").text('Aucun abonnemnt en cours pour ce client') ;
                $("#nombre_jours_restant").text('Néant') ;
                $("#jours").text(" ") ;
                $("#nombre_jours_restant_value").val(0) ; 
              }
               

            }
          }

        }

        xhttp.open("POST", "controllers/home.php", true);
        var formData = new FormData();
        formData.append("action", "get_info_abonnement_en_cours");
        formData.append("client",client);
        xhttp.send(formData); 
})


$("#info_new_abonnement").change(function(){
  xhttp = initialisation();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "error") {

        toastr.error('Impossible de se connecter à la base de donné');
      }
      else {
        var result = this.responseText ; 
       
        console.log(result[0]) ;   
      }
    }

  }

  xhttp.open("POST", "controllers/home.php", true);
  var formData = new FormData();
  formData.append("action", "trouver_client_id");
  formData.append("client",client);
  xhttp.send(formData);
}) 

// Fin gestion changement d'offre

// Gestion clique sur le boutton "Modifier l'abonnement en cours"

$("#modifier_offre").click(function(){
  var id_client = "" ;
  var id_abonnement = null ; 
  var montant_total= 0 ; 
  var montant_paye = null ; 
  var nombre_jour = null ;
  var montant_paye = null ; 
  
  id_client = $("#client_a_modifier_offre").val() ; 
  id_abonnement = $("#nouvel_abonnement").val() ; 
  montant_total = $("#montant_par_jour").val() * $("#nombre_jours_restant_value").val() ;
  nombre_jour = $("#nombre_jours_restant_value").val() ; 
  montant_paye =  $("#montant_remis").val() ;
   

  if(id_client == ""  || id_abonnement == null  ||  montant_total == 0){
    toastr.error("Impossible de renouveler l'abonnement pour ce client.Assurez vous qu'il ai un abonnement en cours ou que toutes les informations sont renseignées");
  }
  else{
  xhttp = initialisation();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "error") {

        toastr.error('Impossible de se connecter à la base de donné');
      }
      else {
        console.log(this.responseText) ; 
        toastr.success("Modification de l'offre en cours éffectué avec succès") ; 
       
       
      }
    }

  }

  xhttp.open("POST", "controllers/home.php", true);
  var formData = new FormData();
  formData.append("action", "modifier_offre_actuelle");
  formData.append("client",id_client);
  formData.append("abonnement",id_abonnement);
  formData.append("montant_total",montant_total);
  formData.append("nombre_jours_restant",nombre_jour);
  formData.append("montant_paye",montant_paye);
  xhttp.send(formData); 
  }
})


// Fin gestion clique sur le boutton "Modifier l'abonnement en cours"



// Obtention de l'id de l'abonnement et son montant mensuel

$("#nouvel_abonnement").change(function(){
   
 xhttp = initialisation();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "error") {

        toastr.error('Impossible de se connecter à la base de donné');
      }
      else {
       
        $("#montant_par_jour").val(this.responseText) ; 
       
       
      }
    }

  }

  xhttp.open("POST", "controllers/home.php", true);
  var formData = new FormData();
  formData.append("action", "get_abonnement_montant");
  formData.append("id",$(this).val());
  xhttp.send(formData); 



})
// Fin obtention


// Gestion d'envoie de mail

$("#envoie_message_button").click(function(){
 
 

var message = $('#summernote').summernote('code');

xhttp = initialisation();

  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "error") {

        toastr.error('Impossible de se connecter à la base de donné');
      }
      else {
        console.log(this.responseText) ; 
        console.log("je suis cliqué") ; 

       
      }
    }

  }

  xhttp.open("POST", "controllers/home.php", true);
  var formData = new FormData();
  formData.append("action", "envoie_mail");
  formData.append("message",message);
  xhttp.send(formData);


})


// Fin de la gestion d'envoi de mail

var client_libelle  = '' ; 
// Gestion enrégistrement payement

$("#client_payant").change(function(){
  client_libelle = $(this).data('placeholder') ; 
  console.log(client_libelle) ; 
  xhttp = initialisation();

  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "error") {

        toastr.error('Impossible de se connecter à la base de donné');
      }
      else {
       
        $("#motif_dette").html(" ") ;
        $("#motif_dette").append("<option>Séléctionné le motif de payement</option>" ) ;
       var resultat = JSON.parse(this.responseText) ;
       
        resultat.forEach(une_dette_info => { 
        option = "<option   value='"+une_dette_info.code+"' >"+une_dette_info.libelle+"</option>" ; 
        $("#motif_dette").append(option ) ;
        $("#montant_total").text(0) ; 
        $("#montant_restant").text(0) ;
        
        
        });
         

       
      }
    }

  }

  xhttp.open("POST", "controllers/home.php", true);
  var formData = new FormData();
  formData.append("action", "get_client_dette");
  formData.append("id_client",$(this).val());
  xhttp.send(formData);


})


// Fin Gestion enrégistrement payement

// Gestion de la sélection de la dette en question
$("#motif_dette").change(function(){
  console.log($(this).val()) ; 
  une_dette_details = $(this).val().split("-") ; 
  montant_dette = une_dette_details[1] ;
  if( une_dette_details[2] == "vide"){
    montant_restant = une_dette_details[1] ; 
  }
  else{
    montant_restant = une_dette_details[1] - une_dette_details[2] ; 
  } 
  
type_dette = une_dette_details[3] ;
$("#type_dette").val(type_dette)  ; 
$("#montant_total").text(montant_dette) ; 
$("#montant_restant").text(montant_restant) ; 

})

// Fin de la gestionde la dette



// Gestin du clique sur le boutton d'enregistrement de payement

$("#enregistrement_payement_submit_button").click(function(){
    
  if($("#client_payant").val() =="vide" || $("#motif_dette").val() ==""  || $("#payement_montant").val() == "" ){
    toastr.error('Désolé vous devez renseigné toutes les informations relatives au payement');
  }
  else{

    xhttp = initialisation();
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "error") {
  
          toastr.error('Impossible de se connecter à la base de donné');
          client = "[Néant]" ; 
        }
        else {
          
          var resultat =JSON.parse(this.responseText) ;
          $("#montant").text($("#payement_montant").val()) ; 
          $("#client").text(resultat.identifiant) ; 
          if(resultat.lib_dette == "vide"){
            $("#motif").text(" les frais d'installation ") ; 
          }
          else{
            $("#motif").text(resultat.lib_dette) ;
          }
          
          $("#confirmer_payement").modal('show'); 
        }
      }
  
    }
  
  
    xhttp.open("POST", "controllers/home.php", true);
    var formData = new FormData();
    formData.append("action", "get_client_info");
    formData.append("id_client",$("#client_payant").val());
    formData.append("type_dette",$("#type_dette").val())
    formData.append("id_dette",$("#motif_dette").val()) ; 
    xhttp.send(formData);
  

  } 
  
  

})
// Fin 

// Gestion du click confirmer sur le modal de confirmation de payement

$("#confirme_payement").click(function(){
  
  xhttp = initialisation();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "error") {

        toastr.error('Impossible de se connecter à la base de donné');
         
      }
      else {
        
       console.log(this.responseText) ; 
      }
    }
  }
  tableau = $("#motif_dette").val().split("-") ; 
  id_dette = tableau[0] ; 
  xhttp.open("POST", "controllers/home.php", true);
  var formData = new FormData();
  formData.append("action", "save_payement");
  formData.append("id_client",$("#client_payant").val());
  formData.append("id_dette",id_dette) ; 
  formData.append("montant_restant",$("#montant_total").text()) ;
  formData.append("type_dette",$("#type_dette").val()) ;
  formData.append("montant_paye",$("#payement_montant").val()) ;
  xhttp.send(formData);



})
// Fin


$(".debiteur").click(function(){
 var client = $(this).children().text().split("_")[0] ;
 var nom_client = $(this).children().text().split("_")[1] ;
 
  xhttp = initialisation();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "error") {

        toastr.error('Impossible de se connecter à la base de donné');
         
      }
      else {
        
      
       var resultat = JSON.parse(this.responseText) ;
      $("#dette_liste_body").html(" ") ;
      var total = 0 ;  
       resultat.forEach(une_dette_info => { 
         
         var decomposition_code = une_dette_info.code.split("-") ;
         total += parseInt(decomposition_code[1])  ; 
        une_dette = "<tr><td>"+une_dette_info.date+"</td><td>"+une_dette_info.libelle+"</td><td>"+decomposition_code[1]+"</td></tr>" ; 
        $("#dette_liste_body").append(une_dette ) ;
       
      })
      $("#total").text(total) ;
      $("#nom_client").text(nom_client) ; 
      $("#modal-historique-dette").modal('show');  
      
      
      
    }
      
    }
  }
  
  xhttp.open("POST", "controllers/home.php", true);
  var formData = new FormData();
  formData.append("action", "get_client_dette");
  formData.append("id_client",client);
  xhttp.send(formData); 
})


$("#close_dette_liste").click(function(){
  $("#modal-historique-dette").modal('hide');
})



//---- Code pour le déblocage

$(".deverouiller").click(function(){
  alert("je suis cliqué")  ; 
  var id_client = $(this).children().text() ;
  $("#confirmer_deblocage").modal('show')
  var info_client = $(this).parent().text().split("_") ; 
  $("#identifiant_client").text(info_client[0]) ;
  $("#code_client").text(info_client[1]) ;
 
})


 
$("#confirme_deblocage_button").click(function(){
  $("#confirmer_deblocage").modal('hide') ;
 var  client  = $("#code_client").text() ; 

  xhttp = initialisation();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "error") {

        toastr.error('Impossible de se connecter à la base de donné');
         
      }
      else {
        
      
       var resultat = JSON.parse(this.responseText) ;
       console.log(resultat) ;
       $("#client_coupe_body").html(" ");
       $("#client_coupe_body").text(" "); 
       resultat.forEach(un_client => {
        une_ligne = "<tr><td>"+un_client.identifiant+" <span class='deverouiller fa fa-lock' style='float:right'><p style='display:none'>"+un_client.id+"</p></span> </td></tr> " ;
        $("#client_coupe_body").append(une_ligne);
       });

       toastr.success("Client débloquer avec succès");
     
      
      
    }
      
    }
  }
  
  xhttp.open("POST", "controllers/home.php", true);
  var formData = new FormData();
  formData.append("action", "debloquer_client");
  formData.append("id_client",client);
  xhttp.send(formData)



})




$(".deverouiller").mouseover(function(){
  $(this).addClass("fa-unlock-alt") ; 
  $(this).removeClass("fa-lock") ; 
})

$(".deverouiller").mouseout(function(){
  $(this).removeClass("fa-unlock-alt") ; 
  $(this).addClass("fa-lock") ; 
})

//  Code  pour le blocage

$("#button_couper_client").click(function(){
 
  $("#modal_blocage").modal('show') ; 
  $("#button_bloquer").click(function(){
    $("#modal_blocage").modal('hide') ;
    clients = $("#client_bloquer").val() ; 
    xhttp = initialisation();
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "error") {
  
          toastr.error('Impossible de se connecter à la base de donné');
           
        }
        else {
          
        
        console.log(this.responseText) ; 
         var resultat = JSON.parse(this.responseText) ;
         console.log(resultat) ;
         $("#client_coupe_body").html(" ");
         $("#client_coupe_body").text(" "); 
         resultat.forEach(un_client => {
          une_ligne = "<tr><td>"+un_client.identifiant+" <span class='deverouiller fa fa-lock' style='float:right'><p style='display:none'>"+un_client.id+"</p></span> </td></tr> " ;
          $("#client_coupe_body").append(une_ligne);
         });
         $("#client_bloquer").val(" ") ;
         toastr.success("Client bloquer avec succès");  
      }
      
     
      
      }
    }
    
    xhttp.open("POST", "controllers/home.php", true);
    var formData = new FormData();
    formData.append("action", "bloquer_client");
    formData.append("clients",clients);
    xhttp.send(formData)

  })

})


function initialisation() {
  if (window.XMLHttpRequest) {
    // code for modern browsers
    xmlhttp = new XMLHttpRequest();
  } else {
    // code for old IE browsers
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  return xmlhttp;
};


function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }

}


var d = new Date();
  d.setTime(d.getTime() + (0 * 24 * 60 * 60 * 1000));
  var expires = "expires=" + d.toUTCString();

console.log(d.toUTCString())  ; 
console.log("je marche") ; 