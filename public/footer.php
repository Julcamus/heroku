 <!--
      @
      @  Fichier contenant les liens CSS communes à toutes les pages
      @
  -->

  <!-- jQuery -->
<script src='public/plugins/jquery/jquery.min.js'></script>
<!-- jQuery UI 1.11.4 -->
<script src='public/plugins/jquery-ui/jquery-ui.min.js'></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src='public/plugins/bootstrap/js/bootstrap.bundle.min.js'></script>
<!-- ChartJS -->
<script src='public/plugins/chart.js/Chart.min.js'></script>

<!-- AdminLTE App -->
<script src='public/dist/js/adminlte.js'></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src='public/dist/js/pages/dashboard.js'></script>
<!-- AdminLTE for demo purposes -->
<script src='public/dist/js/demo.js'></script>
<!-- input des destinatires de mails -->
<script src='public/plugins/select2/js/select2.full.min.js'></script>
<script src='public/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js'></script>
<!-- InputMask -->
<script src='public/plugins/moment/moment.min.js'></script>
<script src='public/plugins/inputmask/min/jquery.inputmask.bundle.min.js'></script>
<!-- date-range-picker -->
<script src='public/plugins/daterangepicker/daterangepicker.js'></script>
<!-- bootstrap color picker -->
<script src='public/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js'></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src='public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'></script>




<!--select message receiver-->

<script src='public/plugins/bootstrap/js/bootstrap.bundle.min.js'></script>
<!-- Select2 -->
<script src='public/plugins/select2/js/select2.full.min.js'></script>
<!-- Bootstrap4 Duallistbox -->
<script src='public/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js'></script>
<!-- InputMask -->
<script src='public/plugins/moment/moment.min.js'></script>
<script src='public/plugins/inputmask/min/jquery.inputmask.bundle.min.js'></script>
<!-- date-range-picker -->
<script src='public/plugins/daterangepicker/daterangepicker.js'></script>
<!-- bootstrap color picker -->
<script src='public/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js'></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src='public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'></script>
<!-- Bootstrap Switch -->
<script src='public/plugins/bootstrap-switch/js/bootstrap-switch.min.js'></script>
<!-- AdminLTE App -->
<script src='public/dist/js/adminlte.min.js'></script>
<!-- AdminLTE for demo purposes -->
<script src='public/dist/js/demo.js'></script>

<script src='public/dist/js/layout.js'></script>
<!-- script pour afficher les toast d'erreur -->
<script src='public/plugins/sweetalert2/sweetalert2.min.js'></script>
<script src='public/plugins/toastr/toastr.min.js'></script>


<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })
</script>