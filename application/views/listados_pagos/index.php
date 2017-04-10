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
                      <label for="tutor_apellidos">Tutor Apellidos</label>
                      <input type="text" name="tutor_apellidos" class="form-control" value="<?php echo $tutor_apellidos; ?>">
                    </div>
                    <div class="col-xs-3">
                      <label for="tutor_nombres">Tutor Nombres</label>
                      <input type="text" name="tutor_nombres" class="form-control" value="<?php echo $tutor_nombres; ?>">
                    </div>
                    <div class="col-xs-3">
                      <label for="hijo_apellidos">Apellidos Deportista</label>
                      <input type="text" name="hijo_apellidos" class="form-control" value="<?php echo $hijo_apellidos; ?>">
                    </div>
                    <div class="col-xs-3">
                      <label for="hijo_nombres">Nombres Deportista</label>
                      <input type="text" name="hijo_nombres" class="form-control" value="<?php echo $hijo_nombres; ?>">
                    </div>
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
                      <label for="porcentajes">Porcentaje Pagado</label>
                      <select name="porcentajes" id="porcentajes" class="form-control">
                        <option value="">SELECCIONE</option>
                        <option <?php if ($porcentajes=='0'): ?>selected<?php endif ?> value="0">0%</option>
                        <option <?php if ($porcentajes=='50'): ?>selected<?php endif ?> value="50">50%</option>
                        <option <?php if ($porcentajes=='100'): ?>selected<?php endif ?> value="100">100%</option>
                      </select>
                    </div>
                    <div class="col-xs-3">
                      <label for="estado">Estado</label>
                      <select name="estado" id="estado" class="form-control">
                        <option value="">SELECCIONE</option>
                        <option <?php if ($estado=='NO ENVIADO'): ?>selected<?php endif ?> value="NO ENVIADO">NO ENVIADO</option>
                        <option <?php if ($estado=='ENVIADO'): ?>selected<?php endif ?> value="ENVIADO">ENVIADO</option>
                        <option <?php if ($estado=='DEVUELTO'): ?>selected<?php endif ?> value="DEVUELTO">DEVUELTO</option>
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
                      if (strlen($tutor_apellidos)<=0) {
                        $tutor_apellidos = 0; 
                      }
                      if (strlen($tutor_nombres)<=0) {
                        $tutor_nombres = 0; 
                      }
                      if (strlen($hijo_apellidos)<=0) {
                        $hijo_apellidos = 0; 
                      }
                      if (strlen($hijo_nombres)<=0) {
                        $hijo_nombres = 0; 
                      }
                      if (strlen($deporte)<=0) {
                        $deporte = 0; 
                      }
                      if (strlen($porcentajes)<=0) {
                        $porcentajes = 0; 
                      }
                      if (strlen($estado)<=0) {
                        $estado = 0; 
                      }
                      if (strlen($orden_campo)<=0) {
                        $orden_campo = 0; 
                      }
                      if (strlen($orden_tipo)<=0) {
                        $orden_tipo = 0; 
                      }
                      ?>
                      <a target="_get" href="<?php echo site_url('pdf/listados_pagos/'.$tutor_apellidos.'/'.$tutor_nombres.'/'.$hijo_apellidos.'/'.$hijo_nombres.'/'.$deporte.'/'.$porcentajes.'/'.$estado.'/'.$orden_campo.'/'.$orden_tipo) ?>" class="btn btn-danger"><i class="fa fa-print"></i> IMPRIMIR</a>
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
                  <th>Deportistas</th>
                  <th>Padres</th>
                  <th>Importe Impagado</th>
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
                  <td><?php echo '<b>DNI:</b> '.$r['dni'].'<br /><b>Primer Apellido:</b> '.$r['apellido_1'].'<br /><b>Segundo Apellido:</b> '.$r['apellido_2'].'<br /><b>Nombres:</b> '.$r['nombres'].'<br /><b>Fecha de Nacimiento:</b> '.date("d/m/Y", strtotime($r['fecha_nacimiento']));  ?></td>
                  <td><?php echo '<b>DNI:</b> '.$r['tdni'].'<br /><b>Apellidos:</b> '.$r['tapellidos'].'<br /><b>Nombres:</b> '.$r['tnombres'].'<br /><b>Teléfono:</b> '.$r['telefono_movil'].'<br /><b>Email:</b> '.$r['email_principal']; ?></td>
                  <td>
                  <?php 
                    if ($r['porcentajes'] == '0') {
                      $monto = $r['precio'] - $r['precio']*$r['descuento']*0.01;
                      if ($r['colegio'] == 'NO') {
                        $monto = $monto + 50;
                      }
                    }
                    if ($r['porcentajes'] == '50') {
                      $monto = ($r['precio'] - $r['precio']*$r['descuento']*0.01)*0.5;
                      if ($r['colegio'] == 'NO') {
                        $monto = $monto + 25;
                      }
                    }
                    if ($r['porcentajes'] == '100') { $monto = 0;}
                    echo number_format($monto, 2, ',', '.')." EUR";
                  ?> 
                  </td>
                  <td>
                    <div class="btn-group">
                      <a title="PDF" target="_get" href="<?php echo site_url('pdf/pagos/'.$r['id_inscripcion']); ?>" class="btn btn-default"><i class="fa fa-print"></i></a>
                    </div>
                  </td>
                </tr>
                <?php }} ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Deporte</th>
                  <th>Estudiante</th>
                  <th>Tutor</th>
                  <th>Importe Impagado</th>
                  <th>Acciones</th>
                </tr>
                </tfoot>
              </table>
              </div>
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