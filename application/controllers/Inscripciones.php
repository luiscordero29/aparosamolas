<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inscripciones extends CI_Controller {

	/**
	 * Controller: Panel
	 * Comments: Gestor de Inscripciones - Pagina Privada
	 *
	 * 
	 */

	public $controller = "inscripciones";

	public function __construct()
	{
		parent::__construct();		
		$this->load->driver('session');
		$this->load->model('Inscripciones_model','',TRUE);
		$this->load->model('Dashboard_model','',TRUE);  
		// Control Sessión
		if(!$this->session->has_userdata('id_usuario'))
   		{     						
		    //If no session, redirect to login page
		    redirect('account/logout');

		}
		// Control de Acceso
		if(!($this->session->userdata('tipo')=='USUARIO'))
   		{     						
		    //If no session, redirect to login page
		    redirect('account/logout');
		    
		}
	}
		

	public function index($table_page=null,$id=null,$search=null)
	{
					
		# Data
		$data['meta'] = 'APA ROSA MOLAS | Inscripciones - Lista de Registros';
		$data['title'] = '<i class="fa fa-gears"></i> Inscripciones';
		$data['subtitle'] = 'Lista de Registros';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-gears"></i> Inscripciones'					=> 'inscripciones/index',
              	'Lista de Registros'									=> '',              	
            );
				
		$table_limit = 100;
		$table_page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;		

		$s = trim($this->input->post('s'));
		$search = trim($search);
		if(!empty($s)){
			$data['search'] = $s;
			$data['search_url'] = '/'.$s;					
		}elseif(!empty($search)){
			$data['search'] = urldecode($search);
			$data['search_url'] = '/'.$search;
		}else{
			$data['search'] = $s;
			$data['search_url'] = '';
		}

		$data['controller'] 	= $this->controller;				
		$data['table'] 			= $this->Inscripciones_model->table($table_page*$table_limit,$table_limit,$data['search']);
		$data['table_rows'] 	= $this->Inscripciones_model->table_rows($data['search']);
		$data['table_page'] 	= $table_page;
		$data['table_limit'] 	= $table_limit;

		$this->load->view($this->controller.'/index',$data);			
		
	}

	public function create()
	{
	
		# Data
		$data['meta'] = 'APA ROSA MOLAS | Inscripciones - Nuevo Registro';
		$data['title'] = '<i class="fa fa-gears"></i> Inscripciones';
		$data['subtitle'] = 'Nuevo Registro';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-gears"></i> Inscripciones'					=> 'inscripciones/index',
              	'Nuevo Registro'									=> '',              	
            );            
			
		$this->form_validation->set_rules('id_deporte', 'Deporte', 'trim|required');
		$this->form_validation->set_rules('id_hijo', 'Hijo', 'trim|required|callback_inscripcion_check');
		$id_deporte = $this->input->post('id_deporte');
		$valor = $this->input->post('valor');
		if (!empty($id_deporte)) {
		    $deporte  = $this->Inscripciones_model->read_deporte($id_deporte);
		    if ($deporte['tipo'] == 'DORSAL') {
		    	# INGRESO DE DORSAL
		    	if ($valor <> 'NUEVO') {
		    		# code...
			    	$this->form_validation->set_rules('valor', 'Introduzca el número de DORSAL del año pasado', 'trim|required|callback_valor_check');
		    	}
		    }
		    /*
		    if ($deporte['tipo'] == 'APUNTARSE') {
		    	# INGRESO DE APUNTARSE
		    	$this->form_validation->set_rules('valor', 'Apuntarse', 'trim|required');
		    }
		    */
		}
		$this->form_validation->set_message('inscripcion_check', 'Su hijo se encuentra inscripto en este deporte.');
		$this->form_validation->set_message('valor_check', 'Ingrese NUEVO sino tiene DORSAL, de lo contrario ingrese el DORSAL el año pasado, el dorsal debe ser del 0 al 99');
		
		$data['table_deportes'] = $this->Inscripciones_model->table_deportes();
		$data['table_hijos'] = $this->Inscripciones_model->table_hijos();

		if($this->form_validation->run() == FALSE)
		{
			$periodo = $this->Inscripciones_model->periodo();	
			if ($periodo['estatus'] == 'ABIERTAS') {
				# Inscripciones Abiertas
				$this->load->view($this->controller.'/create',$data);		
			}else{
				# Inscripciones Cerradas
				$data['alert']['danger'] = 
					array( 
						'Inscripciones se encuentran cerradas',				
					);

				$this->load->view($this->controller.'/message',$data);
			}

		}else{

			$this->Inscripciones_model->create();
				
			$data['alert']['success'] = 
			array( 
				'Registrado Correctamente',				
			);

			$this->load->view($this->controller.'/create',$data);
		}			
	}

	public function view($id_inscripcion=false)
	{			

		# Data
		$data['meta'] = 'APA ROSA MOLAS | Inscripciones - Ver Información';
		$data['title'] = '<i class="fa fa-gears"></i> Inscripciones';
		$data['subtitle'] = 'Ver Información';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-gears"></i> Inscripciones'					=> 'inscripciones/index',
              	'Ver Información'									=> '',              	
            );
			
		$data['row'] = $this->Inscripciones_model->read($id_inscripcion);
		
		if(empty($data['row']))
		{
			$data['alert']['danger'] = 
				array( 
					'No exite registro ó No puede ser eliminado',				
				);

			$this->load->view($this->controller.'/message',$data);
		
		}else{

			$this->load->view($this->controller.'/view',$data);
		
		}
			
	}

	public function update($id_inscripcion=false)
	{			

		# Data
		$data['meta'] = 'APA ROSA MOLAS | Inscripciones - Editar Información';
		$data['title'] = '<i class="fa fa-gears"></i> Inscripciones';
		$data['subtitle'] = 'Editar Información';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-gears"></i> Inscripciones'					=> 'inscripciones/index',
              	'Editar Información'								=> '',              	
            );
				
		$this->form_validation->set_rules('id_deporte', 'Deporte', 'trim|required');
		$this->form_validation->set_rules('id_hijo', 'Hijo', 'trim|required|callback_inscripcion_check2');
		$id_deporte = $this->input->post('id_deporte');
		if (!empty($id_deporte)) {
		    $deporte  = $this->Inscripciones_model->read_deporte($id_deporte);
		    if ($deporte['tipo'] == 'DORSAL') {
		    	# INGRESO DE DORSAL
			    $this->form_validation->set_rules('valor', 'Introduzca el número de DORSAL del año pasado', 'trim|required|is_natural_no_zero');
		    }
		    /*
		    if ($deporte['tipo'] == 'APUNTARSE') {
		    	# INGRESO DE APUNTARSE
		    	$this->form_validation->set_rules('valor', 'Apuntarse', 'trim|required');
		    }
		    */
		}
		$this->form_validation->set_message('inscripcion_check2', 'Su hijo se encuentra inscripto en este deporte.');
		
		$data['table_deportes'] = $this->Inscripciones_model->table_deportes();
		$data['table_hijos'] = $this->Inscripciones_model->table_hijos();

		if($this->form_validation->run() == FALSE)
		{
			$data['row'] = $this->Inscripciones_model->read($id_inscripcion);
			if(empty($data['row']))
			{
				$data['alert']['danger'] = 
					array( 
						'No exite registro ó No puede ser eliminado',				
					);

				$this->load->view($this->controller.'/message',$data);
			}else{

				$this->load->view($this->controller.'/update',$data);			
			
			}
		}else{
				
			$this->Inscripciones_model->update();
				
			$data['row'] = $this->Inscripciones_model->read($id_inscripcion);
			if(empty($data['row']))
			{
				$data['alert']['danger'] = 
					array( 
						'No exite registro ó No puede ser eliminado',				
					);

				$this->load->view($this->controller.'/message',$data);
			}else{

				$data['alert']['success'] = 
					array( 
						'Registrado Correctamente',				
					);

				$this->load->view($this->controller.'/update',$data);			
			
			}

		}			
	}
	
	public function delete($id_inscripcion=false)
	{
		
		# Data
		$data['meta'] = 'APA ROSA MOLAS | Inscripciones - Eliminar Información';
		$data['title'] = '<i class="fa fa-gears"></i> Inscripciones';
		$data['subtitle'] = 'Eliminar Información';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-gears"></i> Inscripciones'					=> 'inscripciones/index',
              	'Eliminar Información'								=> '',              	
            );


        if($id_inscripcion===FALSE)
		{
			$data['alert']['danger'] = 
				array( 
					'No exite registro ó No puede ser eliminado',				
				);

			$this->load->view($this->controller.'/message',$data);			
		}else{
			
			$periodo = $this->Inscripciones_model->periodo();	
			if ($periodo['estatus'] == 'ABIERTAS') {
				# Inscripciones Abiertas
				$check = $this->Inscripciones_model->delete($id_inscripcion);
			
				if($check)
			    {
			        $data['alert']['success'] = 
					array( 
						'Registro Eliminado Correctamente',				
					);
			    }
			    else
			    {         
			        $data['alert']['danger'] = 
					array( 
						'No exite registro ó No puede ser eliminado',				
					);
			    }
					
				$this->load->view($this->controller.'/message',$data);		
			}else{
				# Inscripciones Cerradas
				$data['alert']['danger'] = 
					array( 
						'Inscripciones se encuentran cerradas por lo que no se pueden eliminar los registros',				
					);

				$this->load->view($this->controller.'/message',$data);
			}
			
		}			
			
	}
	
	public function valor_check()
  	{
      	return $this->Inscripciones_model->valor_check();
  	}

  	public function inscripcion_check()
  	{
      	return $this->Inscripciones_model->inscripcion_check();
  	}

  	public function inscripcion_check2()
  	{
      	return $this->Inscripciones_model->inscripcion_check2();
  	}

  	public function valor()
    {
        		     	   
	    $id_hijo = $this->input->post('id_hijo');
	    $id_deporte = $this->input->post('id_deporte');
	    $deporte  = $this->Inscripciones_model->read_deporte($id_deporte);
	    #$info  = $this->Inscripciones_model->read_deporte_info($id_hijo,$id_deporte);
	    if ($deporte['tipo'] == 'DORSAL') {
	    	# INGRESO DE DORSAL
	    	echo '
		    	<div class="form-group">
	                <label for="valor">Introduzca el número de DORSAL del año pasado ó colocar NUEVO</label>
	                <input type="text" name="valor" class="form-control" id="valor" placeholder="Introduzca el número de DORSAL del año pasado" required="" >
	            </div>
		    	';
	    	/*if ($info == true) {
		    	echo '
		    	<div class="form-group">
	                <label for="valor">Introduzca el número de DORSAL del año pasado</label>
	                <input type="text" name="valor" class="form-control" id="valor" placeholder="Introduzca el número de DORSAL del año pasado" required="" >
	            </div>
		    	';
	    	}else{
		    	echo '
		    	<div class="form-group">
	                <label for="valor">NUEVO DORSAL</label>
	                <input type="text" class="form-control" id="valor" placeholder="NUEVO"  readonly="" >
	                <input type="hidden" name="valor" value="NUEVO" >
	            </div>
		    	';
	    	}*/
	    }
	    /*if ($deporte['tipo'] == 'APUNTARSE') {
	    	# INGRESO DE APUNTARSE
		    echo '
		    	<div class="form-group">
	                <label for="valor">Apuntarse</label>
	                <select name="valor" id="valor" class="form-control" required>
	                    <option value="1 DIA">1 DIA</option>
	                    <option value="2 DIAS">2 DIAS</option>
	                </select>
	            </div>
		    ';
	    }*/
    }

}