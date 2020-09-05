<!--Debut du modal d'affichage de dette pour la home-->
<div class="modal fade" id="modal-historique-dette">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header" id="modal-historique-dette"  style="background:#6f42c1">
              <h5 class="modal-title" style="color:white" >Détails des dette de <span style="font-weight:bold;font-style:italic" id="nom_client" ></span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" id="close_modif_header" style="color:white" >&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <div>
               <div class="container-fluid">
                  <div class="card-body p-2">
               <div class="table-responsive">
                 <table id="example1" class="table table-bordered table-striped " style="border-top: 2px solid #6f42c1;">
                  <thead>
                  <tr>
                    <th class="tete">Date</th>
                    <th class="tete" >Libellé de la dette </th>
                    <th class="tete" >Montant</th>
                    
                  </tr>
                  </thead>
                  <tbody id="dette_liste_body">
                    

                   

                   

    
                  </tbody>
                  <tfoot>
                  <tr>
                      <td colspan="2" style="color:#6f42c1;font-weight:bold">Total</td>
                      
                      <td><span style="font-weight: bold" id="total"></span></td>
                      
                    </tr>
                  </tfoot>
                  
                </table>

               </div>
                
              </div>
                    
               </div>
             </div>
            </div>
            <div class="modal-footer justify-content-between">
              
              <button type="button" class="btn btn-primary" id="close_dette_liste" style="width:100%;color:white;background:#6f42c1;border-color:#6f42c1">D'accord</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

<!-- Fin-->



<!--Modal de confirmation d'enregistrement d'abonnement  pour la home-->
  <div class="modal fade" id="modal-confirmer-abonnement">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="background:#ffc107" >
              <h4 class="modal-title" >Confirmation d'enrégistrement de l'abonnement</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" id="close_modif_header" >&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <div>
               <div class="container-fluid">

                <div id="suppression_message">
                  <h6 >En confirmant cet abonnement , vous reconnaissez avoir fournir  <span id="accord_client"></span> <span  id="liste_client" style="font-weight: bold;font-style: italic;"></span>  un abonnement de type   <span style="font-weight: bold;font-style: italic;">Résidentiel\10 Mbps</span>  qui s'achèvera le : <span style="font-weight: bold;font-style: italic;">  </span>  </h6>
                 <h5 style="font-weight:bold">Etes vous sure de vouloir validez l'abonnement ?</h5>
                </div>
               </div>
             </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-primary confirm_abonnement_button" id="confirm" >OUI</button>
              <button type="button" class="btn btn-primary confirm_abonnement_button" id="infirm" >NON</button>
            </div>
          </div>
          
        </div>
        
      </div>
<!-- Fin -->


<!--Debut du modal d'affichage des info du client (pour la page liste client) -->

