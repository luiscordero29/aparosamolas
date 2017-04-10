<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Hijos extends CI_Controller {

	/**
	 * Controller: Panel
	 * Comments: Gestor de Hijos - Pagina Privada
	 *
	 * 
	 */

	public $controller = "hijos";

	public function __construct()
	{
		parent::__construct();		
		$this->load->driver('session');
		$this->load->model('Hijos_model','',TRUE);
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
		$data['meta'] = 'APA ROSA MOLAS | Hijos - Lista de Registros';
		$data['title'] = '<i class="fa fa-users"></i> Hijos';
		$data['subtitle'] = 'Lista de Registros';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-users"></i> Hijos'					=> 'hijos/index',
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
		$data['table'] 			= $this->Hijos_model->table($table_page*$table_limit,$table_limit,$data['search']);
		$data['table_rows'] 	= $this->Hijos_model->table_rows($data['search']);
		$data['table_page'] 	= $table_page;
		$data['table_limit'] 	= $table_limit;

		$this->load->view($this->controller.'/index',$data);			
		
	}



	/*public function create()
	{
	
		# Data
		$data['meta'] = 'APA ROSA MOLAS | Hijos - Nuevo Registro';
		$data['title'] = '<i class="fa fa-users"></i> Hijos';
		$data['subtitle'] = 'Nuevo Registro';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-users"></i> Hijos'					=> 'hijos/index',
              	'Nuevo Registro'									=> '',              	
            );            
			
		$this->form_validation->set_rules('dni', 'DNI', 'trim|callback_dni_check|callback_vdni');
		$this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');
		$this->form_validation->set_rules('apellido_1', 'Primer Apellido', 'trim|required');
		$this->form_validation->set_rules('apellido_2', 'Segundo Apellido', 'trim|required');
		#$this->form_validation->set_rules('fecha_nacimiento', 'Fecha de Nacimiento', 'trim|required|callback_fn_check');
		$this->form_validation->set_rules('fn_dia', 'Día', 'trim|required');
		$this->form_validation->set_rules('fn_mes', 'Mes', 'trim|required');
		$this->form_validation->set_rules('fn_ano', 'Año', 'trim|required|callback_fn_check');
		$this->form_validation->set_rules('sexo', 'Sexo', 'trim|required');
		$this->form_validation->set_rules('colegio', 'Pertenece al Colegio', 'trim|required');
		$this->form_validation->set_rules('centro_escolar', 'Centro Escolar', 'trim');	
		$this->form_validation->set_rules('afoto', 'Autorización de Foto', 'required');

		$this->form_validation->set_message('dni_check', 'El campo DNI ingresado ya se encuentra ocupado.');
		$this->form_validation->set_message('fn_check', 'La edad no se encuentra dentro del rango (4 - 20 años).');
		$this->form_validation->set_message('vdni', 'DNI No Valido');


		if($this->form_validation->run() == FALSE)
		{
				
			$this->load->view($this->controller.'/create',$data);		

		}else{
			
			$this->Hijos_model->create();
				
			$data['alert']['success'] = 
			array( 
				'Registrado Correctamente',				
			);

			$this->load->view($this->controller.'/create',$data);
		}			
	}*/

	public function view($id_hijo=false)
	{			

		# Data
		$data['meta'] = 'APA ROSA MOLAS | Hijos - Ver Información';
		$data['title'] = '<i class="fa fa-users"></i> Hijos';
		$data['subtitle'] = 'Ver Información';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-users"></i> Hijos'					=> 'hijos/index',
              	'Ver Información'									=> '',              	
            );
			
		$data['row'] = $this->Hijos_model->read($id_hijo);
		
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

	/*public function update($id_hijo=false)
	{			

		# Data
		$data['meta'] = 'APA ROSA MOLAS | Hijos - Editar Información';
		$data['title'] = '<i class="fa fa-users"></i> Hijos';
		$data['subtitle'] = 'Editar Información';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-users"></i> Hijos'					=> 'hijos/index',
              	'Editar Información'								=> '',              	
            );
			
		$data['row'] = $this->Hijos_model->read($id_hijo);
			
		$this->form_validation->set_rules('dni', 'DNI', 'trim|callback_dni_check2|callback_vdni');
		$this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');
		$this->form_validation->set_rules('apellido_1', 'Primer Apellido', 'trim|required');
		$this->form_validation->set_rules('apellido_2', 'Segundo Apellido', 'trim|required');
		$this->form_validation->set_rules('fecha_nacimiento', 'Fecha de Nacimiento', 'trim|required|callback_fn_check');
		$this->form_validation->set_rules('sexo', 'Sexo', 'trim|required');
		$this->form_validation->set_rules('colegio', 'Pertenece al Colegio', 'trim|required');
		$this->form_validation->set_rules('centro_escolar', 'Centro Escolar', 'trim');	
		$this->form_validation->set_rules('afoto', 'Autorización de Foto', 'required');

		$this->form_validation->set_message('dni_check2', 'El campo DNI ingresado ya se encuentra ocupado.');
		$this->form_validation->set_message('fn_check', 'La edad no se encuentra dentro del rango (4 - 20 años).');
		$this->form_validation->set_message('vdni', 'DNI No Valido');

		if($this->form_validation->run() == FALSE)
		{
			$data['row'] = $this->Hijos_model->read($id_hijo);
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
				
			$this->Hijos_model->update();
				
			$data['row'] = $this->Hijos_model->read($id_hijo);
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
	}*/

	public function delete($id_hijo=false)
	{
		
		# Data
		$data['meta'] = 'APA ROSA MOLAS | Hijos - Eliminar Información';
		$data['title'] = '<i class="fa fa-users"></i> Hijos';
		$data['subtitle'] = 'Eliminar Información';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-users"></i> Hijos'					=> 'hijos/index',
              	'Eliminar Información'								=> '',              	
            );


        if($id_hijo===FALSE)
		{
			$data['alert']['danger'] = 
				array( 
					'No exite registro ó No puede ser eliminado',				
				);

			$this->load->view($this->controller.'/message',$data);			
		}else{
			
			$data['alert'] = $this->Hijos_model->delete($id_hijo);
				
			$this->load->view($this->controller.'/message',$data);
		}			
			
	}
	/*
	public function dni_check()
  	{
      	$check = $this->Hijos_model->dni_check();
      	if($check)
      	{
           	return false;
      	}
      	else
      	{         
           	return true;
      	}
  	}

  	public function dni_check2()
  	{
      	$check = $this->Hijos_model->dni_check();
      	if($check)
      	{
           	return false;
      	}
      	else
      	{         
           	return true;
      	}
  	}

  	public function fn_check()
  	{
      	$check = $this->Hijos_model->fn_check();
      	if($check)
      	{
           	return true;
      	}
      	else
      	{         
           	return false;
      	}
  	}

  	public function vdni()
	{
	    return $this->Hijos_model->dni();
	}*/

}