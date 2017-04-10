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
                  <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                  <div class="row">
                  <?php 
                    $date_array = explode('-',$row['fecha_nacimiento']);
                    $fn_ano = $date_array[0]; // 2005
                    $fn_mes = $date_array[1]; // 01
                    $fn_dia = $date_array[2]; // 01
                  ?>
                  <div class="col-xs-4">
                    <select name="fn_dia" id="fn_dia" class="form-control" required>
                      <option value="">DIA</option>
                      <?php 
                      for ($i=1; $i <=31 ; $i++) { 
                        ?>
                        <option <?php if ($fn_dia==$i): ?>selected<?php endif ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php 
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-xs-4">  
                    <select name="fn_mes" id="fn_mes" class="form-control" required>
                      <option value="">MES</option>
                      <option <?php if ($fn_mes=='01'): ?>selected<?php endif ?> value="01">ENERO</option>
                      <option <?php if ($fn_mes=='02'): ?>selected<?php endif ?> value="02">FEBRERO</option>
                      <option <?php if ($fn_mes=='03'): ?>selected<?php endif ?> value="03">MARZO</option>
                      <option <?php if ($fn_mes=='04'): ?>selected<?php endif ?> value="04">ABRIL</option>
                      <option <?php if ($fn_mes=='05'): ?>selected<?php endif ?> value="05">MAYO</option>
                      <option <?php if ($fn_mes=='06'): ?>selected<?php endif ?> value="06">JUNIO</option>
                      <option <?php if ($fn_mes=='07'): ?>selected<?php endif ?> value="07">JULIO</option>
                      <option <?php if ($fn_mes=='08'): ?>selected<?php endif ?> value="08">AGOSTO</option>
                      <option <?php if ($fn_mes=='09'): ?>selected<?php endif ?> value="09">SEPTIEMBRE</option>
                      <option <?php if ($fn_mes=='10'): ?>selected<?php endif ?> value="10">OCTUBRE</option>
                      <option <?php if ($fn_mes=='11'): ?>selected<?php endif ?> value="11">NOVIEMBRE</option>
                      <option <?php if ($fn_mes=='12'): ?>selected<?php endif ?> value="12">DICIEMBRE</option>
                    </select>
                  </div>
                  <div class="col-xs-4"> 
                    <select name="fn_ano" id="fn_ano" class="form-control" required>
                      <option value="">AÑO</option>
                      <?php 
                      $y = intval( date('Y'));
                      for ($i=$y; $i >= $y - 30 ; $i--) { 
                        ?>
                        <option <?php if ($fn_ano==$i): ?>selected<?php endif ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php 
                      }                      
                      ?>
                    </select>
                  </div>
                  </div>
                </div>
                <?php /* ?>  
                <div class="form-group">
                  <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input id="datepicker" type="text" name="fecha_nacimiento" readonly="" class="form-control pull-right" required="" value="<?php echo date("d/m/Y", strtotime($row['fecha_nacimiento'])); ?>">
                  </div>
                </div> 
                */ ?>                 
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
                <div class="form-group">
                  <label for="foto">Elegir Foto (Maximo de 100px ancho por 200px de alto)</label>
                  <input type="file" id="foto" name="userfile" autofocus>
                  <p>
                    <br /><br />
                    <?php if ($row['foto']): ?>
                    <img src="<?php echo base_url('assets/uploads/'.$row['foto']); ?>"  width="300px" height="auto">
                    <?php endif ?>
                  </p>
                </div>                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="id_hijo" value="<?php echo $row['id_hijo']; ?>">
                <input type="hidden" name="dni" value="<?php echo $row['dni']; ?>">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <input type="hidden" name="type" value="hijos_update">
                <input type="hidden" name="foto" value="<?php echo $row['foto']; ?>">
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