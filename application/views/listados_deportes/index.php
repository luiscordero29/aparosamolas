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
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo $subtitle; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <?php /* ?>
              <p align="right">
                <a target="_get" href="<?php echo site_url('pdf/listados'.$search_url); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir Lista</a>
              </p>
              php */ ?>

                <?php 
                echo form_open(''); 
                ?>
                
                  <div class="row">
                    <div class="col-xs-3">
                      <label for="deporte">Deporte</label>
                      <select class="form-control" name="deporte">
                        <option value="">SELECCIONE</option>
                        <?php 
                          if(!empty($table_deportes)){ 
                            foreach ($table_deportes as $r) {
                        ?>
                        <option <?php if ($deporte==$r['id_deporte']): ?>selected<?php endif ?> value="<?php echo $r['id_deporte']; ?>"><?php echo $r['deporte']; ?></option>
                        <?php }} ?>
                      </select>
                    </div>
                    <div class="col-xs-3">
                      <label for="apellidos">Apellidos</label>
                      <input type="text" name="apellidos" class="form-control" value="<?php echo $apellidos; ?>">
                    </div>
                    <div class="col-xs-3">
                      <label for="familia">Familia Numerosa</label>
                      <select name="familia" id="familia" class="form-control">
                        <option value="">SELECCIONE</option>
                        <option <?php if ($familia=='SI'): ?>selected<?php endif ?> value="SI">SI</option>
                        <option <?php if ($familia=='NO'): ?>selected<?php endif ?> value="NO">NO</option>
                      </select>
                    </div>
                    <div class="col-xs-3">
                      <label for="fechas">Rango de Fechas</label>
                        <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input readonly="" name="fechas" type="text" class="form-control pull-right" id="reservation" value="<?php echo $fechas; ?>">
                      </div><!-- /.input group -->
                    </div>
                    <div class="col-xs-3">
                      <label for="sexo">Sexo</label>
                      <select name="sexo" id="sexo" class="form-control">
                        <option value="">SELECCIONE</option>
                        <option <?php if ($sexo=='MASCULINO'): ?>selected<?php endif ?> value="MASCULINO">MASCULINO</option>
                        <option <?php if ($sexo=='FEMENINO'): ?>selected<?php endif ?> value="FEMENINO">FEMENINO</option>
                      </select>
                    </div>
                    <div class="col-xs-3">
                      <label for="afoto">Autorización de Fotos</label>
                      <select name="afoto" id="afoto" class="form-control">
                        <option value="">SELECCIONE</option>
                        <option <?php if ($afoto=='SI'): ?>selected<?php endif ?> value="SI">SI</option>
                        <option <?php if ($afoto=='NO'): ?>selected<?php endif ?> value="NO">NO</option>
                      </select>
                    </div>
                    <div class="col-xs-3">
                      <label for="orden_campo">Orden</label>
                      <select name="orden_campo" id="orden_campo" class="form-control">
                        <option <?php if ($orden_campo=='inscripciones.id_inscripcion'): ?>selected<?php endif ?> value="inscripciones.id_inscripcion">inscripciones.id_inscripcion</option>
                        <option <?php if ($orden_campo=='inscripciones.pagado'): ?>selected<?php endif ?> value="inscripciones.pagado">inscripciones.pagado</option>
                        <option <?php if ($orden_campo=='inscripciones.estado'): ?>selected<?php endif ?> value="inscripciones.estado">inscripciones.estado</option>
                        <option <?php if ($orden_campo=='inscripciones.porcentajes'): ?>selected<?php endif ?> value="inscripciones.porcentajes">inscripciones.porcentajes</option>
                        <option <?php if ($orden_campo=='hijos.dni'): ?>selected<?php endif ?> value="hijos.dni">hijos.dni</option>
                        <option <?php if ($orden_campo=='hijos.nombres'): ?>selected<?php endif ?> value="hijos.nombres">hijos.nombres</option>
                        <option <?php if ($orden_campo=='hijos.apellido_1'): ?>selected<?php endif ?> value="hijos.apellido_1">hijos.apellido_1</option>
                        <option <?php if ($orden_campo=='hijos.apellido_2'): ?>selected<?php endif ?> value="hijos.apellido_2">hijos.apellido_2</option>
                        <option <?php if ($orden_campo=='hijos.fecha_nacimiento'): ?>selected<?php endif ?> value="hijos.fecha_nacimiento">hijos.fecha_nacimiento</option>
                      </select>
                    </div>
                    <div class="col-xs-3">
                      <label for="orden_tipo">Tipo</label>
                      <select name="orden_tipo" id="orden_tipo" class="form-control">
                        <option <?php if ($orden_tipo=='DESC'): ?>selected<?php endif ?> value="DESC">DESCENDENTE</option>
                        <option <?php if ($orden_tipo=='ASC'): ?>selected<?php endif ?> value="ASC">ASCENDENTE</option>
                      </select>
                    </div>
                    <div class="col-xs-3">
                      <label>&nbsp;</label><br />
                      <div class="btn-group">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> FILTRAR</button>
                      <?php  
                      if (strlen($deporte)<=0) {
                        $deporte = 0; 
                      }
                      if (strlen($apellidos)<=0) {
                        $apellidos = 0; 
                      }
                      if (strlen($fechas)<=0) {
                        $fechas = 0; 
                      }
                      if (strlen($sexo)<=0) {
                        $sexo = 0; 
                      }
                      if (strlen($afoto)<=0) {
                        $afoto = 0; 
                      }
                      if (strlen($orden_campo)<=0) {
                        $orden_campo = 0; 
                      }
                      if (strlen($orden_tipo)<=0) {
                        $orden_tipo = 0; 
                      }
                      ?>
                      <a target="_get" href="<?php echo site_url('pdf/listados_deportes/'.$deporte.'/'.$apellidos.'/'.$fechas.'/'.$sexo.'/'.$afoto.'/'.$orden_campo.'/'.$orden_tipo) ?>" class="btn btn-danger"><i class="fa fa-print"></i> IMPRIMIR</a>
                      </div>
                    </div>
                  </div>
                <?php 
                echo form_close(); 
                ?>
              <br />
              <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Deporte</th>
                  <th>Estudiante</th>
                  <th>Foto</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                  if($table){ 
                    foreach ($table as $r) {
                ?>
                <tr>
                  <?php if ($r['tipo']=='DORSAL') { ?>
                  <td><?php echo $r['deporte'].'<br />'.$r['tipo'].': '.$r['valor']; ?></td>
                  <?php }else{ ?>
                  <td><?php echo $r['deporte'].'<br />'.$r['tipo']; ?></td>
                  <?php } ?>
                  <td>
                  <table style="font-weight: normal;">
                    <tbody>
                    <tr>
                      <td>
                        <?php echo '<b>DNI:</b> '.$r['dni'].'<br /><b>Primer Apellido:</b> '.$r['apellido_1'].'<br /><b>Segundo Apellido:</b> '.$r['apellido_2'].'<br /><b>Nombres:</b> '.$r['nombres'].'<br /><b>Fecha de Nacimiento:</b> '.date("d/m/Y", strtotime($r['fecha_nacimiento']));  ?></td>
                      </td>
                      <td width="20px">

                      </td>
                      <td>
                        <?php echo '<br /><b>Teléfono:</b> '.$r['telefono_movil'].'<br /><b>Email:</b> '.$r['email_principal'].'<br /><b>Domicilio:</b> '.$r['direccion'].'<br /><b>Autorización de Foto:</b> '.$r['afoto'];  ?></td>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                  <td>
                  <?php if ($r['foto']): ?>
                    <img src="<?php echo base_url('assets/uploads/'.$r['foto']); ?>" width="100px" height="auto">
                    <?php endif ?>
                  </td>
                  <td>
                    <div class="btn-group">
                      <a title="PDF" target="_get" href="<?php echo site_url('pdf/deportista/'.$r['id_inscripcion']); ?>" class="btn btn-default"><i class="fa fa-print"></i></a>
                    </div>
                  </td>
                </tr>
                <?php }} ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Deporte</th>
                  <th>Estudiante</th>
                  <th>Foto</th>
                  <th>Acciones</th>
                </tr>
                </tfoot>
              </table>
              </td>
            </div>
            <!-- /.box-body -->

          </div>
          <!-- /.box -->
          
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view('dashboard/footer'); ?>