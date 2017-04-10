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
                  <label for="estado">Estado del Recibo</label>
                  <select name="estado" id="estado" class="form-control" required autofocus="">
                    <option value="">SELECCIONE</option>
                    <option value="NO ENVIADO" <?php if ($row['estado']=='NO ENVIADO'): ?>selected<?php endif ?>>NO ENVIADO</option>
                    <option value="ENVIADO" <?php if ($row['estado']=='ENVIADO'): ?>selected<?php endif ?>>ENVIADO</option>
                    <option value="DEVUELTO" <?php if ($row['estado']=='DEVUELTO'): ?>selected<?php endif ?>>DEVUELTO</option>
                  </select>
                </div> 
                <div class="form-group">
                  <label for="porcentajes">Porcentajes</label>
                  <select name="porcentajes" id="porcentajes" class="form-control" required autofocus="">
                    <option value="">SELECCIONE</option>
                    <option value="0" <?php if ($row['porcentajes']=='0'): ?>selected<?php endif ?>>0%</option>
                    <option value="50" <?php if ($row['porcentajes']=='50'): ?>selected<?php endif ?>>50%</option>
                    <option value="100" <?php if ($row['porcentajes']=='100'): ?>selected<?php endif ?>>100%</option>
                  </select>
                </div>       
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
      <div class="row">
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Información del Tutor</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">                
                <div class="form-group">
                  <label for="dni">DNI</label>
                  <input readonly="" type="text" name="dni" class="form-control" id="dni" placeholder="DNI" maxlength="30" value="<?php echo $row['tdni']; ?>">
                </div>
                <div class="form-group">
                  <label for="nombres">Nombres</label>
                  <input readonly="" type="text" name="nombres" class="form-control" id="nombres" placeholder="Nombres" required="" maxlength="120" value="<?php echo $row['tnombres']; ?>">
                </div>
                <div class="form-group">
                  <label for="apellido_1">Primer Apellido</label>
                  <input readonly="" type="text" name="apellido_1" class="form-control" id="apellido_1" placeholder="Primer Apellido" required="" maxlength="120" value="<?php echo $row['tapellidos']; ?>">
                </div>
              </div>

          </div>
          <!-- /.box -->
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Información del Estudiante</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">                
                <div class="form-group">
                  <label for="dni">DNI</label>
                  <input readonly="" type="text" name="dni" class="form-control" id="dni" placeholder="DNI" maxlength="30" value="<?php echo $row['dni']; ?>">
                </div>
                <div class="form-group">
                  <label for="nombres">Nombres</label>
                  <input readonly="" type="text" name="nombres" class="form-control" id="nombres" placeholder="Nombres" required="" maxlength="120" value="<?php echo $row['nombres']; ?>">
                </div>
                <div class="form-group">
                  <label for="apellido_1">Primer Apellido</label>
                  <input readonly="" type="text" name="apellido_1" class="form-control" id="apellido_1" placeholder="Primer Apellido" required="" maxlength="120" value="<?php echo $row['apellido_1']; ?>">
                </div>
                <div class="form-group">
                  <label for="apellido_2">Segundo Apellido</label>
                  <input readonly="" type="text" name="apellido_2" class="form-control" id="apellido_2" placeholder="Segundo Apellido" required="" maxlength="120" value="<?php echo $row['apellido_2']; ?>">
                </div>  
              </div>    

          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view('dashboard/footer'); ?>