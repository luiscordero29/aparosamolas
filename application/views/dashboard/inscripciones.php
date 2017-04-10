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
                  <label for="estatus">Estatus del Proceso de Inscripciones</label>
                  <select name="estatus" id="estatus" class="form-control" required>
                    <option value="ABIERTAS" <?php if ($row['estatus']=='ABIERTAS'): ?>selected<?php endif ?>>ABIERTAS</option>
                    <option value="CERRADAS" <?php if ($row['estatus']=='CERRADAS'): ?>selected<?php endif ?>>CERRADAS</option>
                  </select>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <input type="hidden" name="id_periodo" value="<?php echo $row['id_periodo']; ?>">
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