<div class="modal fade" id="modal-modif">
  <form method="POST"  id="modif-form" action="controllers/modifier_client.php" enctype="multipart/form-data" >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" id="modif_header" >
              <h4 class="modal-title" >Modification des informations</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" id="close_modif_header" >&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action=" " method="POST">
             <div>
               <div class="container-fluid">

                <div class="row each_row">
                   <div class="col-md-3 element">Type : </div>
                    <div class="col-md-6" id="type" > </div>
                    <div class="col-md-3 element" style="display:none"><input type="number" name="id_client" id="id_client"></div>

                     <div class="col-md-3 element" style="display:none"><input type="text" name="type_client" id="type_client"></div>
                    
                 </div> 

                 <div class="row each_row"  id="societe_div">
                   <div class="col-md-3 element">Société : </div>
                    <div class="col-md-6"  id="societe_nom" ></div>
                    <div class="col-md-6  form-group" id="societe_input_div" style="display:none;" >
                      <input type="text" name="nom_societe" class="form-control" id="societe_input" placeholder="Entrer le nouveau nom de la société">
                    </div>
                    <div class="col-md-3 " >
                      <span  id='click_modifier_societe'  class="modifier_click" >Modifier</span>
                      <span  id='ok_societe' class="ok_societe" style='display:none' >Ok</span> 
                     
                   </div>
                 </div> 

                 <div id="personnel_div" >
                   <div class="row each_row"  >
                   <div class="col-md-3 element">Nom: </div>
                    <div class="col-md-6"  id="nom" ></div>
                    <div class="col-md-6  form-group" id="nom_input_div" style="display:none;" >
                      <input type="text" name="nom"  class="form-control" id="nom_input" placeholder="Entrer le nom du client">
                    </div>
                    <div class="col-md-3 " >
                      <span  id='click_modifier_nom' class="modifier_click" >Modifier</span>
                      <span  id='ok_nom' class="ok_societe" style='display:none' >Ok</span> 
                     
                   </div>
                 </div> 


                 <div class="row each_row"  >
                   <div class="col-md-3 element">Prénom: </div>
                    <div class="col-md-6"  id="prenom" ></div>
                    <div class="col-md-6  form-group" id="prenom_input_div" style="display:none;" >
                      <input type="text" name="prenom" class="form-control" id="prenom_input" placeholder="Entrer le prénom du client">
                    </div>
                    <div class="col-md-3 " >
                      <span  id='click_modifier_prenom' class="modifier_click" >Modifier</span>
                      <span  id='ok_prenom' class="ok_societe" style='display:none' >Ok</span> 
                     
                   </div>
                 </div> 

                </div>

                 
                 <div class="row each_row"  >
                   <div class="col-md-3 element">Adresse : </div>
                    <div class="col-md-6"  id="adresse" ></div>
                    <div class="col-md-6  form-group" id="adresse_input_div" style="display:none;" >
                      <input type="text" name="adresse" class="form-control" id="adresse_input" placeholder="Entrer la nouvelle adresse">
                    </div>
                    <div class="col-md-3 " >
                      <span  id='click_modifier_adresse' class="modifier_click" >Modifier</span>
                      <span  id='ok_adresse' class="ok_societe" style='display:none' >Ok</span> 
                     
                   </div>
                 </div> 



                <div class="row each_row"  >
                   <div class="col-md-3 element">Email : </div>
                    <div class="col-md-6"  id="email" ></div>
                    <div class="col-md-6  form-group" id="email_input_div" style="display:none;" >
                      <input type="email" name="email" class="form-control" id="email_input" placeholder="Entrer le nouveau mail">
                    </div>
                    <div class="col-md-3 " >
                      <span  id='click_modifier_email' class="modifier_click" >Modifier</span>
                      <span  id='ok_email' class="ok_societe" style='display:none' >Ok</span> 
                     
                   </div>
                 </div> 


                <div class="row each_row"  >
                   <div class="col-md-3 element">Téléphone : </div>
                    <div class="col-md-6"  id="telephone" ></div>
                    <div class="col-md-6  form-group" id="telephone_input_div" style="display:none;" >
                      <input type="telephone" name="telephone" class="form-control" id="telephone_input" placeholder="Ex: 90000000/90000001 ">
                    </div>
                    <div class="col-md-3 " >
                      <span  id='click_modifier_telephone' class="modifier_click" >Modifier</span>
                      <span  id='ok_telephone' class="ok_societe" style='display:none' >Ok</span> 
                     
                   </div>
                 </div> 


                  <div class="row each_row"  >
                   <div class="col-md-3 element">IP : </div>
                    <div class="col-md-6"  id="ip" ></div>
                    <div class="col-md-6  form-group" id="ip_input_div" style="display:none;" >
                      <input type="ip" name="ip" class="form-control" id="ip_input" placeholder="Ex: 160.1.1.1 ">
                    </div>
                    <div class="col-md-3 " >
                      <span  id='click_modifier_ip' class="modifier_click" >Modifier</span>
                      <span  id='ok_ip' class="ok_societe" style='display:none' >Ok</span> 
                     
                   </div>
                 </div> 

                

                

                 
           <div class="row each_row">
                   <div class="custom-file">
                        <input type="file" name="piece" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choisir la pièce d'identification du client</label>
                      </div>
                 </div>

               </div>
             </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="submit" class="btn btn-primary" id="save_button" >Enrégistré les modifications</button>
            </div>
          </div>
       
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
     </form>
      </div>
