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
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $tutores; ?></h3>

              <p>Tutores</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
          </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $hijos; ?></h3>

              <p>Hijos</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $inscripciones; ?></h3>

              <p>Inscripciones</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>
       
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $deportes; ?></h3>

              <p>Deportes</p>
            </div>
            <div class="icon">
              <i class="fa fa-gears"></i>
            </div>
          </div>
        </div>
        <?php if($this->session->userdata('tipo')=='ADMINISTRADOR' or $this->session->userdata('tipo')=='SUPERVISOR') { ?>
        <div class="col-lg-3 col-xs-6">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-blue">
              <!-- /.widget-user-image -->
              <h3 class="widget-username"><i class="fa fa-gears"></i> INSCRIPCIONES</h3>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="<?php echo site_url('dashboard/inscripciones'); ?>"><i class="fa fa-lock"></i> Cerrar Proceso</a></li>
                <li><a href="<?php echo site_url('desbloquear_inscripciones/index'); ?>"><i class="fa fa-unlock"></i> Permitir Modificar</a></li>
                <li><a href="<?php echo site_url('recibos_inscripciones/index'); ?>"><i class="fa fa fa-paper-plane"></i> Gestión de Recibos</a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-blue">
              <!-- /.widget-user-image -->
              <h3 class="widget-username"><i class="fa fa-th"></i> LISTADOS</h3>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="<?php echo site_url('listados/index'); ?>"><i class="fa fa-table"></i> Inscripciones</a></li>
                <li><a href="<?php echo site_url('listados_deportes/index'); ?>"><i class="fa fa-table"></i> Deportistas</a></li>
                <li><a href="<?php echo site_url('listados_pagos/index'); ?>"><i class="fa fa-table"></i> Impagos</a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-blue">
              <!-- /.widget-user-image -->
              <h3 class="widget-username"><i class="fa fa-folder-open"></i> ADMINISTRACIÓN</h3>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="<?php echo site_url('poblaciones/index'); ?>"><i class="fa fa-map"></i> Poblaciones</a></li>
                <li><a href="<?php echo site_url('deportes/index'); ?>"><i class="fa fa-fa"></i> Deportes</a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-blue">
              <!-- /.widget-user-image -->
              <h3 class="widget-username"><i class="fa fa-users"></i> GESTIÓN DE USUARIOS</h3>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="<?php echo site_url('administradores/index'); ?>"><i class="fa fa-users"></i> Administradores</a></li>
                <li><a href="<?php echo site_url('coordinadores/index'); ?>"><i class="fa fa-users"></i> Coordinadores</a></li>
                <li><a href="<?php echo site_url('tutores/index'); ?>"><i class="fa fa-users"></i> Padres</a></li>
                <li><a href="<?php echo site_url('ahijos/index'); ?>"><i class="fa fa-users"></i> Deportistas</a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-blue">
              <!-- /.widget-user-image -->
              <h3 class="widget-username"><i class="fa fa-user"></i> MIS DATOS</h3>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="<?php echo site_url('account/index'); ?>"><i class="fa fa-user"></i> Ver Información</a></li>
                <li><a href="<?php echo site_url('account/profile'); ?>"><i class="fa fa-edit"></i> Editar Información</a></li>
                <li><a href="<?php echo site_url('account/password'); ?>"><i class="fa fa-lock"></i> Cambiar Contraseña</a></li>
                <li><a href="<?php echo site_url('account/logout'); ?>"><i class="fa fa-sign-out"></i> Cerrar Sesión</a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php }elseif($this->session->userdata('tipo')=='USUARIO') {  ?>
        <div class="col-lg-3 col-xs-6">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-blue">
              <!-- /.widget-user-image -->
              <h3 class="widget-username"><i class="fa fa-user"></i> MIS DATOS</h3>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="<?php echo site_url('account/index'); ?>"><i class="fa fa-user"></i> Ver Información</a></li>
                <li><a href="<?php echo site_url('account/profile'); ?>"><i class="fa fa-edit"></i> Editar Información</a></li>
                <li><a href="<?php echo site_url('account/password'); ?>"><i class="fa fa-lock"></i> Cambiar Contraseña</a></li>
                <li><a href="<?php echo site_url('account/logout'); ?>"><i class="fa fa-sign-out"></i> Cerrar Sesión</a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-blue">
              <!-- /.widget-user-image -->
              <h3 class="widget-username"><i class="fa fa-users"></i> HIJOS</h3>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="<?php echo site_url('upload/hijos_create'); ?>"><i class="fa fa-file"></i> Alta de Hijo</a></li>
                <li><a href="<?php echo site_url('hijos/index'); ?>"><i class="fa fa-table"></i> Listar Hijos</a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-blue">
              <!-- /.widget-user-image -->
              <h3 class="widget-username"><i class="fa fa-gears"></i> INSCRIPCIONES</h3>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="<?php echo site_url('inscripciones/create'); ?>"><i class="fa fa-file"></i> Crear Registro</a></li>
                <li><a href="<?php echo site_url('inscripciones/index'); ?>"><i class="fa fa-table"></i> Listar Registros</a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        
        
        <!-- ./col -->
      </div>
      <!-- /.row -->


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view('dashboard/footer'); ?>