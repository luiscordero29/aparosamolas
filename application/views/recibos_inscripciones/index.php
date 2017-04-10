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
              <div class="box-tools-create">  
              </div>
            <!-- /.box-header -->
            <div class="box-body">
                
                  <div class="row">
                    <?php 
                    $at = array('id' => 'search');
                    echo form_open('',$at); 
                    ?>
                    <div class="col-xs-3">
                      <label for="tutor">Tutor</label>
                      <input type="text" name="tutor" class="form-control" value="<?php echo $tutor; ?>">
                    </div>
                    <div class="col-xs-3">
                      <label for="hijo">Hijo</label>
                      <input type="text" name="hijo" class="form-control" value="<?php echo $hijo; ?>">
                    </div>
                    <div class="col-xs-2">
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
                    <div class="col-xs-2">
                      <label for="estado">Estado</label>
                      <select name="estado" id="estado" class="form-control">
                        <option value="">SELECCIONE</option>
                        <option <?php if ($estado=='NO ENVIADO'): ?>selected<?php endif ?> value="NO ENVIADO">NO ENVIADO</option>
                        <option <?php if ($estado=='ENVIADO'): ?>selected<?php endif ?> value="ENVIADO">ENVIADO</option>
                        <option <?php if ($estado=='DEVUELTO'): ?>selected<?php endif ?> value="DEVUELTO">DEVUELTO</option>
                      </select>
                    </div>
                    <div class="col-xs-2">
                      <label for="pagado">Pagado</label>
                      <select name="pagado" id="pagado" class="form-control">
                        <option value="">SELECCIONE</option>
                        <option <?php if ($pagado=='NO'): ?>selected<?php endif ?> value="NO">NO</option>
                        <option <?php if ($pagado=='MITAD'): ?>selected<?php endif ?> value="MITAD">MITAD</option>
                        <option <?php if ($pagado=='COMPLETO'): ?>selected<?php endif ?> value="COMPLETO">COMPLETO</option>
                      </select>
                    </div>
                    <div class="col-xs-3">
                      <label>&nbsp;</label><br />
                     
                      <button type="submit" class="btn btn-block btn-default"><i class="fa fa-search"></i> FILTRAR</button></button>
                   
                    </div>

                    <?php 
                    echo form_close(); 
                    ?>
                    <div class="col-xs-3">
                      <label>&nbsp;</label><br />
                      
                      <button class="btn btn-block btn-success" data-toggle="modal" data-target="#C19Modal"><i class="fa fa-gears"></i> PROCESAR RECIBOS</button>
                      
                    </div>
                  </div>
                  </div>

              <?php 
                $at = array('id' => 'FormC19');
                echo form_open($this->controller.'/cuaderno19/',$at); 
              ?>
              <input type="hidden" id="importe" name="importe" value="">
              <input type="hidden" id="descargar" name="descargar" value="">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>
                    <div class="checkbox">
                      <label>
                        <input id="checkAll" type="checkbox" name="">
                      </label>
                    </div>
                  </th>
                  <th>Registro</th>
                  <th>Tutor</th>
                  <th>Estudiante</th>
                  <th>Deporte</th>
                  <th>Inscripción</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                  if($table){ 
                    foreach ($table as $r) {
                ?>
                <tr>
                  <td>
                    <?php 
                      if ($r['porcentajes']!='100') {                      
                    ?>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="id_inscripcion[]" value="<?php echo $r['id_inscripcion']; ?>">
                      </label>
                    </div>
                    <?php } ?>
                  </td>
                  <td><?php echo '<b>Fecha:</b> '.date("d/m/Y", strtotime($r['fecha'])).'<br /><b>Hora:</b> '.date("h:m A", strtotime($r['hora'])); ?></td>
                  <td><?php echo '<b>DNI:</b> '.$r['tdni'].'<br /><b>Apellidos:</b> '.$r['tapellidos'].'<br /><b>Nombres:</b> '.$r['tnombres']; ?></td>
                  <td><?php echo '<b>DNI:</b> '.$r['dni'].'<br /><b>Primer Apellido:</b> '.$r['apellido_1'].'<br /><b>Segundo Apellido:</b> '.$r['apellido_2'].'<br /><b>Nombres:</b> '.$r['nombres'].'<br /><b>Fecha de Nacimiento:</b> '.date("d/m/Y", strtotime($r['fecha_nacimiento']));  ?></td>
                  <td><?php echo $r['deporte'].'<br />'.$r['tipo'].': '.$r['valor']; ?></td>
                  <td><?php echo '<b>Precio:</b> '.$r['precio'].' Eur <br /><b>Descuento:</b> '.$r['descuento'].'% <br /><b>Pagado:</b> '.$r['pagado'].'<br /><b>Porcentajes:</b> '.$r['porcentajes'].'% <br /><b>Estado:</b> '.$r['estado'].'<br /><b>Modificar:</b> '.$r['modificar'] ?></td>
                  <td>
                    <div class="btn-group">
                      <a title="Editar" href="<?php echo site_url($this->controller.'/update/'.$r['id_inscripcion']); ?>" class="btn btn-info"><i class="fa fa-edit"></i></a>  
                    </div>
                  </td>
                </tr>
                <?php }} ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Registro</th>
                  <th>Tutor</th>
                  <th>Estudiante</th>
                  <th>Deporte</th>
                  <th>Inscripción</th>
                  <th>Acciones</th>
                </tr>
                </tfoot>
              </table>
              </div>
              <?php 
                echo form_close(); 
              ?>

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