<!-- Fin  du modal d'affichage des infos pour la page liste_client-->



<!--Debut du modal de modification des informations pour la page cliste  client-->
<div class="modal fade" id="modal-afficher">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" id="afficher_header" >
              <h4 class="modal-title" >Afficher les informations</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" id="close_modif_header" >&times;</span>
              </button>
            </div>
            <div class="modal-body">
            
               <div class="container-fluid">

                <div class="row each_row">
                   <div class="col-md-3 element">Type : </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-3 element_result " id="type_afficher">   </div>
                    
                 </div> 

                 <div class="row each_row" id="societe_div_afficher">
                    <div class="col-md-3 element">Société : </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-3 element_result" id="societe_nom_afficher" > </div>   
                 </div> 
                 <div id="personnel_div_afficher" >
                 <div class="row each_row" >
                    <div class="col-md-3 element">Nom : </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-3 element_result" id="nom_afficher" ></div>
                 </div>

                 <div class="row each_row">
                   <div class="col-md-3 element" >Prénom : </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-3 element_result" id="prenom_afficher"   ></div>   
                 </div>

                </div>
                 <div class="row each_row">
                    <div class="col-md-3 element">Adress : </div>
                    <div class="col-md-5"></div>
                    <div class="col-md-4 element_result" id="adresse_afficher" ></div>
                 </div>


                 <div class="row each_row">
                   <div class="col-md-3 element">Email : </div>
                    <div class="col-md-5"></div>
                    <div class="col-md-4 element_result"  id="email_afficher"></div>
                 </div>

                 <div class="row each_row">
                    <div class="col-md-3 element">Téléphone : </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-3  element_result " id="telephone_afficher"> </div>
                  </div>


                 <div class="row each_row">
                    <div class="col-md-3 element">IP : </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-3 element_result" id="ip_afficher" ></div>
                 </div>

               
             </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-primary" id="fermer_afficher_modal" >Fermer</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

<!-- Fin modal de modification des information pour la page liste client-->
      

      <!--Debut du modal de suppression d'un client pour la page liste client -->
<div class="modal fade" id="modal-supprimer">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" id="supprimer_header" >
              <h4 class="modal-title" >Supprimer  <span id="client_supprimer_nom"></span></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" id="close_modif_header" >&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <div>
               <div class="container-fluid">
                <input type="number" id="id_client_supprimer" style="display:none" >
                <div id="suppression_message">
                  <h6 >En supprimant ce client toutes les informations relatives à ce dernier seront totalement supprimer.</h6>
                 <h5 style="font-weight:bold">Etes vous sure de vouloir éffectuer la suppression ?</h5>
                </div>
               </div>
             </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-primary supprimer_button" id="supprimer_client_button" >Supprimer</button>
              <button type="button" class="btn btn-primary supprimer_button" id="ignore_supprimer_client_button" >Ignoré</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

<!-- Fin modal de suppression pour la page liste client-->



