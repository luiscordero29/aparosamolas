<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <section class="content-header">
      <h1>
        <?php echo $title; ?>
        <small><?php echo $subtitle; ?></small>
      </h1>
      <ol class="breadcrumb">
        <?php 
               
          $i=1; $n = count($breadcrumbs);
          foreach ($breadcrumbs as $key => $value) { 
            
            if($n<=$i){
        ?>
              <li class="active"><?php echo $key; ?></li>      
        <?php
            }else{
        ?>
              <li><a href="<?php echo site_url($value); ?>"><?php echo $key; ?></a></li>
        <?php 
            }                   
            $i++;          
          }
   
        ?>  
      </ol>
    </section>