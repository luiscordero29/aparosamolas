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
              <h3 class="box-title">Datos de Acceso</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <dl class="dl-horizontal">
                <dt>ID:</dt>
                <dd><?php echo $row['id_usuario']; ?></dd>
                <dt>Usuario:</dt>
                <dd><?php echo $row['usuario']; ?></dd>
                <dt>Correo:</dt>
                <dd><?php echo $row['correo']; ?></dd>
                <dt>Tipo:</dt>
                <dd><?php echo $row['tipo']; ?></dd>
                <dt>Activo:</dt>
                <dd><?php echo $row['activo']; ?></dd>
              </dl>
            </div>
          </div>
          
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Datos del Tutor</h3>
            </div>
        
            <div class="box-body">
              <dl class="dl-horizontal">
                <dt>ID:</dt>
                <dd><?php echo $row['id_tutor']; ?></dd>
                <dt>DNI:</dt>
                <dd><?php echo $row['dni']; ?></dd>
                <dt>Nombres:</dt>
                <dd><?php echo $row['nombres']; ?></dd>
                <dt>Apellidos:</dt>
                <dd><?php echo $row['apellidos']; ?></dd>
                <dt>Familia Numerosa:</dt>
                <dd><?php echo $row['familia']; ?></dd>
                <dt>Nº carnet familia numerosa:</dt>
                <dd><?php echo $row['carnet']; ?></dd>
                <dt>Dirección:</dt>
                <dd><?php echo $row['direccion']; ?></dd>
                <dt>Población:</dt>
                <dd><?php echo $row['poblacion']; ?></dd>
                <dt>Código Postal:</dt>
                <dd><?php echo $row['codigo_postal']; ?></dd>
                <dt>Teléfono Móvil:</dt>
                <dd><?php echo $row['telefono_movil']; ?></dd>
                <dt>Teléfono fijo (opcional):</dt>
                <dd><?php echo $row['telefono_fijo']; ?></dd>
                <dt>Email 1:</dt>
                <dd><?php echo $row['email_principal']; ?></dd>
                <dt>Email 2 (opcional):</dt>
                <dd><?php echo $row['email_secundario']; ?></dd>
                <dt>Apellidos pareja:</dt>
                <dd><?php echo $row['pareja_nombres']; ?></dd>
                <dt>Apellidos pareja:</dt>
                <dd><?php echo $row['pareja_apellidos']; ?></dd>
                <dt>Teléfono móvil pareja:</dt>
                <dd><?php echo $row['pareja_movil']; ?></dd>
                <dt>Cuenta bancaria:</dt>
                <dd><?php echo $row['cuenta_bancaria']; ?></dd>
              </dl>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view('dashboard/footer'); ?>