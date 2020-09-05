<?php
require("app/usine.php");
$liste_des_clients = array();
$liste_des_abonnements = array() ;
$info_clients = array() ;  

$connection = usine::lancer_une_connection();
$status_connection = " ";
if ($connection == "data-base-connection-error") { 
  $status_connection = "non_etablie";

} 
else {

  $titre_de_la_page = "Home" ;
  $status_connection = "etablie";
  $requette_liste_client = $connection->query("SELECT   * FROM client ");
  $liste_abonnement_requette = $connection->query("SELECT * FROM abonnement");


  while ($liste_abonnements = $liste_abonnement_requette->fetch()){
    $liste_des_abonnements[]  = [ 
      "id" => $liste_abonnements["id"],
      "lib_abonnement" => $liste_abonnements["lib_abonnement"]
    ] ; 
  }


  while ($liste_clients = $requette_liste_client->fetch()) {

    if ($liste_clients['type_client'] == "personnel") {
      $client_nom = $liste_clients["nom"] . " " . $liste_clients["prenom"];
      $client_nom_value = $liste_clients["id"];
    } else {
      $client_nom = $liste_clients["nom_societe"];
      $client_nom_value = $liste_clients["id"];
    }
    $liste_des_clients[] = [
      "client_nom" => $client_nom,
      "client_nom_value" => $client_nom_value

    ];
  }

  $requette_info = $connection->query("SELECT * FROM client") ; 
        while($reponse = $requette_info->fetch()){
            $id="";
            $type= " " ; 
            $status= " ";
            $identifiant = " " ; 
            $abonnement = " " ; 
            $debut =" " ; 
            $fin = " " ; 

            $id = $reponse["id"] ; 
            $type = $reponse["type_client"] ; 
            if($type =="entreprise"){
                $identifiant = $reponse["nom_societe"] ; 
            }
            elseif($type =="personnel"){
                $identifiant = $reponse["nom"]."  ".$reponse["prenom"] ; 
            }
            $status = $reponse["status"] ;
            
            if($status == "couper"){
                $abonnement = "" ;
                $debut = "" ; 
                $fin = "" ;
                  
            }
            elseif($status=="debiteur" || $status=="regulier"){
               $get_abonnement_en_cours_requette = $connection->prepare("SELECT  MAX(id) FROM abonner WHERE client_id = ?") ; 
               $get_abonnement_en_cours_requette->execute([$reponse["id"]]) ; 
               $result = $get_abonnement_en_cours_requette->fetch() ;
               
               if($result["MAX(id)"] == ""){
                   $abonnement = "" ; 
               }
               else{

                $get_abonnement_infos = $connection->prepare("SELECT abonnement_id , date_debut,date_fin FROM abonner WHERE id = ?") ; 
                $get_abonnement_infos->execute([$result["MAX(id)"]]) ; 
                $abonnement_info = $get_abonnement_infos->fetch() ; 

                $get_abonnement_libelle_requette = $connection->prepare("SELECT lib_abonnement FROM abonnement WHERE id = ?") ; 
                $get_abonnement_libelle_requette->execute([$abonnement_info["abonnement_id"]]) ; 
                $abonnement_lib = $get_abonnement_libelle_requette->fetch(); 
                
                $abonnement = $abonnement_lib["lib_abonnement"] ;
                
               
                $date_debut = getdate( $abonnement_info["date_debut"]);
			    $debut = $date_debut["mday"] . "/" . $date_debut["mon"] . "/" . $date_debut["year"];
	
			    $date_fin = getdate( $abonnement_info["date_fin"]);
			    $fin = $date_fin["mday"] . "/" . $date_fin["mon"] . "/" . $date_fin["year"];
	
               
               }
               
            }


            $info_clients[] = [
                  'id' => $id ,
                'type'=> $type , 
                'identifiant' => $identifiant , 
                'status'  => $status ,
                'abonnement'  => $abonnement , 
                'debut' => $debut ,
                'fin'  => $fin


            ] ; 

            
        }


}

echo "<input id='status_connection' type='text' value='" . $status_connection . "' style='display:none '>";


?>

<?php $titre_de_la_page = "Home"; ?>
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
        <link rel="stylesheet" href="public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        



    ';

$cssLink  = ob_get_clean();

?>




<!--Zone montrant affichant les 4 cadres start-->
<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>400</h3>

        <p>Nombre de clients</p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="#" class="small-box-footer">Plus de détails <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>53%</h3>

        <p>Satisfaction des clients</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="#" class="small-box-footer">Plus de détails <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>10</h3>

        <p>Clients nous doivent</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="#" class="small-box-footer">Plus de détails <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>65</h3>

        <p>Plaintes en cours</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="#" class="small-box-footer">Plus de détails<i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>
</div>


