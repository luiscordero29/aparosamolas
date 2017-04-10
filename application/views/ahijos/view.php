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
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $subtitle; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <dl class="dl-horizontal">
                <dt>ID:</dt>
                <dd><?php echo $row['id_hijo']; ?></dd>
                <dt>DNI:</dt>
                <dd><?php echo $row['dni']; ?></dd>
                <dt>Nombres:</dt>
                <dd><?php echo $row['nombres']; ?></dd>
                <dt>Primer Apellido:</dt>
                <dd><?php echo $row['apellido_1']; ?></dd>
                <dt>Segundo Apellido:</dt>
                <dd><?php echo $row['apellido_2']; ?></dd>
                <dt>Fecha de Nacimiento:</dt>
                <dd><?php echo date("d/m/Y", strtotime($row['fecha_nacimiento'])); ?></dd>
                <dt>Sexo:</dt>
                <dd><?php echo $row['sexo']; ?></dd>
                <dt>Pertenece al Colegio:</dt>
                <dd><?php echo $row['colegio']; ?></dd>
                <dt>Centro Escolar:</dt>
                <dd><?php echo $row['centro_escolar']; ?></dd>
                <dt>Autorización de Foto:</dt>
                <dd><?php echo $row['afoto']; ?></dd>
                <dt>Foto:</dt>
                <dd>
                  <?php if ($row['foto']): ?>
                  <img src="<?php echo base_url('assets/uploads/'.$row['foto']); ?>" width="300px" height="auto">
                  <?php endif ?>
                </dd>
              </dl>
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