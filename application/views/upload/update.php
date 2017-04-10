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
          <?php echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>'); ?>
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $subtitle; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
              $at = array('role' => 'form');
              echo form_open_multipart('upload/do_upload',$at); 
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
                  <label for="foto">Elegir Foto (Maximo de 100px ancho por 200px de alto)</label>
                  <input type="file" id="foto" name="userfile" autofocus>
                </div> 
                <div class="form-group">
                  <?php if ($row['foto']): ?>
                  <img src="<?php echo base_url('assets/uploads/'.$row['foto']); ?>"  width="300px" height="auto">
                  <?php endif ?>
                </div>  
                           
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="id_hijo" value="<?php echo $row['id_hijo']; ?>">
                <button type="submit" class="btn btn-primary">Subir Foto</button>
                <input type="hidden" name="type" value="tutor">
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