<?php
 $titre_de_la_page = "Gestion abonnement " ;
 
require("app/usine.php");
$liste_des_clients = array();
$liste_des_abonnements = array() ;
$info_clients = array() ;
$liste_des_proches = array() ;   

$connection = usine::lancer_une_connection();
$status_connection = " ";
if ($connection == "data-base-connection-error") { 
  $status_connection = "non_etablie";

} 
else {

 
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
      "client_nom_value" => $client_nom_value ,
      "status" => $liste_clients["status"]

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
//---------------------------------------------------------------------------
$liste_des_proches = array();
$liste_date_fin_requette = $connection->prepare("SELECT id,client_id , date_fin FROM abonner WHERE date_fin > ?  AND date_fin < ? ") ;
$liste_date_fin_requette->execute([time()-(86400*5),time() + (86400*5)]) ;

//$liste_date_fin_requette = $connection->query("SELECT  date_fin FROM abonner  ") ;

$reponse = $liste_date_fin_requette->fetchAll() ; 
foreach($reponse as $element){
    $date = getdate(time()) ;
    $aujourdhui = $date["mday"] . "-" . $date["mon"] . "-" . $date["year"];
    
    $date = getdate($element["date_fin"]) ;
    $date_fin = $date["mday"] . "-" . $date["mon"] . "-" . $date["year"];
    
    $identifiant_requette = $connection->prepare("SELECT nom,prenom,nom_societe,type_client FROM client WHERE id = ?") ; 
    $identifiant_requette->execute([$element["client_id"]]) ; 
    $reponse2 = $identifiant_requette->fetch() ; 
    if($reponse2["type_client"] ==  "personnel"){
        $identifiant = $reponse2["nom"]." ".$reponse2["prenom"] ; 
    }
    elseif($reponse2["type_client"] ==  "entreprise"){
        $identifiant = $reponse2["nom_societe"] ;
    }
   
    if($date_fin < $aujourdhui ){
        $jour = round(abs((time() - $element['date_fin'])/86400 ))   ;
        $liste_des_proches [] = [
             "jour" => $jour ,
             "status"  => "passe",
             "identifiant" =>$identifiant
              
        ] ; 
       
    }
    elseif($date_fin > $aujourdhui){
        $jour = round(abs((time() - $element['date_fin'])/86400 ))   ;
        $liste_des_proches [] = [
             "jour" => $jour ,
             "status"  => "futur",
             "identifiant" =>$identifiant
        ] ; 
    }
    else{
        $liste_des_proches [] = [
            "jour" => 0 ,
            "status"  => "present" ,
            "identifiant" =>$identifiant
       ] ;  
    }

}

echo "<input id='status_connection' type='text' value='" . $status_connection . "' style='display:none '>";
}

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



    ';

$cssLink  = ob_get_clean();