<!--Modal de confirmation d'enregistrement des informations relatives au nouvel abonnement-->
<div class="modal fade" id="modal-sauvegarde-nouveau-abonnement">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="background:#28a745" >
              <h4 class="modal-title"  style="color:white;font-family:calibri">Sauvegarde du nouveau type d'abonnement</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" id="close_modif_header" >&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <div>
               <div class="container-fluid">

                <div>
                  <h6 >Veuillez accepter l'enrégistrement des informatons relative au nouveau type d'abonnement que vous avez renseigné <br> 
                 <br> <span style="font-weight: bold;">Libellé abonnement:</span>  <span id="libelle_abonnement" style="color:#28a745;font-style:italic ; font-size:17px" ></span> <br>
                  <span style="font-weight: bold;">Débit abonnement : </span> <span  id="debit_abonnement"  style="color:#28a745;font-style:italic; font-size:17px"></span>  Mbps
                  <br> <span style="font-weight: bold;">Montant : </span> <span  id="montant_abonnement"  style="color:#28a745;font-style:italic; font-size:17px"></span> FCFA
                </div>
               </div>
             </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" id="add_new_abonnement" class="btn btn-primary" style="color:white;background:#28a745;width:100%;border-color:#28a745" >J'accepte</button>
              
              <div style="text-align:center">
              
              <form action="">
                 <span>Ne plus me le demander</span> <input type="checkbox" id="rapelle" value="oui">
              </form>
              </div>
            </div>
          </div>
          
        </div>
        
      </div>
<!-- Fin -->

  <!--Debut du modal d'enregistrement de payement -->
  <div class="modal fade" id="confirmer_payement">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" id="supprimer_header" style="background-color:#17a2b8" >
              <h4 class="modal-title" style="color:white" > Confirmer Payement  <span id="client_supprimer_nom"></span></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" id="close_modif_header" >&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <div>
               <div class="container-fluid">
                <input type="number" id="id_client_supprimer" style="display:none" >
                <div id="suppression_message">
                  <h6 >Veuillez confirmer le payement de la somme de  <span id="montant" style="font-weight: bold;font-style:italic"></span> FCFA par le client <span id="client" style="font-weight: bold;font-style:italic" ></span> pour <span id='motif' style="font-weight: bold;font-style:italic" ></span>.</h6>
                 <h5 style="font-weight:bold">Confirmez vous l'enregistrement du payement ?</h5>
                </div>
               </div>
             </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-primary supprimer_button" id="confirme_payement"  style="background-color:#17a2b8;border-color:#17a2b8">Supprimer</button>
              <button type="button" class="btn btn-primary supprimer_button" id="ignore_payement" style="background-color:#17a2b8;border-color:#17a2b8" >Ignoré</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

<!-- Fin modal de suppression pour la page liste client-->


<!-- code pour la confirmation de d'blocage -->
 <!--Debut du modal d'enregistrement de payement -->
 <div class="modal fade" id="confirmer_deblocage">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" id="supprimer_header" style="background-color:#17a2b8" >
              <h4 class="modal-title" style="color:white" > Confirmer déblocage  <span id="client_supprimer_nom"></span></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" id="close_modif_header" >&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <div>
               <div class="container-fluid">
                <input type="number" id="id_client_supprimer" style="display:none" >
                <div id="suppression_message">
                  <h6 >En appuyant sur le boutton Ok vous confirmez le déblocage du client  <span id="identifiant_client" style="font-weight: bold;font-style:italic"></span> sous réserve qu'il n'est toujours pas en régle. <span id="code_client" style="display:none"></span>   </h6>
                 
                </div>
               </div>
             </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-primary supprimer_button" id="confirme_deblocage_button"  style="width:100%;background-color:#17a2b8;border-color:#17a2b8">Supprimer</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

<!-- Fin de la gestion du confirmation du déblocage -->


 <!--Debut du modal de blocage -->
 <div class="modal fade" id="modal_blocage">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" id="supprimer_header" style="background-color:#fd7e14" >
              <h4 class="modal-title" style="color:white" > Bloquer un client  <span id="client_supprimer_nom"></span></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" id="close_modif_header" >&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <div>
               <div class="container-fluid">
                
               <select class="select2" multiple="multiple" id="client_bloquer" data-placeholder="Séléctionné le client qui a payé" style="width: 100%;">
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
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-primary bloquer_button" id="button_bloquer"  style="width:100%;background-color:#fd7e14;border-color:#fd7e14">Bloquer</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

<!-- Fin de la gestion du confirmation du déblocage -->

