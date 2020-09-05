
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php  require("public\header.php") ?>
	<title><?=  $titre_de_la_page   ?></title>
	<!--Pour les link spéciales à ajouter pour certaines pages-->
	<?=  $cssLink ?? " "   ?>
</head>

<body  class="hold-transition sidebar-mini layout-fixed" >
<?php  require("public/nav.php") ?>
<?php  require("public/sidebar.php") ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
   
  <!-- Main content -->
<section class="content">
  <div class="container-fluid">
        <!-- Small boxes (Stat box) -->

  <?=  $content ?? " "   ?>
  <!-- Pour le chargement des pages -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#17a2b8"/></svg></div>
<!-- End -->
</div>
<?php  require("public/footer.php") ?>

<!--Code Js spécifique à chaque page-->
<?=  $jsLink ?? " "   ?>
</div>
</div>
</div>
</section>
</body>
</html>



<?php  ?>