?>





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

        <div class="row">
          <div class="col-lg-12">
            <select class="select2" id="client_payant" data-placeholder="Séléctionné le client qui a payé" style="width: 100%;">
              <option value="vide" >Sélectionné le client</option>
              <?php
                        if(count($liste_des_clients) != 0){
                           foreach ($liste_des_clients as $un_client) {
                            echo " 
                                <div class='normal_abonnement'>
                              <option value='" . $un_client["client_nom_value"] . "' >" . $un_client["client_nom"] . " 
                              </option>
                              </div>
                            ";
                    }
                        }
                         
                      
                      ?>

            </select>
          </div>

        </div>
        <br>
        <div class="container-flud">
          <div class="row">
            <div class="col-lg-6">
              <label>Motif du payement : </label>
            </div>
            
            <div class="col-lg-6">
              <select class="form-control" id="motif_dette" style="width:100%">
                        <option value="">Le motif du payement</option>
              </select>
            </div>
          </div>
        </div>
        <br>
        
        <div class="container-flud">
          <div class="row">
            <div class="col-lg-6">
              <label>Montant total : </label>
              <input type="text" id="type_dette" style='display:none'>
            </div>
            
            <div class="col-lg-6">
              <span id='montant_total'>0</span>  FCFA
            </div>
          </div>
        </div>
        <br>

        <div class="container-flud">
          <div class="row">
            <div class="col-lg-6">
              <label>Montant restant à payer : </label>
            </div>
            
            <div class="col-lg-6">
              <span id="montant_restant">0</span>  FCFA
            </div>
          </div>
        </div>
        <br>


        <div class="container-flud">

          <div class="row">
            <div class="col-lg-4">

              <label>Montant payé: </label>
            </div>
            <div class="col-lg-2"></div>
            <div class="col-lg-3">
              <input class="form-control" type="number" name=""  id='payement_montant' style="width: 100%">
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-2">
              FCFA
            </div>
          </div>
        </div>

        <br>
        
        <div class="container-fluid">

          <div class="row">
            <div class="card-footer clearfix">
              <button class="btn btn-sm btn-info " id="enregistrement_payement_submit_button" >Enrégistrer le payement</button>

            </div>
          </div>

        </div>

      </div>

  </section>

  <!-- liste des plaintes -->
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
          <div class="container-flud">
            <div class="row">
              <div class="col-lg-4">
                <label>Type d'offre : </label>
              </div>
              <div class="col-lg-2"></div>
              <div class="col-lg-6">
                <input type="" name="" style="display:none" id="id_abonnement">
                <select class="form-control" id="abonnement_choisi">
                  <option value="vide">choisisez le type d'abonnement</option>
                 
                  <?php 
                    if(count($liste_des_abonnements) != 0){
                      foreach($liste_des_abonnements as $un_abonnement){
                        echo " 
                        <div class='normal_abonnement'>
                       <option >". $un_abonnement["lib_abonnement"] . "
                       </option>
                       </div>
                       ";
                      }
                    }
                  
                  ?>


                  <option value="frais-installation">Enrégistrer les frais d'installation</option>
                  <option value="changement_offre">Effèctué un changement d'offre pour un abonnement en cours</option>

                  <div id="autre">
                    <option value="Autre">Autres</option>
                  </div>

                </select>
              </div>
            </div>
          </div>
          <div id="abonnement_info_et_selection_client">
            <div id="body_abonnement_info">
              <div class="container-flud" id="autre_abonnement">
                <br>
                <div class="row">
                  <div class="col-lg-4">

                    <label>Libellé: </label>
                  </div>
                  <div class="col-lg-2"></div>
                  <div class="col-lg-6">
                    <input type="text" class="form-control" id="libelle_autre">
                  </div>


                </div>
                <br>
                <div class="row" id="">
                  <div class="col-lg-4">

                    <label>Débit: </label>
                  </div>
                  <div class="col-lg-2"></div>
                  <div class="col-lg-3">
                    <input type="number" min="1" class="form-control" id="debit_autre">
                  </div>
                  <div class="col-lg-1"></div>
                  <div class="col-lg-2">Mbps</div>
                </div>
              </div>

              <br>
              <div class="container-flud">

                <div class="row">
                  <div class="col-lg-4">
                    <label>Durée : </label>
                  </div>
                  <div class="col-lg-2"></div>
                  <div class="col-lg-3">
                    <input id='duree' class="form-control" min="1" type="number" required>

                  </div>
                  <div class="col-lg-1"></div>
                  <div class="col-lg-2">
                    <span>Mois</span>
                  </div>
                </div>
              </div>

              <br>
              <div class="container-flud">

                <div class="row">
                  <div class="col-lg-4">
                    <label>Montant mensuel : </label>
                  </div>
                  <div class="col-lg-2"></div>
                  <div class="col-lg-3">
                    <input id="montant_mensuel" class="form-control" min="1" type="number">

                  </div>
                  <div class="col-lg-1"></div>
                  <div class="col-lg-2">
                    <span>FCFA</span>
                  </div>
                </div>
              </div>


            </div>
            <br>
            <!-- Zone pour enregistrer les frais d'installation -->
            <div class="container-flud" id="frais_installation_zone" style="display: none;">
              <div class="row">
                <div class="col-lg-5">
                  <label>Frais d'installation : </label>
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-3">
                  <input id="installation_montant" class="form-control" min="1" type="number">

                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-2">
                  <span>FCFA</span>
                </div>
              </div>
            </div>
            <!-- End zone enregistrement des frais d'installation -->
            <div class="container-flud">
              <div class="row">
                <div class="col-lg-12">
                  <label>Sélectionné les clients : </label>
                </div>

              </div>

              <div class="row">
                <div class="col-lg-12">
                  <select class="select2" multiple="multiple" id="client_a_abonner" data-placeholder="Séléction du client" required>

                  <?php
                      if(count($liste_des_clients) != 0){
                        foreach ($liste_des_clients as $un_client) {
                    
                          echo " 
                                <div class='normal_abonnement'>
                                <option  >" . $un_client["client_nom"] . " 
                                </option>
                              </div>
                              ";
                        }
                      }
                  ?>




                  </select>
                </div>

              </div>
            </div>
          </div> <!-- End abonnement info  et selection client -->
          <br>
          <!-- Debut zone pour changement d'offre -->
        <div id="changement_offre_zone" style="display:none" >
          <div class="row"  >
            <div class="col-lg-12">
              <select class="select2" id="client_a_modifier_offre" data-placeholder="Séléction du client" required>
                      <option value="">Choisir un client</option>
               
                      <?php
                        if(count($liste_des_clients) != 0){
                           foreach ($liste_des_clients as $un_client) {
                            echo " 
                                <div class='normal_abonnement'>
                              <option value='" . $un_client["client_nom_value"] . "' >" . $un_client["client_nom"] . " 
                              </option>
                              </div>
                            ";
                    }
                        }
                         
                      
                      ?>



              </select>
            </div>
          </div><br>
          <div class="row">
            <div class="col-lg-5">
              <label>Offre en cours : </label>
            </div>
            <div class="col-lg-7">
              <span  id="offre_en_cours"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-5">
              <label>Nombre de jours restants : </label>
              <input type="number" id="nombre_jours_restant_value" style="display:none"> 
            </div>
            <div class="col-lg-7">
              <span  id="nombre_jours_restant" ></span><span id="jours"></span> 
            </div>
          </div>

          <div class="row">
              <div class="col-lg-5">
                <label>Nouvel offre: </label>
              </div>
              <div class="col-lg-7">
                <input type="" name="" style="display:none" >
                <select class="form-control" id="nouvel_abonnement" >
                  <option value="vide">choisisez le type d'abonnement</option>
                 
                  <?php 
                    if(count($liste_des_abonnements) != 0){
                      foreach($liste_des_abonnements as $un_abonnement){
                        echo " 
                        <div class='normal_abonnement'>
                       <option value='" . $un_abonnement["id"] . "' >" . $un_abonnement["lib_abonnement"] . "
                       </option>
                       </div>
                       ";
                      }
                    }
                  
                  ?>

                 

                </select>
              </div>
            </div>

            <br>

            <div class="row">
                  <div class="col-lg-4">
                    <label>Montant par jours : </label>
                  </div>
                  <div class="col-lg-2"></div>
                  <div class="col-lg-3">
                    <input id="montant_par_jour" class="form-control" min="1" type="number">

                  </div>
                  <div class="col-lg-1"></div>
                  <div class="col-lg-2">
                    <span>FCFA</span>
                  </div>
                </div>
                    <br>
        </div>          
          <!-- Fin zone pour changement d'offre -->
          <div class="container-flud">

            <div class="row">
              <div class="col-lg-5">
                <label>Le client a payé aussitot </label>

              </div>
              <div class="col-lg-2"></div>
              <div class="col-lg-5">
                <input type="checkbox" name="" id="show_montant_div">
              </div>

            </div>
          </div>

          <br>
          <div class="container-flud" id="montant_paye">

            <div class="row">
              <div class="col-lg-4">
                <label>Montant payé : </label>
              </div>
              <div class="col-lg-2"></div>
              <div class="col-lg-3">
                <input value="0" min="1" id="montant_remis" class="form-control" type="number">

              </div>
              <div class="col-lg-1"></div>
              <div class="col-lg-2">
                <span>FCFA</span>
              </div>
            </div>
          </div>


          <div class="container-fluid">

            <div class="row">
              <div class="card-footer clearfix " id="abonnement_button_container">
                <button class="btn btn-sm btn-info abonnement_button" id="valider_abonnement">Valider l'abonnement</button>
              </div>
            </div>

            <div class="row">
              <div class="card-footer clearfix" id="frais_installation_button_container" style="display:none">
                <button class="btn btn-sm btn-info abonnement_button" id="enregistrer_frais_installation">Enrégistrer les frais d'installation</button>
              </div>
            </div>

            <div class="row">
              <div class="card-footer clearfix" id="modifer_offre_button_container"  style="display:none">
                <button class="btn btn-sm btn-info abonnement_button" id="modifier_offre">Modifier l'offre en cours</button>
              </div>
            </div>

          </div>
          <!-- valider abonnement  start -->
        </div>
      </div>
    </div>


 

