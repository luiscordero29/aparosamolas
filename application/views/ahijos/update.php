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
                  <label for="dni">DNI</label>
                  <input readonly="" type="text" name="dni" class="form-control" id="dni" placeholder="DNI" autofocus="" maxlength="30" value="<?php echo $row['dni']; ?>">
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
                <div class="form-group">
                  <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input id="datepicker" type="text" name="fecha_nacimiento" readonly="" class="form-control pull-right" required="" value="<?php echo date("d/m/Y", strtotime($row['fecha_nacimiento'])); ?>">
                  </div>
                </div>                  
                <div class="form-group">
                  <label for="sexo">Sexo</label>
                  <select name="sexo" id="sexo" class="form-control" required>
                    <option value="">SELECCIONE</option>
                    <option value="MASCULINO" <?php if ($row['sexo']=='MASCULINO'): ?>selected<?php endif ?>>MASCULINO</option>
                    <option value="FEMENINO" <?php if ($row['sexo']=='FEMENINO'): ?>selected<?php endif ?>>FEMENINO</option>
                  </select>
                </div> 
                <div class="form-group">
                  <label for="colegio">Pertenece al Colegio</label>
                  <select name="colegio" id="colegio" class="form-control" required>
                    <option value="">SELECCIONE</option>
                    <option value="SI" <?php if ($row['colegio']=='SI'): ?>selected<?php endif ?>>SI</option>
                    <option value="NO" <?php if ($row['colegio']=='NO'): ?>selected<?php endif ?>>NO</option>
                  </select>
                </div>        
                <div class="form-group">
                  <label for="centro_escolar">Centro Escolar</label>
                  <input type="text" name="centro_escolar" class="form-control" id="centro_escolar" placeholder="Centro Escolar" value="<?php echo $row['centro_escolar']; ?>">
                </div>  
                <div class="form-group">
                  <label for="afoto">Autorización de Foto</label>
                  <select name="afoto" id="afoto" class="form-control" required>
                    <option value="">SELECCIONE</option>
                    <option value="SI" <?php if ($row['afoto']=='SI'): ?>selected<?php endif ?>>SI</option>
                    <option value="NO" <?php if ($row['afoto']=='NO'): ?>selected<?php endif ?>>NO</option>
                  </select>
                </div>                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="id_hijo" value="<?php echo $row['id_hijo']; ?>">
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