<!-- Modal d'ajout de ticket -->

<div class="modal fade" id="modal_ajout_ticket">

              
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" id="supprimer_header" style="background-color:#28a745" >
              <h4 class="modal-title" style="color:white" > Ouverture d'un nouveau ticket  <span id="client_supprimer_nom"></span></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" id="close_modif_header" >&times;</span>
              </button>
            </div>
            <div class="modal-body">
           
             <div>
               <div class="container-fluid">
                <form id='form_ouverture_ticket' role="form" method="post" action="controllers/gestion-tickets.php" enctype="multipart/form-data">

                <input type="text" name='action' value="ouvrir_ticket" style="display:none;">
                <input type="number" name='id_ouvrant' value="2" style="display:none;">
                  <div class="row">
                     <div class="col-lg-12">
                      <label>Séléctionné le client : </label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12">
                      <select  name="client" class="select2"  id="client_id" data-placeholder="Séléctionné le client concerné" style="width: 100%;">
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

                  <div class="row">
                     <div class="col-lg-12">
                      <label>Libellé du ticket : </label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12">
                      <select name="libelle" class="select2" id='libelle'  data-placeholder="Séléctionné le client concerné" style="width: 100%;">
                        <option value="vide">Entré le libellé du ticket</option>
                        <?php
                       
                            if(count($tickets) != 0){ 
                                foreach($tickets as $un_ticket){
                                   echo "<option  value='".$un_ticket["libelle"]."'   >".$un_ticket["libelle"]."</option>" ;
                                }
                            }
                        
                        ?>
                        <option value="nouveau">Nouveau libellé</option>
              
                      </select>
                    </div>
                  </div>
                  <br>


                  <div id='nouveau_libelle'  class="cache">
                      <div class="row">
                        <div class="col-lg-12">
                          <input name="nouveau_libelle" type="text"  placeholder="Entré le libellé" class="form-control">
                        </div>
                      </div>
                      <br>
                  </div> 
                  



                  <div class="row">
                     <div class="col-lg-12">
                      <label>Séléctionné la catégorie du ticket : </label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12">
                      <select name="categorie" class="select2" id="categorie"  data-placeholder="Séléctionné le client concerné" style="width: 100%;">
                      <option value="vide">Entré la catégorie  du ticket</option>
                      <?php
                        $taille_ticket_tableau = count($tickets) ; 
                       if($taille_ticket_tableau != 0){
                           
                           foreach($tickets as $un_ticket){
                              echo "<option  value='".$un_ticket["categorie"]."'    >".$un_ticket["categorie"]."</option>" ;
                           }
                           

                       }
                   
                   
                   ?>
                   <option value="nouveau">Nouveau libellé</option>
              
                      </select>
                    </div>
                  </div>
                  <br>

                  <div id='nouveau_categorie'  class="cache">
                      <div class="row">
                        <div class="col-lg-12">
                          <input  class="nouveau_categorie" type="text"  placeholder="Entré la categorie du ticket" class="form-control">
                        </div>
                      </div>
                      <br>
                  </div> 
                  


                  <div class="row">
                     <div class="col-lg-12">
                      <label>Description du ticket : </label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12">
                      <textarea name="description"  id="description" class="form-control"  rows="5"  data-placeholder="Séléctionné le client concerné" style="width: 100%;">
                        
              
                      </textarea>
                    </div>
                  </div>
                  <br>

                  <div class="row">
                     <div class="col-lg-12">
                      <label>Ajouter une capture ou un document (optionnel) </label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12">
                      <input name="capture" class="form-control" id='ticket_document'  type="file"  data-placeholder="Séléctionné le client concerné" style="width: 100%;">
                     
                    </div>
                  </div>
                  <br>
               </div>
             </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="submit" class="btn btn-primary bloquer_button"  style="width:100%;background-color:#28a745;border-color:#28a745">Ouvrir ticket</button>
            </div>
        </form>  
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

<!-- End  -->