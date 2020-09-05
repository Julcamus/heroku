<?php   

// Code de gestion des traitements liés a la page de gestion de tickets
$titre_de_la_page = "Gestion de tickets" ;
header('Content-Type: text/html; charset=utf8_general_ci') ; 

require("app/usine.php");

$tickets = array();
$clients = array() ; 
$liste_des_abonnements = array() ;
$info_clients = array() ;  

$connection = usine::lancer_une_connection();
$status_connection = " ";
if ($connection == "data-base-connection-error") { 
  $status_connection = "non_etablie";

} 
else {

  $status_connection = "etablie";

  /* obtention des informations relatives aux ticket de notre base */

    $get_tickets_requette = $connection->query("SELECT * FROM tickets") ; 
    $reponse_tickets = $get_tickets_requette->fetchAll() ;
    foreach($reponse_tickets as $un_ticket){
      $id = $un_ticket["id"] ; 
      $libelle = $un_ticket["libelle"] ; 
      $categorie = $un_ticket["categorie"] ;
      $status = $un_ticket["status"] ; 
      $date_ouverture = $un_ticket["date_ouverture"] ; 

      $tickets[] = [
        "id" =>$id ,
        "libelle" =>$libelle,
        "categorie" => $categorie,
        "status" => $status ,
        "date_ouverture" =>$date_ouverture

      ] ; 
    } 

   
  /* Fin de l'obtention des informations relatives aux tickets */


  /* obtention des informations relatives aux clients de notre base */

  $clients_requette = $connection->query("SELECT id,nom,prenom,nom_societe,type_client FROM client ") ; 
  $clients_liste = $clients_requette->fetchAll() ;
  
  foreach($clients_liste as $un_client){
    $id = $un_client["id"] ;
    if($un_client["type_client"] == "personnel"){
      $identifiant = $un_client["nom"]." ".$un_client["prenom"] ;  
    }
    elseif($un_client["type_client"] == "entreprise"){
      $identifiant = $un_client["nom_societe"] ; 
    }
    

    $clients[] = [
      "id" =>$id ,
      "identifiant" =>$identifiant
    
    ] ; 
  } 

sort($clients) ; 
/* Fin de l'obtention des informations relatives aux clients */
    





  }


echo "<input id='status_connection' type='text' value='" . $status_connection . "' style='display:none '>";


?>


<?php
ob_start();
echo '   

       <link rel="stylesheet" href="public/plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="public/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
        <link rel="stylesheet" href="public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="public/dist/css/adminlte.min.css">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
         <!--liste_client_page_css_additionnel -->
        <link rel="stylesheet" href="public/dist/css/home.css">
        <link rel="stylesheet" href="public/dist/css/gestion-tickets.css">
        <meta charset="utf-8">



    ';

$cssLink  = ob_get_clean();

?>

<div class="container">
<!-- Ouverture ticket -->   
<div><button  id='ouvrir_ticket_button' class="btn btn-primary">Ouvrir ticket</button></div>
</div><br><br>

<div class="container">
  <div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Liste des plaintes en cours</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </button>
        </div>
        <!-- /.card-tools -->
      </div>
      <!-- /.card-header -->
      <!-- body -->
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table m-0">
            <thead>
              <tr>
                <th>Date</th>
                <th>Nom client</th>
                <th>Type de plainte</th>
                <th>Nombre d'intervention</th>
                <th>Enrégistré une intervention</th>
                <th>Cloturer le ticket</th>
                
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><a href="pages/examples/invoice.html">10/05/20 à 14:50</a></td>
                <td>Net By Us <span class="badge bg-danger">NEW</span> </td>
                <td>Perte de connexion</td>
                <td></td>
                <td></td>
                <td>
                  <div class="sparkbar" data-color="#00a65a" data-height="20"><a class="btn btn-success btn-sm" href="#">
                      <i class="fas fa-check"></i>
                      Cloturer
                    </a></div>
                </td>
              </tr>

              <tr>
                <td><a href="pages/examples/invoice.html">11/05/20 à 23:10</a></td>
                <td>Cocou Jean </td>
                <td>Perte de connexion</td>
                <td></td>
                <td></td>
                <td>
                  <div class="sparkbar" data-color="#00a65a" data-height="20"><a class="btn btn-success btn-sm" href="#">
                      <i class="fas fa-check"></i>
                      Cloturer
                    </a></div>
                </td>
              </tr>

              <tr>
                <td><a href="pages/examples/invoice.html">11/05/20 à 23:10</a></td>
                <td>ESGIS </td>
                <td>Débit très faible</td>
                <td></td>
                <td></td>
                <td>
                  <div class="sparkbar" data-color="#00a65a" data-height="20"><a class="btn btn-success btn-sm" href="#">
                      <i class="fas fa-check"></i>
                      Cloturer
                    </a></div>
                </td>
              </tr>

              <tr>
                <td><a href="pages/examples/invoice.html">11/05/20 à 23:10</a></td>
                <td>Francois Louis </td>
                <td>Problème de démarrage du routeur</td>
                <td></td>
                <td></td>
                <td>
                  <div class="sparkbar" data-color="#00a65a" data-height="20"><a class="btn btn-success btn-sm" href="#">
                      <i class="fas fa-check"></i>
                      Cloturer
                    </a></div>
                </td>
              </tr>

            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>
      <!-- /.card-body -->
    </div>
  </section>
  </div><br><br>

  <div class="row" style="text-align:center"><p style="text-align:center;font-size:30px;font-weight:bold">Cousulter la banque d'interventions</p> </div><br>
