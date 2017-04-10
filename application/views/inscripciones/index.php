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
              <?php 
                echo form_open(''); 
              ?>
              <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Estudiante</th>
                  <th>Deporte</th>
                  <th>Precio</th>
                  <th>Pagado</th>
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
                  DNI: <?php echo $r['dni']; ?> <br />
                  Nombres: <?php echo $r['nombres']; ?> <br />
                  Primer Apellido: <?php echo $r['apellido_1']; ?> <br />
                  Segundo Apellido: <?php echo $r['apellido_2']; ?> <br />
                  </td>
                  <td><?php echo $r['deporte']; ?></td>
                  <td><?php echo $r['precio']; ?> Euros</td>
                  <td><?php echo $r['porcentajes']; ?>%</td>
                  <td>
                    <div class="btn-group">
                      <a title="Visualizar" href="<?php echo site_url($this->controller.'/view/'.$r['id_inscripcion']); ?>" class="btn btn-default"><i class="fa fa-eye"></i></a>
                      
                      <?php 
                        if ($r['modificar'] == 'SI') {
                      ?>
                      <a title="Editar" href="<?php echo site_url($this->controller.'/update/'.$r['id_inscripcion']); ?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
                      <?php 
                        }
                        $periodo = $this->Inscripciones_model->periodo(); 
                        if ($periodo['estatus'] == 'ABIERTAS') {
                      ?>
                      <a title="Borrar" onclick="return confirm('¿Desea eliminar el registro?')" href="<?php echo site_url($this->controller.'/delete/'.$r['id_inscripcion']); ?>" class="btn btn-danger"><i class="fa fa-remove"></i></a>
                      <?php 
                        }
                      ?>
                    </div>
                  </td>
                </tr>
                <?php }} ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Estudiante</th>
                  <th>Deporte</th>
                  <th>Precio</th>
                  <th>Pagado</th>
                  <th>Acciones</th>
                </tr>
                </tfoot>
              </table>
              </div>
              <?php 
                echo form_close(); 
              ?>
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