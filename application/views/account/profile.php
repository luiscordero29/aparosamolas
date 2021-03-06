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
          <!-- general form elements -->
          <?php $this->load->view('dashboard/messages'); ?>
          <?php echo validation_errors('<p class="alert alert-danger">','</p>'); ?>
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $subtitle; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
              $at = array('role' => 'form');
              echo form_open('',$at); 
            ?>
              <div class="box-body">
                <?php 
                  if ($this->session->userdata('tipo') == 'ADMINISTRADOR' or $this->session->userdata('tipo') == 'SUPERVISOR') {
                    # TIPO ADMINISTRADOR
                ?>
                <div class="form-group">
                  <label for="usuario">Usuario</label>
                  <input disabled="" type="text" class="form-control" id="usuario" placeholder="Correo" required="" value="<?php echo $row['usuario']; ?>" >
                </div>
                <div class="form-group">
                  <label for="tipo">Tipo</label>
                  <input disabled="" type="text" class="form-control" id="tipo" placeholder="Tipo" required="" value="<?php echo $row['tipo']; ?>" >
                </div>
                <div class="form-group">
                  <label for="activo">Activo</label>
                  <input disabled="" type="text" class="form-control" id="activo" placeholder="Activo" required="" value="<?php echo $row['activo']; ?>" >
                </div>
                <div class="form-group">
                  <label for="correo">Correo</label>
                  <input type="email" class="form-control" name="correo" id="correo" placeholder="Correo" required="" value="<?php echo $row['correo']; ?>" maxlength="255"  >
                </div>
                <input type="hidden" name="id_usuario" value="<?php echo $row['id_usuario']; ?>">
                <?php 
                  }else{
                ?>
                <div class="form-group">
                  <label for="dni">DNI</label>
                  <input disabled type="text" name="dni" class="form-control" id="dni" placeholder="DNI" placeholder="DNI" autocomplete="off" maxlength="60" value="<?php echo $row['dni']; ?>"  >
                </div>
                <div class="form-group">
                  <label for="nombres">Nombres</label>
                  <input disabled type="text" name="nombres" class="form-control" id="nombres" placeholder="Nombres" autocomplete="off" maxlength="120" value="<?php echo $row['nombres']; ?>" >
                </div>
                <div class="form-group">
                  <label for="apellidos">Apellidos</label>
                  <input disabled type="text" name="apellidos" class="form-control" id="apellidos" placeholder="Apellidos" autocomplete="off" maxlength="120" value="<?php echo $row['apellidos']; ?>" >
                </div>
                <div class="form-group">
                  <label for="familia">Familia Numerosa</label>
                  <select name="familia" id="familia" class="form-control" required>
                    <option value="">SELECCIONE</option>
                    <option value="SI" <?php if ($row['familia']=='SI'): ?>selected<?php endif ?>>SI</option>
                    <option value="NO" <?php if ($row['familia']=='NO'): ?>selected<?php endif ?>>NO</option>
                  </select>                  
                </div> 
                <div id="carnet">
                  <?php if ($row['familia']=='SI'): ?>
                    <div class="form-group">
                      <label for="carnet">Nº carnet familia numerosa</label>
                      <input type="text" name="carnet" class="form-control" id="carnet" placeholder="Nº carnet familia numerosa" required="" value="<?php echo $row['carnet']; ?>">
                    </div>
                  <?php endif ?>
                </div>                
                <div class="form-group">
                  <label for="direccion">Dirección</label>
                  <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Dirección" autocomplete="off" required="" value="<?php echo $row['direccion']; ?>" >
                </div>
                <div class="form-group">
                  <label for="id_poblacion">Población</label>
                  <select name="id_poblacion" id="id_poblacion" class="form-control" required="">
                    <option value="">SELECCIONE</option>
                    <?php 
                      if(!empty($table_poblaciones)){ 
                        foreach ($table_poblaciones as $r) {
                    ?>
                    <option <?php if(!empty($row['id_poblacion']==$r['id_poblacion'])){ echo "selected";} ?> value="<?php echo $r['id_poblacion']; ?>"><?php echo $r['poblacion']; ?></option>
                    <?php }} ?>
                  </select>                  
                </div>
                <div class="form-group">
                  <label for="codigo_postal">Código Postal</label>
                  <input type="text" class="form-control" name="codigo_postal" id="codigo_postal" placeholder="Código Postal" autocomplete="off" required="" maxlength="60" value="<?php echo $row['codigo_postal']; ?>">
                </div>
                <div class="form-group">
                  <label for="telefono_movil">Teléfono Móvil</label>
                  <input type="text" class="form-control" name="telefono_movil" id="telefono_movil" placeholder="Teléfono Móvil" autocomplete="off" required="" maxlength="30" value="<?php echo $row['telefono_movil']; ?>">
                </div>
                <div class="form-group">
                  <label for="telefono_fijo">Teléfono fijo (opcional)</label>
                  <input type="text" class="form-control" name="telefono_fijo" id="telefono_fijo" placeholder="Teléfono fijo (opcional)" autocomplete="off" maxlength="30" value="<?php echo $row['telefono_fijo']; ?>">
                </div>
                <div class="form-group">
                  <label for="email_principal">Email 1:</label>
                  <input type="email" class="form-control" name="email_principal" id="email_principal" placeholder="Email 1" autocomplete="off" required="" value="<?php echo $row['email_principal']; ?>">
                </div>
                <div class="form-group">
                  <label for="email_secundario">Email 2 (opcional):</label>
                  <input type="email" class="form-control" name="email_secundario" id="email_secundario" placeholder="Email 2 (opcional)" autocomplete="off" value="<?php echo $row['email_secundario']; ?>">
                </div>
                <div class="form-group">
                  <label for="pareja_nombres">Nombres pareja (opcional):</label>
                  <input type="text" class="form-control" name="pareja_nombres" id="pareja_nombres" placeholder="Nombres pareja (opcional)" autocomplete="off" maxlength="120" value="<?php echo $row['pareja_nombres']; ?>">
                </div>
                <div class="form-group">
                  <label for="pareja_apellidos">Apellidos pareja (opcional):</label>
                  <input type="text" class="form-control" name="pareja_apellidos" id="pareja_apellidos" placeholder="Apellidos pareja (opcional)" autocomplete="off" maxlength="120" value="<?php echo $row['pareja_apellidos']; ?>">
                </div>
                <div class="form-group">
                  <label for="pareja_movil">Teléfono móvil pareja (opcional):</label>
                  <input type="text" class="form-control" name="pareja_movil" id="pareja_movil" placeholder="Teléfono móvil pareja (opcional)" autocomplete="off" maxlength="30" value="<?php echo $row['pareja_movil']; ?>">
                </div>
                <div class="form-group">
                  <label for="cuenta_bancaria">Número de cuenta bancaria:</label>
                  <input type="text" class="form-control" name="cuenta_bancaria" id="cuenta_bancaria" placeholder="Número de cuenta bancaria" autocomplete="off" required="" value="<?php echo $row['cuenta_bancaria']; ?>">
                </div>
                <input type="hidden" name="id_usuario" value="<?php echo $row['id_usuario']; ?>">
                <input type="hidden" name="id_tutor" value="<?php echo $row['id_tutor']; ?>">
                <?php 
                  }
                ?>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                
              </div>
            <?php 
              echo form_close(''); 
            ?>
          </div>
          <!-- /.box -->
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view('dashboard/footer'); ?>