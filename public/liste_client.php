<?php
      require("app/usine.php") ; 
      $connection = usine::lancer_une_connection();
      $status_connection = " " ; 
      if( $connection == "data-base-connection-error"){
         $status_connection = "non_etablie" ; 
      }
      else{
          $status_connection = "etablie" ;
          $requette_liste_client = $connection->query("SELECT   id,date_enregistrement,nom,prenom,nom_societe,ip,type_client FROM client ");
      
      
      }

      echo "<input id='status_connection' type='text' value='".$status_connection."' style='display:none'>" ;
      

?>

<?php $titre_de_la_page = "Liste des clients"; ?>


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
        <link rel="stylesheet" href="public/dist/css/liste_client.css">


 		';

$cssLink  = ob_get_clean();

?>




<div>
  <!-- Content Header (Page header) -->
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Liste des clients</h3>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th class="tete">Identifiant</th>
                    <th class="tete">Type</th>
                    <th class="tete">IP</th>
                    <th class="tete">Date d'enregistrement</th>
                    <th class="tete">Actions</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  if ($status_connection == "etablie") {

                    while ($resultat = $requette_liste_client->fetch()) {
                      if ($resultat["type_client"] == "personnel") {
                        $identifiant = $resultat["nom"] . "   " . $resultat["prenom"];
                      } elseif ($resultat["type_client"] == "entreprise") {
                        $identifiant = $resultat["nom_societe"];
                      }
                      $type = $resultat["type_client"];
                      $ip = $resultat["ip"];
                      $date = getdate($resultat["date_enregistrement"]);
                      $date_chaine = $date["mday"] . "/" . $date["mon"] . "/" . $date["year"];
                      $id = $resultat["id"];


                      echo "
                          <tr>
                            <td>" . $identifiant . "</td>
                            <td>" . $type . "</td>
                            <td>" . $ip . "</td>
                            <td>$date_chaine</td>
                            <td>
                            <form    method='POST'>
                            
                              <button id='modif_" . $id . "' name='modifier' type='submit'  class='btn btn-primary-outline modifier' style=' background-color: none;outline:none'><i class='fas fa-edit action1' ></i></button>
                              <button  id='supprimer_" . $id . "'  type='submit'  class='btn btn-primary-outline supprimer' style=' background-color: none;outline:none'><i class='fas fa-trash action2' ></i>
                              </button>
                              <button  id='afficher_" . $id . "' type='submit' class='btn btn-primary-outline afficher' style=' background-color: none;outline:none'> <i class='fas fa-eye action3' ></i>
                              </button>
                           </form>
                           
                           
                              </td>
                          </tr>
                          
                          ";
                    }
                  }




                  ?>

                </tbody>

              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->




<?php require "modals.php" ?>



<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>


<?php

ob_start();

echo " 
<script  src='public/dist/js/liste_client.js'></script>'>
			<script src='public/plugins/jquery/jquery.min.js'></script>
<!-- jQuery UI 1.11.4 -->
<script src='public/plugins/jquery-ui/jquery-ui.min.js'></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- jQuery -->
<script src='public/plugins/jquery/jquery.min.js'></script>
<!-- Bootstrap 4 -->
<script src='public/plugins/bootstrap/js/bootstrap.bundle.min.js'></script>
<!-- DataTables -->
<script src='public/plugins/datatables/table.js'></script>
<script src='public/plugins/datatables-bs4/js/dataTables.bootstrap4.js'></script>
<script src='public/plugins/datatables-responsive/js/dataTables.responsive.min.js'></script>
<script src='public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'></script>
<!-- AdminLTE App -->
<script src='public/dist/js/adminlte.min.js'></script>
<!-- AdminLTE for demo purposes -->
<script src='public/dist/js/demo.js'></script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable({
      'responsive': true,
      'autoWidth': false,
    });
    $('#example2').DataTable({
      'paging': true,
      'lengthChange': false,
      'searching': false,
      'ordering': true,
      'info': true,
      'autoWidth': false,
      'responsive': true,
    });
  });
</script>

<script>
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});


</script>



		";
$jsLink = ob_get_clean();

?>