<!--Zone montrant affichant les 4 cadres end-->
<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <section class="col-lg-6 connectedSortable">
    <div class="card ">
      <!--header-->
      <div class="card-header" id="enregistre_payement_block">
        <h3 class="card-title">Enrégistrer un payement</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- body -->

      <div class="card-body">

      
      <div class="col-md-12">
                <!-- USERS LIST -->
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title" style='color:black'>Latest Members</h3>

                    <div class="card-tools">
                      <span class="badge badge-danger">8 New Members</span>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <ul class="users-list clearfix">
                      <li>
                        <img src="dist/img/user1-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Alexander Pierce</a>
                        <span class="users-list-date">Today</span>
                      </li>
                      <li>
                        <img src="dist/img/user8-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Norman</a>
                        <span class="users-list-date">Yesterday</span>
                      </li>
                      <li>
                        <img src="dist/img/user7-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Jane</a>
                        <span class="users-list-date">12 Jan</span>
                      </li>
                      <li>
                        <img src="dist/img/user6-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">John</a>
                        <span class="users-list-date">12 Jan</span>
                      </li>
                      <li>
                        <img src="dist/img/user2-160x160.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Alexander</a>
                        <span class="users-list-date">13 Jan</span>
                      </li>
                      <li>
                        <img src="dist/img/user5-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Sarah</a>
                        <span class="users-list-date">14 Jan</span>
                      </li>
                      <li>
                        <img src="dist/img/user4-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Nora</a>
                        <span class="users-list-date">15 Jan</span>
                      </li>
                      <li>
                        <img src="dist/img/user3-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Nadia</a>
                        <span class="users-list-date">15 Jan</span>
                      </li>
                    </ul>
                    <!-- /.users-list -->
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer text-center">
                    <a href="javascript::">View All Users</a>
                  </div>
                  <!-- /.card-footer -->
                </div>
                <!--/.card -->
              </div>

      </div>
      </div>

  </section>

  <!-- liste des plaintes -->
  <section class="col-lg-6 connectedSortable">
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
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><a href="pages/examples/invoice.html">10/05/20 à 14:50</a></td>
                <td>Net By Us <span class="badge bg-danger">NEW</span> </td>
                <td>Perte de connexion</td>
                <td>
                  <div class="sparkbar" data-color="#00a65a" data-height="20"><a class="btn btn-success btn-sm" href="#">
                      <i class="fas fa-check"></i>
                      Valider
                    </a></div>
                </td>
              </tr>

              <tr>
                <td><a href="pages/examples/invoice.html">11/05/20 à 23:10</a></td>
                <td>Cocou Jean </td>
                <td>Perte de connexion</td>
                <td>
                  <div class="sparkbar" data-color="#00a65a" data-height="20"><a class="btn btn-success btn-sm" href="#">
                      <i class="fas fa-check"></i>
                      Valider
                    </a></div>
                </td>
              </tr>

              <tr>
                <td><a href="pages/examples/invoice.html">11/05/20 à 23:10</a></td>
                <td>ESGIS </td>
                <td>Débit très faible</td>
                <td>
                  <div class="sparkbar" data-color="#00a65a" data-height="20"><a class="btn btn-success btn-sm" href="#">
                      <i class="fas fa-check"></i>
                      Valider
                    </a></div>
                </td>
              </tr>

              <tr>
                <td><a href="pages/examples/invoice.html">11/05/20 à 23:10</a></td>
                <td>Francois Louis </td>
                <td>Problème de démarrage du routeur</td>
                <td>
                  <div class="sparkbar" data-color="#00a65a" data-height="20"><a class="btn btn-success btn-sm" href="#">
                      <i class="fas fa-check"></i>
                      Valider
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

</div>
<!-- /.content-wrapper -->




<section>
  <div class='row'>
    <div class="col-lg-6 connectedSortable">
      <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title" style='color:white'>Enrégistré un abonnement</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus" style='color:white'></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand" style='color:white'></i>
            </button>

          </div>
          <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
       
                <div class="row">
                  <div class="col-md-12">
                    <div class="chart-responsive">
                    <canvas class="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>                    </div>
                    <!-- ./chart-responsive -->
                  </div>
                  <!-- /.col -->
                  
                  <!-- /.col -->
                </div>
                <!-- /.row -->
        </div>
    </div>

    </div>
    <div class="col-lg-6 connectedSortable">
      <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title" style='color:white'>Enrégistré un abonnement</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus" style='color:white'></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand" style='color:white'></i>
            </button>

          </div>
          <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
       
                <div class="row">
                  <div class="col-md-12">
                    <div class="chart-responsive">
                    <canvas class="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>                    </div>
                    <!-- ./chart-responsive -->
                  </div>
                  <!-- /.col -->
                  
                  <!-- /.col -->
                </div>
                <!-- /.row -->
        </div>
    </div>


  </div>
 
        
    <!-- Gestion de la campagne mail  start -->
</section>  

<!--situation des clients start-->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12   connectedSortable">
        <div class="card card-success">
          <!--header-->
          <div class="card-header ">
            <h3 class="card-title">Situation des clients</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- body -->
          <div class="card-body p-2">
            <div class="table-responsive">
              
            <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Sales</h3>
                  <a href="javascript:void(0);">View Report</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">$18,230.00</span>
                    <span>Sales Over Time</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 33.1%
                    </span>
                    <span class="text-muted">Since last month</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> This year
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Last year
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->

           
          </div>


            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</section>


<!--situation des clients end-->

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
<script src='public/plugins/summernote/summernote-bs4.min.js'></script>

<!-- OPTIONAL SCRIPTS -->
<script src='public/plugins/chart.js/Chart.min.js'></script>
<script src='public/dist/js/demo.js'></script>
<script src='public/dist/js/pages/dashboard3.js'></script>
<script src='public/dist/js/pages/dashboard2.js'></script>

<script src='public/plugins/chart.js/Chart.min.js'></script>


<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })
</script>

<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

   

    

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('.donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Chrome', 
          'IE',
          'FireFox', 
          'Safari', 
          'Opera', 
          'Navigator', 
      ],
      datasets: [
        {
          data: [700,500,400,600,300,100],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions      
    })

    

    var stackedBarChart = new Chart(stackedBarChartCanvas, {
      type: 'bar', 
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })
</script>

    ";
$jsLink = ob_get_clean();

?>