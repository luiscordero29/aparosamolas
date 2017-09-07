<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es" xml:lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $meta; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/bootstrap/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css'); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/ionicons/css/ionicons.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/dist/css/AdminLTE.css'); ?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/dist/css/skins/_all-skins.min.css'); ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/plugins/iCheck/flat/blue.css'); ?>">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/plugins/morris/morris.css'); ?>">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.css'); ?>">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/plugins/datepicker/datepicker3.css'); ?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/plugins/daterangepicker/daterangepicker-bs3.css'); ?>">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'); ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url('dashboard/index'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">ARM</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">APA ROSA MOLAS</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs"><i class="fa fa-user"></i> <?php echo $this->session->userdata('usuario') ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                
                <p>
                  <?php 
                    if ($this->session->userdata('tipo') == 'USUARIO') {
                      $nick = $this->Dashboard_model->nick();
                      echo $nick;
                    }else{
                      echo $this->session->userdata('usuario'); 
                    }
                  ?>
                  <small><b>TIPO:</b> <?php echo $this->session->userdata('tipo') ?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo site_url('account/index'); ?>" class="btn btn-default btn-flat">Cuenta</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo site_url('account/logout'); ?>" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <?php  ?>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MENU PRINCIPAL</li>
        <li class="<?php if ($this->uri->segment(1) == 'dashboard'){ echo 'active ';} ?>treeview">
          <a href="<?php echo site_url('dashboard/index'); ?>">
            <i class="fa fa-dashboard"></i> <span>PANEL PRINCIPAL</span>
          </a>
        </li>
        <?php if($this->session->userdata('tipo')=='ADMINISTRADOR' or $this->session->userdata('tipo')=='SUPERVISOR') { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-gears"></i>
            <span>INSCRIPCIONES</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo site_url('dashboard/descuentos'); ?>"><i class="fa fa-check"></i> Procesar Descuentos</a></li>
            <li><a href="<?php echo site_url('dashboard/inscripciones'); ?>"><i class="fa fa-lock"></i> Cerrar Proceso</a></li>
            <li><a href="<?php echo site_url('desbloquear_inscripciones/index'); ?>"><i class="fa fa-unlock"></i> Permitir Modificar</a></li>
            <li><a href="<?php echo site_url('recibos_inscripciones/index'); ?>"><i class="fa fa fa-paper-plane"></i> Gestión de Recibos</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-th"></i>
            <span>LISTADOS</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo site_url('listados/index'); ?>"><i class="fa fa-table"></i> Inscripciones</a></li>
            <li><a href="<?php echo site_url('listados_deportes/index'); ?>"><i class="fa fa-table"></i> Deportistas</a></li>
            <li><a href="<?php echo site_url('listados_pagos/index'); ?>"><i class="fa fa-table"></i> Impagos</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder-open"></i>
            <span>ADMINISTRACIÓN</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo site_url('poblaciones/index'); ?>"><i class="fa fa-map"></i> Poblaciones</a></li>
            <li><a href="<?php echo site_url('deportes/index'); ?>"><i class="fa fa-fa"></i> Deportes</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>GESTIÓN DE USUARIOS</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo site_url('administradores/index'); ?>"><i class="fa fa-users"></i> Administradores</a></li>
            <li><a href="<?php echo site_url('coordinadores/index'); ?>"><i class="fa fa-users"></i> Coordinadores</a></li>
            <li><a href="<?php echo site_url('tutores/index'); ?>"><i class="fa fa-users"></i> Padres</a></li>
            <li><a href="<?php echo site_url('ahijos/index'); ?>"><i class="fa fa-users"></i> Deportistas</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>MIS DATOS</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo site_url('account/index'); ?>"><i class="fa fa-user"></i> Ver Información</a></li>
            <li><a href="<?php echo site_url('account/profile'); ?>"><i class="fa fa-edit"></i> Editar Información</a></li>
            <li><a href="<?php echo site_url('account/password'); ?>"><i class="fa fa-lock"></i> Cambiar Contraseña</a></li>
            <li><a href="<?php echo site_url('account/logout'); ?>"><i class="fa fa-sign-out"></i> Cerrar Sesión</a></li>
          </ul>
        </li>
        <?php }elseif($this->session->userdata('tipo')=='USUARIO') {  ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>MIS DATOS</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo site_url('account/index'); ?>"><i class="fa fa-user"></i> Ver Información</a></li>
            <li><a href="<?php echo site_url('account/profile'); ?>"><i class="fa fa-edit"></i> Editar Información</a></li>
            <li><a href="<?php echo site_url('account/password'); ?>"><i class="fa fa-lock"></i> Cambiar Contraseña</a></li>
            <li><a href="<?php echo site_url('account/logout'); ?>"><i class="fa fa-sign-out"></i> Cerrar Sesión</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>HIJOS</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo site_url('upload/hijos_create'); ?>"><i class="fa fa-file"></i> Alta de Hijo</a></li>
            <li><a href="<?php echo site_url('hijos/index'); ?>"><i class="fa fa-table"></i> Listar Hijos</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-gears"></i>
            <span>INSCRIPCIONES</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo site_url('inscripciones/create'); ?>"><i class="fa fa-file"></i> Crear Registro</a></li>
            <li><a href="<?php echo site_url('inscripciones/index'); ?>"><i class="fa fa-table"></i> Listar Registros</a></li>
          </ul>
        </li>
        
        <?php } ?>
        
        

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>