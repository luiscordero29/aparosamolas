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
          <?php #echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>'); ?>
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
                  <input type="text" name="dni" class="form-control" id="dni" placeholder="DNI" autofocus="" maxlength="30" value="<?php echo set_value('dni'); ?>">
                </div>
                <div class="form-group">
                  <label for="nombres">Nombres</label>
                  <input type="text" name="nombres" class="form-control" id="nombres" placeholder="Nombres" required="" maxlength="120" value="<?php echo set_value('nombres'); ?>">
                </div>
                <div class="form-group">
                  <label for="apellido_1">Primer Apellido</label>
                  <input type="text" name="apellido_1" class="form-control" id="apellido_1" placeholder="Primer Apellido" required="" maxlength="120" value="<?php echo set_value('apellido_1'); ?>">
                </div>
                <div class="form-group">
                  <label for="apellido_2">Segundo Apellido</label>
                  <input type="text" name="apellido_2" class="form-control" id="apellido_2" placeholder="Segundo Apellido" required="" maxlength="120" value="<?php echo set_value('apellido_2'); ?>">
                </div>  
                <div class="form-group">
                  <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                  <div class="row">
                  <div class="col-xs-4">
                    <select name="fn_dia" id="fn_dia" class="form-control" required>
                      <option value="">DIA</option>
                      <?php 
                      for ($i=1; $i <=31 ; $i++) { 
                        if (set_value('fn_dia')==$i){
                          echo '<option selected value="'.$i.'">'.$i.'</option>';
                        }else{
                          echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-xs-4">  
                    <select name="fn_mes" id="fn_mes" class="form-control" required>
                      <option value="">MES</option>
                      <option <?php if (set_value('fn_mes')=='01'): ?>selected<?php endif ?> value="01">ENERO</option>
                      <option <?php if (set_value('fn_mes')=='02'): ?>selected<?php endif ?> value="02">FEBRERO</option>
                      <option <?php if (set_value('fn_mes')=='03'): ?>selected<?php endif ?> value="03">MARZO</option>
                      <option <?php if (set_value('fn_mes')=='04'): ?>selected<?php endif ?> value="04">ABRIL</option>
                      <option <?php if (set_value('fn_mes')=='05'): ?>selected<?php endif ?> value="05">MAYO</option>
                      <option <?php if (set_value('fn_mes')=='06'): ?>selected<?php endif ?> value="06">JUNIO</option>
                      <option <?php if (set_value('fn_mes')=='07'): ?>selected<?php endif ?> value="07">JULIO</option>
                      <option <?php if (set_value('fn_mes')=='08'): ?>selected<?php endif ?> value="08">AGOSTO</option>
                      <option <?php if (set_value('fn_mes')=='09'): ?>selected<?php endif ?> value="09">SEPTIEMBRE</option>
                      <option <?php if (set_value('fn_mes')=='10'): ?>selected<?php endif ?> value="10">OCTUBRE</option>
                      <option <?php if (set_value('fn_mes')=='11'): ?>selected<?php endif ?> value="11">NOVIEMBRE</option>
                      <option <?php if (set_value('fn_mes')=='12'): ?>selected<?php endif ?> value="12">DICIEMBRE</option>
                    </select>
                  </div>
                  <div class="col-xs-4"> 
                    <select name="fn_ano" id="fn_ano" class="form-control" required>
                      <option value="">AÑO</option>
                      <?php 
                      $y = intval( date('Y'));
                      for ($i=$y; $i >= $y - 30 ; $i--) { 
                        if (set_value('fn_ano')==$i){
                          echo '<option selected value="'.$i.'">'.$i.'</option>';
                        }else{
                          echo '<option value="'.$i.'">'.$i.'</option>';
                        }
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
                    <input type="text" name="fecha_nacimiento" readonly="" class="form-control pull-right" id="datepicker" required="" value="<?php echo set_value('fecha_nacimiento'); ?>">
                  </div>
                  Haz clic en el mes para ver los meses, clic en años para navegar entre ellos.
                </div>  
                */ ?>                
                <div class="form-group">
                  <label for="sexo">Sexo</label>
                  <select name="sexo" id="sexo" class="form-control" required>
                    <option value="">SELECCIONE</option>
                    <option <?php if (set_value('sexo')=='MASCULINO'): ?>selected<?php endif ?> value="MASCULINO">MASCULINO</option>
                    <option <?php if (set_value('sexo')=='FEMENINO'): ?>selected<?php endif ?> value="FEMENINO">FEMENINO</option>
                  </select>
                </div> 
                <div class="form-group">
                  <label for="colegio">Pertenece al Colegio</label>
                  <select name="colegio" id="colegio" class="form-control" required>
                    <option value="">SELECCIONE</option>
                    <option <?php if (set_value('colegio')=='SI'): ?>selected<?php endif ?> value="SI">SI</option>
                    <option <?php if (set_value('colegio')=='NO'): ?>selected<?php endif ?> value="NO">NO</option>
                  </select>
                </div>        
                <div class="form-group">
                  <label for="centro_escolar">Centro Escolar</label>
                  <input type="text" name="centro_escolar" class="form-control" id="centro_escolar" placeholder="Centro Escolar" value="<?php echo set_value('centro_escolar'); ?>">
                </div> 
                <div class="form-group">
                  <label for="afoto">Autorización de Foto</label>
                  <select name="afoto" id="afoto" class="form-control" required>
                    <option value="">SELECCIONE</option>
                    <option <?php if (set_value('afoto')=='SI'): ?>selected<?php endif ?> value="SI">SI</option>
                    <option <?php if (set_value('afoto')=='NO'): ?>selected<?php endif ?> value="NO">NO</option>
                  </select>
                </div> 
                <div class="form-group">
                  <label for="foto">Elegir Foto</label>
                  <input type="file" id="foto" name="userfile" autofocus>
                </div>      
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <input type="hidden" name="type" value="hijos_create">
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