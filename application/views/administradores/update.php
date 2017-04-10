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
                  <label for="usuario">Usuario</label>
                  <input type="text" name="usuario" class="form-control" id="usuario" placeholder="usuario" required="" value="<?php echo $row['usuario']; ?>" autofocus="" >
                </div>
                <div class="form-group">
                  <label for="activo">Activo</label>
                  <select name="activo" id="activo" class="form-control" required>
                    <option value="">SELECCIONE</option>
                    <option value="SI" <?php if ($row['activo']=='SI'): ?>selected<?php endif ?>>SI</option>
                    <option value="NO" <?php if ($row['activo']=='NO'): ?>selected<?php endif ?>>NO</option>
                  </select>                  
                </div>
                <div class="form-group">
                  <label for="correo">Correo</label>
                  <input type="email" class="form-control" name="correo" id="correo" placeholder="Correo" required="" value="<?php echo $row['correo']; ?>" maxlength="255"  >
                </div>
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="id_usuario" value="<?php echo $row['id_usuario']; ?>">
                <input type="hidden" name="tipo" value="<?php echo $row['tipo']; ?>">
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