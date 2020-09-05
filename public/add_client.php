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

<?php $titre_de_la_page = "Ajout d'un nouveau client"; ?>

<?php
ob_start();
echo "<link rel='stylesheet' href='public/dist/css/add_client.css'>";


$cssLink = ob_get_clean();


?>


<div class="container-fluid">
  <div class="row">
    <div class="col-md-2"></div>
    <!-- left column -->
    <div class="col-md-8">
      <!-- general form elements -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Enrégistré les informations du client</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post" action="controllers/add_client.php" enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group">
              <div class="custom-control custom-switch">
                <div class="container-fluid">
                  <div class="row">
                    <div class='col-md-12'><input type="text" name="type_client" id='type_checkbox_value' style="visibility:hidden" value="personnel">
                    </div>
                    <div class="col-md-3" style="color:#667755;font-size:20px;font-weight: bold">Entreprise</div>

                    <div class="col-md-6">
                      <label class="switch" style="position:relative;left:50px;">
                        <input id="type_checkbox" type="checkbox" default="personel" checked>
                        <span class="slider round" id="switch"></span>
                      </label>
                    </div>
                    <div class="col-md-3" style="color:#800080;font-weight: bold;font-size:20px;">Personnel</div>
                  </div>
                </div>
              </div>
            </div>
            <div id="personnel">
              <div class="form-group">
                <label for="exampleInputEmail1">Nom <span class='etoile'>*</span> </label>
                <input name="nom" id="nom-personnel" type="text" default="" class="form-control" placeholder="Entrer le nom du client" >
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Prénom <span class='etoile'>*</span> </label>
                <input name="prenom"   id="prenom-personnel"  type="text" default=""  class="form-control" placeholder="Entrer le prénom du client" >
              </div>
            </div>
            <div id="societe">
              <div class="form-group">
                <label for="exampleInputEmail1">Nom de la Société <span class='etoile'>*</span> </label>
                <input name="nom_societe" id="nom-societe"  default="" type="text" class="form-control" placeholder="Entrer le nom de la Société" >
              </div>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Adresse du client <span class='etoile'>*</span> </label>
              <input name="adresse" type="text" class="form-control" placeholder="Ex: Avenue Jean-Paul II, Rue 390 01 BP 374 Cotonou" required>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Téléphone <span class='etoile'>*</span> </label>
              <input   name="telephone1" minlength="8" maxlength="8" type="text" class="form-control" placeholder="Ex:90000000" id="telephone1" required>

              <input name="telephone2"  minlength="8" maxlength="8"  type="text" id="telephone2" class="form-control" id="telephone2"   placeholder="Ex:90000000">
              <span style="color:#007BFF;cursor:pointer;" id="new_number">Ajouter un autre numéro</span>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Email <span class='etoile'>*</span></label>
              <input name="email" type="email" class="form-control" placeholder="Ex : mon_mail@gmail.com" required>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1"> IP <span class='etoile'>*</span></label>
              <input name="ip" type="text" class="form-control" placeholder="Entrer l'adresse IP à attribuer au client" required>
            </div>

            <div class="form-group">
              <label for="exampleInputFile">Pièce du client</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file"default="" name="piece" class="custom-file-input" id="exampleInputFile">
                  <label class="custom-file-label" for="exampleInputFile">Choisir la pièce</label>
                </div>

              </div>
            </div>

           

          </div>
          <!-- /.card-body -->

          <div class="card-footer">
            <button type="submit" name="add_client" class="btn btn-primary" style="width:100%">Ajouter le client</button>
          </div>
        </form>
      </div>
      <!-- /.card -->

    </div>
    <div class="col-md-2"></div>

  </div>

</div>


<?php

ob_start();
echo "<script  src='public/dist/js/add_client.js'></script>";


$jsLink = ob_get_clean();

?>