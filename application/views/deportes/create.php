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
                  <label for="deporte">Deporte</label>
                  <input type="text" name="deporte" class="form-control" id="deporte" placeholder="Deporte" required="" autofocus="" maxlength="250">
                </div>
                <div class="form-group">
                  <label for="precio">Precio</label>
                  <input type="text" name="precio" class="form-control" id="precio" placeholder="Precio" required="" >
                </div> 
                <div class="form-group">
                  <label for="tipo">Tipo</label>
                  <select name="tipo" id="tipo" class="form-control" required>
                    <option value="">SELECCIONE</option>
                    <option value="DORSAL">DORSAL</option>
                    <option value="SIN DORSAL">SIN DORSAL</option>
                  </select> 
                </div>                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
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