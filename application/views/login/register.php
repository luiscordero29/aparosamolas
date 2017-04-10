<!DOCTYPE html>
<html lang="es" xml:lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>APA ROSA MOLAS | Registrarse</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/bootstrap/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css'); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/ionicons/css/ionicons.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/dist/css/AdminLTE.min.css'); ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/plugins/iCheck/square/blue.css'); ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
    .read-normas {
      height: 150px;
      overflow-y: auto;
      background: #eee;
      padding: 15px;
      border: 1px solid #ddd;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?php echo site_url(''); ?>">
      <img src="<?php echo base_url('assets/images/logo.png'); ?>">
    </a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Registrarse</p>

    <?php echo validation_errors('<p class="alert alert-danger">','</p>'); ?>

    <?php 
      echo form_open(''); 
    ?>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="dni" id="dni" placeholder="DNI"  autocomplete="off" required="" autofocus="" maxlength="60" value="<?php echo set_value('dni'); ?>" />
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Apellidos"  autocomplete="off" required="" maxlength="120" value="<?php echo set_value('apellidos'); ?>"/>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Nombres"  autocomplete="off" required="" maxlength="120" value="<?php echo set_value('nombres'); ?>"/>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Dirección"  autocomplete="off" required=""  value="<?php echo set_value('direccion'); ?>"/>
      </div>
      <div class="form-group has-feedback">
        <select class="form-control" name="id_poblacion" id="id_poblacion" required="">
          <?php 
            if(!empty($table_poblaciones)){ 
              foreach ($table_poblaciones as $r) {
          ?>
          <option <?php if(!empty(set_value('id_poblacion')==$r['id_poblacion'])){ echo "selected";} elseif($r['id_poblacion']=='52') { echo "selected";} ?> value="<?php echo $r['id_poblacion']; ?>"><?php echo $r['poblacion']; ?></option>
          <?php }} ?>
        </select>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="codigo_postal" id="codigo_postal" placeholder="Código postal"  autocomplete="off" required="" maxlength="60"  value="<?php echo set_value('codigo_postal'); ?>"/>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="telefono_fijo" id="telefono_fijo" placeholder="Teléfono fijo (opcional)"  autocomplete="off" maxlength="30"  value="<?php echo set_value('telefono_fijo'); ?>"/>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="telefono_movil" id="telefono_movil" placeholder="Teléfono móvil"  autocomplete="off" required="" maxlength="30"  value="<?php echo set_value('telefono_movil'); ?>"/>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="email_principal" id="email_principal" placeholder="Email 1"  autocomplete="off" required=""  value="<?php echo set_value('email_principal'); ?>"/>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="email_secundario" id="email_secundario" placeholder="Email 2 (opcional)"  autocomplete="off"  value="<?php echo set_value('email_secundario'); ?>"/>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="pareja_nombres" id="pareja_nombres" placeholder="Nombres pareja (opcional)"  autocomplete="off" maxlength="120" value="<?php echo set_value('pareja_nombres'); ?>"/>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="pareja_apellidos" id="pareja_apellidos" placeholder="Apellidos pareja (opcional)"  autocomplete="off" maxlength="120" value="<?php echo set_value('pareja_apellidos'); ?>"/>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="pareja_movil" id="pareja_movil" placeholder="Teléfono móvil pareja (opcional)"  autocomplete="off" maxlength="30"  value="<?php echo set_value('pareja_movil'); ?>"/>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="cuenta_bancaria" id="cuenta_bancaria" placeholder="NUMERO DE CUENTA IBAN"  autocomplete="off" required=""  value="<?php echo set_value('cuenta_bancaria'); ?>"/>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña"  autocomplete="off" required="" />
      </div>
      <div class="form-group has-feedback">
        <div class="checkbox icheck">
          <label>
            <input type="checkbox" name="noticias" value="SI"> Acepto incluir mi email en el newsletter la web del APA para recibir noticias.
          </label>
        </div>
      </div>
      <div class="form-group has-feedback">
        <div class="read-normas">
          <p>            
          Autorización para el tratamiento de datos para uso exclusivo del APA
          </p>
          <p>
          En cumplimiento de la Ley 15/1999, de 13 de diciembre, de protección de datos de carácter personal, se informa que los datos proporcionados se incorporarán a una base de datos de la cual es responsable APA ROSA MOLAS ante el cual los interesados podrán ejercitar sus derecho de acceso, rectificación, oposición y cancelación en la siguiente dirección: APA Rosa Molas, Vía Ibérica 25 – Zaragoza.  Todos los datos solicitados son de carácter obligatorio y el hecho de no proporcionarlos puede acarrear que el solicitante no quede inscrito o que no se le proporcione el material adecuado.La finalidad de dicho fichero es entre otras, gestionar las actividades deportivas  y culturales organizadas por la citada responsable.
          </p>
          <p>  
          SI AUTORIZO
          </p>
          <br><br>
          <p>
          Autorización a la difusión de imágenes para uso exclusivo del APA
          </p>
          <p>
          Debido a que la propia imagen está reconocida en el art. 18.1 de La Constitución y regulado por la Ley Orgánica 1/1982 del 5 de mayo, el padre, la madre o responsable legal del participante autoriza a la difusión de las fotografías e imágenes por cualquier otro medio gráfico, (prensa, televisión, folletos, etc..) siempre que tenga por finalidad la divulgación, promoción e información de la Sección Deportes del APA. Asimismo, autoriza a que el menor sea fotografiado y filmado durante la actividad deportiva y que las fotografías e imágenes en las que aparece puedan ser incorporadas a la página web del APA
          </p>
        </div>
      </div>      
      <div class="form-group has-feedback">
        <div class="checkbox icheck">
          <label>
            <input type="checkbox" name="condiciones_1" value="SI"> Acepto los terminos y condiciones.
          </label>
        </div>
      </div>
      <div class="form-group has-feedback">
        <div class="read-normas">
          <p>  
          Autorización a la difusión de imágenes para uso exclusivo del APA
          </p>
          <p> 
          Debido a que la propia imagen está reconocida en el art. 18.1 de La
          Constitución y regulado por la Ley Orgánica 1/1982 del 5 de mayo, el
          padre, la madre o responsable legal del participante autoriza a la
          difusión de las fotografías e imágenes por cualquier otro medio
          gráfico, (prensa, televisión, folletos, etc..) siempre que tenga por
          finalidad la divulgación, promoción e información de la Sección
          Deportes del APA. Asimismo, autoriza a que el menor sea fotografiado y
          filmado durante la actividad deportiva y que las fotografías e
          imágenes en las que aparece puedan ser incorporadas a la página web
          del Colegio
          </p>
          <p> 
           SI AUTORIZO <br/>
           NO AUTORIZO
          </p></div>
      </div>      
      <div class="form-group has-feedback">
        <div class="checkbox icheck">
          <label>
            <input type="checkbox" name="condiciones_2" value="SI"> Acepto otros los terminos y condiciones.
          </label>
        </div>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Registrarse</button>
        </div>
        <!-- /.col -->
      </div>
    <?php 
      echo form_close(''); 
    ?>
    <br>
    <a href="<?php echo site_url(''); ?>">Iniciar Sesión</a>
    <br>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.0 -->
<script src="<?php echo base_url('assets/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js'); ?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('assets/AdminLTE/bootstrap/js/bootstrap.min.js'); ?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/AdminLTE/plugins/iCheck/icheck.min.js'); ?>"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