<!-- 
      Section de la banque
-->
  <div class="row">
  <section class="col-lg-6 connectedSortable">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Filtre de recherche</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
     
      <div class="card-body p-0">
        
        <div class="container-fluid">
            <br>
                  <div class="row">
                     <div class="col-lg-12">
                      <label>Critère de recherche : </label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12">
                      <select class="select2"  id="client_id" data-placeholder="Séléctionné le client concerné" style="width: 100%;">
                      <option value="">Sélectionné votre critére de recherche</option>
                      <option value="vide">Par client</option>
                        <option value="">Par libellé</option>
                        <option value="">Par catégorie</option>
                      </select>
                    </div>
                  </div>
                  <br>
                  <!-- client file -->
                  <div id="client_filtre">
                  <div class="row">
                     <div class="col-lg-12">
                      <label>Séléctionné le client : </label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12">
                      <select class="select2"  id="client_id" data-placeholder="Séléctionné le client concerné" style="width: 100%;">
                      <option value="vide">Sélectionné le client</option>
                        <?php
                       
                            if(count($clients) != 0){
                                foreach($clients as $un_client){
                                   echo "<option value='".$un_client["id"]."' >".$un_client["identifiant"]."</option>" ;
                                }
                            }
                        ?>
                      </select>
                    </div>
                  </div>
                  <br>

                  </div>
                  <!-- End client file -->

                <!-- libelle filtre -->
                <div id="client_filtre">
                  <div class="row">
                     <div class="col-lg-12">
                      <label>Séléctionné le libellé : </label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12">
                      <select class="select2"  id="client_id" data-placeholder="Séléctionné le client concerné" style="width: 100%;">
                      <option value="vide">Sélectionné le libellé de votre choix</option>
                        <?php
                       
                            if(count($clients) != 0){
                                foreach($clients as $un_client){
                                   echo "<option value='".$un_client["id"]."' >".$un_client["identifiant"]."</option>" ;
                                }
                            }
                        ?>
                      </select>
                    </div>
                  </div>
                  <br>

                  </div>
                  <!-- End libelle filtre -->
                  
                 <!-- categorie filtre -->
                 <div id="client_filtre">
                  <div class="row">
                     <div class="col-lg-12">
                      <label>Séléctionné la catégorie : </label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12">
                      <select class="select2"  id="client_id" data-placeholder="Séléctionné le client concerné" style="width: 100%;">
                      <option value="vide">Sélectionné la catégorie de votre choix</option>
                        <?php
                       
                            if(count($clients) != 0){
                                foreach($clients as $un_client){
                                   echo "<option value='".$un_client["id"]."' >".$un_client["identifiant"]."</option>" ;
                                }
                            }
                        ?>
                      </select>
                    </div>
                  </div>
                  <br>

                  </div>
                  <!-- End categorie filtre -->
                <!-- button div -->
                    <div class="row">
                      <div class="col-lg-12">
                        <button class="btn btn-primary" style="width:100%;font-size:20px;">Lancer la recherche</button>
                      </div>
                    </div> <br>     
                <!-- End button div -->  
                  
          </div>
       
      </div>
      <!-- /.card-body -->
    </div>
  </section>

  <section class="col-lg-6 connectedSortable">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Informations</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </button>
        </div>
        <!-- /.card-tools -->
      </div>
      <!-- /.card-header -->
      <!-- body -->
      <div class="card-body p-0">
        
        <!-- /.table-responsive -->
      </div>
      <!-- /.card-body -->
    </div>
  </section>

  </div>



</div>











<?php require "modals.php" ?>


<?php

ob_start();

echo " 

     
<!-- DataTables -->
<script src='public/plugins/datatables/table.js'></script>
<script src='public/plugins/datatables-bs4/js/dataTables.bootstrap4.js'></script>
<script src='public/plugins/datatables-responsive/js/dataTables.responsive.min.js'></script>
<script src='public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'></script>
<!-- AdminLTE App -->
<script src='public/dist/js/adminlte.min.js'></script>
<!-- AdminLTE for demo purposes -->
<script src='public/dist/js/demo.js'></script>
<script src='public/dist/js/home.js'></script>
<script src='public/dist/js/gestion-tickets.js'></script>
<script src='public/plugins/summernote/summernote-bs4.min.js'></script>
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })
</script>

    ";
$jsLink = ob_get_clean();

?>