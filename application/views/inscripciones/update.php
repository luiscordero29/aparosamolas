<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
?>
  
  <?php $this->load->view('dashboard/header'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php $this->load->view('dashboard/breadcrumb'); ?>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
          <!-- general form elements -->
          <?php $this->load->view('dashboard/messages'); ?>
          <?php echo validation_errors('<p class="alert alert-danger">','</p>'); ?>
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $subtitle; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
              $at = array('role' => 'form');
              echo form_open('',$at); 
            ?>
              <div class="box-body">                
                <div class="form-group">
                  <label for="id_deporte">Deporte</label>
                  <select class="form-control" name="id_deporte" id="id_deporte" required="" onchange="ajax_valor()">
                    <option value="">SELECCIONE</option>
                    <?php 
                      if(!empty($table_deportes)){ 
                        foreach ($table_deportes as $r) {
                    ?>
                    <option <?php if ($row['id_deporte']==$r['id_deporte']): ?>selected<?php endif ?> value="<?php echo $r['id_deporte']; ?>"><?php echo $r['deporte']; ?></option>
                    <?php }} ?>
                  </select>
                </div>
                <div id="valor">
                  <?php if ($row['tipo']=='DORSAL'){ ?>
                    <div class="form-group">
                      <label for="valor">Introduzca el número de DORSAL del año pasado</label>
                      <input type="text" name="valor" class="form-control" id="valor" placeholder="Introduzca el número de DORSAL del año pasado" required="" value="<?php echo $row['valor']; ?>">
                    </div>
                  <?php } 
                    if ($row['tipo'] == 'APUNTARSE') {
                    # INGRESO DE APUNTARSE
                  ?>
                    <div class="form-group">
                      <label for="valor">Apuntarse</label>
                      <select name="valor" id="valor" class="form-control" required>
                        <option <?php if ($row['valor']=='1 DIA'): ?>selected<?php endif ?> value="1 DIA">1 DIA</option>
                        <option <?php if ($row['valor']=='2 DIAS'): ?>selected<?php endif ?> value="2 DIAS">2 DIAS</option>
                      </select>
                    </div>
                  <?php } ?>
                </div>
                <div class="form-group">
                  <label for="id_hijo">Hijo</label>
                  <select class="form-control" name="id_hijo" id="id_hijo" required="">
                    <?php 
                      if(!empty($table_hijos)){ 
                        foreach ($table_hijos as $r) {
                    ?>
                    <option <?php if ($row['id_hijo']==$r['id_hijo']): ?>selected<?php endif ?> value="<?php echo $r['id_hijo']; ?>"><?php echo $r['dni'].' '.$r['nombres'].' '.$r['apellido_1']; ?></option>
                    <?php }} ?>
                  </select>
                </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="id_inscripcion" value="<?php echo $row['id_inscripcion']; ?>">
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
            <?php 
              echo form_close(''); 
            ?>
          </div>
          <!-- /.box -->
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view('dashboard/footer'); ?>