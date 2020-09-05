

// loader
var loader = function () {
    setTimeout(function () {
      if ($('#ftco-loader').length > 0) {
        $('#ftco-loader').removeClass('show');
      }
    }, 1);
  };
  loader();
  $(function () {
    $('#example1').DataTable({
      'responsive': true,
      'autoWidth': false,
    });
  
  });
  
  
  
  
  
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
  
    if (duree == "" || montant_mensuel == "" || montant_remis == "" || $("#client_a_abonner").val().length == 0) {
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
      $("#enregistrement_abonnement_info").css("display","block") 
      $("#autre_abonnement").css("display", "block");
      $("#montant_mensuel").val(0);
  
  
    }
    else if($(this).val() == "frais-installation"){
  
      $("#autre_abonnement").css("display", "block");
      $("#montant_mensuel").val(0);
      $("#enregistrement_abonnement_info").css("display","none") ;
      $("#frais_installation").css("display","block") ;
   
      
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
    else if ($(this).val() != "Autre" && $(this).val() != "vide") {
      $("#enregistrement_abonnement_info").css("display","block") 
      $("#autre_abonnement").css("display", "none");
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
    console.log($("#installation_montant").val()) ; 
    clients = $("#client_a_abonner").val();
  
    for (var i = 0; i < clients.length; i++) {
  
      clients[i] = clients[i].replace("_", " ");
    }
    console.log($(clients)) ; 
  })
  
  // Fin enregistrement frais installations
   
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
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