</div>
<!-- /.content-wrapper -->




<section>
  <div class='row'>
  <section class="col-lg-6 connectedSortable">
    <div class="card card-primary" >
    <div class="card-header ">
            <h3 class="card-title">Liste des clients de fin d'abonnement proche</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
            </div>
    </div>
      <!-- /.card-header -->
      <!-- body -->
      <div class="card-body ">
            <div class="table-responsive" id="exemple2_container" >
              <table id="exemple2"  class="table table-bordered table-striped data_table_element" >
                <thead>
                <tr>
                    
                    <th class="tete">Identifiant</th>
                    <th class="tete">Décompte</th>
                    
                  </tr>
                </thead>
                <tbody>
                
               
                  <?php 
                    
                    if(count($liste_des_proches) != 0){
                      foreach($liste_des_proches as $un_client){
                        echo '<tr>' ; 
                        echo "<td>".$un_client["identifiant"]."</td>" ;
                        if($un_client["status"] == "present" ){
                          echo "<td><span class='badge badge-success decompte_info'>Aujourd'hui</span></td>" ;
                        }
                        elseif($un_client["status"] == "passe"){
                          echo "<td><span class='badge badge-danger decompte_info' style='cursor:pointer' >Expiré depuis ".$un_client["jour"]." jours</td>
                          " ;
                        }
                        elseif($un_client["status"] == "futur"){
                          echo "<td><span class='badge badge-warning decompte_info' style='cursor:pointer' >Expire dans ".$un_client["jour"]." jours</td>
                          " ;
                        }
                        
                        echo '</tr>' ; 
                      }  
                    }  
                    
                 
                ?>
                  
               
                  


                </tbody>

              </table>

            </div>

          </div>
      <!-- /.card-body -->
    </div>
  </section> 

    <!-- Gestion de la campagne mail  start -->
    <div class="col-lg-6 connectedSortable">
      <div class="card card-danger">
        <div class="card-header">
          <h3 class="card-title">Liste des clients coupés</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
            </button>

          </div>
          <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <section class="content">
            <div  class="row"><span  id="button_couper_client" style="float:left;background:#dc3545;padding:3px;color:white;border-radius:5px;" data-toggle="tooltip" data-placement="right" title="Couper un client"  ><i class="fa fa-plus" aria-hidden="true"></i></span></div>
            
            <div class="row"> 
            <div class="table-responsive" id="exemple3_container"   >
              <table id="exemple3"  class="table table-bordered table-striped data_table_element" >
                <thead>
                <tr>
                    
                    <th class="tete">Identifiant</th>
                    
                    
                  </tr>
                </thead>
                <tbody id='client_coupe_body'>
                
               
                  <?php 
                    
                    if(count($liste_des_clients) != 0){
                      foreach( $liste_des_clients as $un_client){
                          if($un_client["status"] == "couper"){
                             echo '<tr>' ; 
                        
                              echo "<td>".$un_client["client_nom"]." <span class='deverouiller fa fa-lock' style='float:right'><p style='display:none'>_".$un_client['client_nom_value']."</p></span> </td>" ; 
                        
                              echo '</tr>' ;
                          }
                      }
                      
                        
                        
                    }  
                    
                 
                ?>
                  
               
                  


                </tbody>

              </table>

            </div>
              <!-- Liste clients bloqué  end -->
            </div>
        </div>
      </div>
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
            <div class="table-responsive"    >
              <table  id='exemple1'  class="table table-bordered table-striped data_table_element">
                <thead>
                <tr>
                    <th class="tete">Type</th>
                    <th class="tete">Identifiant</th>
                    <th class="tete">Status</th>
                    <th class="tete">Abonnement en cours</th>
                    <th class="tete">Début abonnement</th>
                    <th>Fin abonnement</th>
                  </tr>
                </thead>
                <tbody>
                
               
                  <?php 
                    
                    if(count($info_clients) != 0){
                      foreach($info_clients as $un_client_info){
                        echo '<tr>' ; 
                        echo "<td>".$un_client_info["type"]."</td>" ;
                        echo "<td>".$un_client_info["identifiant"]."</td>" ;
                        if($un_client_info["status"] =='regulier'){
                          echo "<td><span class='badge badge-success'>régulier</span></td>" ;
                        }
                        elseif($un_client_info["status"] =='debiteur'){
                          echo "<td><div class='badge badge-warning debiteur' style='cursor:pointer' >débiteur<span style='display:none'>".$un_client_info["id"]."_".$un_client_info['identifiant']."</span>   </div></td>
                          " ; 
                        }
                        elseif($un_client_info["status"] =='couper'){
                          echo "<td><span class='badge badge-danger' style='cursor:pointer' data-toggle='modal' data-target='#modal-historique-dette'>couper</td>
                          " ; 
                        }
                        else{
                          echo "<td><span class='badge badge-warning' style='cursor:pointer' data-toggle='modal' data-target='#modal-historique-dette'>Non défini</td>
                          " ;
                        }
                        echo "<td class='abonnement_en_cours' >".$un_client_info["abonnement"]."</td>" ;
                        echo "<td>".$un_client_info["debut"]."</td>" ;
                        echo "<td>".$un_client_info["fin"]."</td>" ;
                        echo "</tr>" ;
                      }
                     
                    }
                 
                ?>
                  
               
                  


                </tbody>

              </table>

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
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })

</script>


    ";
$jsLink = ob_get_clean();

?>