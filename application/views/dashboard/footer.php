<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <a target="_get" href="http://www.webactual.com">Web Actual</a> - <b>App Versión 3.0</b>
    </div>
    <strong>Copyright &copy; <?php echo date("Y"); ?> <a target="_get" href="http://www.aparosamolas.com">APA ROSA MOLAS</a>.</strong> Todos los derechos reservados.
  </footer>

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

                <!-- Modal -->
                <div class="modal fade" id="C19Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">PROCESAR RECIBOS</h4>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          Porcentaje de Importe
                          <div class="radio">
                            <label>
                              <input name="importe" id="importe50" value="50" type="radio">
                              50% Importe
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input name="importe" id="importe100" value="100" type="radio">
                              100% Importe
                            </label>
                          </div>
                        </div>
                        <div class="form-group">
                          Exportar como
                          <div class="radio">
                            <label>
                              <input name="descargar" id="descargar_cuaderno19" value="cuaderno19" type="radio">
                              Cuaderno 19
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input name="descargar" id="descargar_excel" value="excel" type="radio">
                              Excel
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button id="ProcesarC19" type="button" class="btn btn-primary">PROCESAR</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

<!-- jQuery 2.2.0 -->
<script src="<?php echo base_url('assets/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js'); ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets/AdminLTE/plugins/jQueryUI/jquery-ui.min.js'); ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('assets/AdminLTE/bootstrap/js/bootstrap.min.js'); ?>"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?php echo base_url('assets/AdminLTE/plugins/morris/morris.min.js'); ?>"></script>
<!-- Sparkline -->
<script src="<?php echo base_url('assets/AdminLTE/plugins/sparkline/jquery.sparkline.min.js'); ?>"></script>
<!-- jvectormap -->
<script src="<?php echo base_url('assets/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'); ?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url('assets/AdminLTE/plugins/knob/jquery.knob.js'); ?>"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo base_url('assets/AdminLTE/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
<!-- datepicker -->
<script src="<?php echo base_url('assets/AdminLTE/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.es.js'); ?>"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url('assets/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url('assets/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
<!-- FastClick -->
<script src="<?php echo base_url('assets/AdminLTE/plugins/fastclick/fastclick.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/AdminLTE/dist/js/app.min.js'); ?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url('assets/AdminLTE/dist/js/pages/dashboard.js'); ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/AdminLTE/dist/js/demo.js'); ?>"></script>

<script type="text/javascript">
  <?php if ($this->uri->segment(1, 0)<>'recibos_inscripciones'): ?>
  $('#datepicker').datepicker({language: 'es'});
  $('#reservation').daterangepicker();
  function ajax_valor(){
    var id = $('select#id_deporte').val();
    var ajaxurl = '<?php echo site_url('inscripciones/valor'); ?>' + '/' + id;
    $.get( ajaxurl, function( data ) {
      $( "#valor" ).html( data );
    });
    /*$.ajax({
      type:'POST',
      url: '<?php echo site_url('inscripciones/valor'); ?>' + '/' + id,
      data: 'id_deporte='+id,
      success: 
        function(resp){
          $('#valor').html(resp);        
        }
    });*/
  } 
  <?php endif; ?>
  $( "#importe50" ).click(function() {
    $( "#importe" ).val('50');
  });
  $( "#importe100" ).click(function() {
    $( "#importe" ).val('100');
  });
  $( "#descargar_cuaderno19" ).click(function() {
    $( "#descargar" ).val('cuaderno19');
  });
  $( "#descargar_excel" ).click(function() {
    $( "#descargar" ).val('excel');
  });
  
  
  $( "#ProcesarC19" ).click(function() {
    
    var importe = true;
    var descargar = true;
    var info = '';

    if (!$("input[name='importe']").is(':checked')) {
      alert('Seleccione un Importe!');
      importe = false;
    }

    if (!$("input[name='descargar']").is(':checked')) {
      alert('Seleccione un Metodo de Exportación!');
      descargar = false;
    }
    
    if (importe == true && descargar == true) {
      $("#FormC19").submit();
    }

  });

  $("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
  });
</script>

                

</body>
</html>