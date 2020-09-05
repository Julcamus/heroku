// Préliminaire



if ($("#status_connection").val() == "non_etablie") {

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
});

}



$("#ouvrir_ticket_button").click(function(){
$("#modal_ajout_ticket").modal('show');
})


/*$("#ouvrir_ticket").click(function(){

    var libelle = "" ; 
    var categorie = "" ; 
    var description = "" ;
    var document = " " ;

 document =  $("#ticket_document").val() ; 
 libelle = $("#libelle").val() ; 
 categorie = $("#categorie").val() ; 
 description = $("#description").val() ; 
client = $("#client_id").val() ;
console.log(client) ;  



xhttp = initialisation();
xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
    if (this.responseText == "error") {
        toastr.error('Impossible de se connecter à la base de donné');
    }
    else {
        alert(this.responseText) ; 
    }
    }

}

xhttp.open("POST", "controllers/gestion-tickets.php", true);
var formData = new FormData();
formData.append("action", "ouvrir_ticket");
formData.append("client", client);
formData.append("libelle", libelle);
formData.append("categorie",categorie);
formData.append("description", description);
formData.append("document", document);

xhttp.send(formData);
})

*/

$("#form_ouverture_ticket").submit(function(e){
    var form = document.querySelector("#form_ouverture_ticket") ; 
    e.preventDefault() ; 
    xhttp = initialisation() ; 
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          
          
                console.log(this.responseText) ; 
         
        }
      };
    xhttp.open("POST", "controllers/gestion-tickets.php", true);
    var formData = new FormData(form) ; 
    xhttp.send(formData); 
})




/*  Fonctions exploités dans mon code */

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
  