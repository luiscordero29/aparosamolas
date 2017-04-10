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
              
              <div class="box-tools">
                <?php 
                echo form_open(''); 
                ?>
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="s" class="form-control pull-right" placeholder="Buscar" value="<?php echo $search; ?>">
                </div>
                <?php 
                echo form_close(); 
                ?>
              </div>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
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
                  <td><?php echo '<b>Fecha:</b> '.date("d/m/Y", strtotime($r['fecha'])).'<br /><b>Hora:</b> '.date("h:m A", strtotime($r['hora'])); ?></td>
                  <td><?php echo '<b>DNI:</b> '.$r['tdni'].'<br /><b>Apellidos:</b> '.$r['tapellidos'].'<br /><b>Nombres:</b> '.$r['tnombres']; ?></td>
                  <td><?php echo '<b>DNI:</b> '.$r['dni'].'<br /><b>Primer Apellido:</b> '.$r['apellido_1'].'<br /><b>Segundo Apellido:</b> '.$r['apellido_2'].'<br /><b>Nombres:</b> '.$r['nombres'].'<br /><b>Fecha de Nacimiento:</b> '.date("d/m/Y", strtotime($r['fecha_nacimiento']));  ?></td>
                  <td><?php echo $r['deporte'].'<br />'.$r['tipo'].' '.$r['valor']; ?></td>
                  <td><?php echo '<b>Precio:</b> '.$r['precio'].' Bs <br /><b>Descuento:</b> '.$r['descuento'].'% <br /><b>Pagado:</b> '.$r['pagado'].'<br /><b>Porcentajes:</b> '.$r['porcentajes'].'% <br /><b>Estado:</b> '.$r['estado'].'<br /><b>Modificar:</b> '.$r['modificar'] ?></td>
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
              <div class="row">
                <div class="col-sm-12">
                  <div id="example1_paginate" class="dataTables_paginate paging_simple_numbers">
                    <ul class="pagination">
                      <?php            
                        $pagination = (int)($table_rows / $table_limit);
                        for ($item=0; $item <= $pagination ; $item++) { 
                      ?>                                         
                          <li <?php if($item == $table_page): ?>class="active"<?php endif; ?>>
                            <a href="<?php echo site_url($this->controller.'/index/table_page/'.$item.$search_url); ?>">
                              <?php echo $item+1; ?>
                            </a>
                          </li>
                      <?php                            
                        }
                      ?>
                      
                    </ul>
                  </div>
                </div>
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