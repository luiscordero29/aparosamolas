<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Poblaciones extends CI_Controller {

	/**
	 * Controller: Panel
	 * Comments: Gestor de Poblaciones - Pagina Privada
	 *
	 * 
	 */

	public $controller = "poblaciones";

	public function __construct()
	{
		parent::__construct();		
		$this->load->driver('session');
		$this->load->model('Poblaciones_model','',TRUE); 
		// Control Sessión
		if(!$this->session->has_userdata('id_usuario'))
   		{     						
		    //If no session, redirect to login page
		    redirect('account/logout');

		}
		// Control de Acceso
		if(!($this->session->userdata('tipo')=='ADMINISTRADOR' or $this->session->userdata('tipo')=='SUPERVISOR'))
   		{     						
		    //If no session, redirect to login page
		    redirect('account/logout');
		    
		}
	}
		

	public function index($table_page=null,$id=null,$search=null)
	{
					
		# Data
		$data['meta'] = 'APA ROSA MOLAS | Poblaciones - Lista de Poblaciones';
		$data['title'] = '<i class="fa fa-map"></i> Poblaciones';
		$data['subtitle'] = 'Lista de Poblaciones';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-map"></i> Poblaciones'	=> 'poblaciones/index',
              	'Lista de Poblaciones'							=> '',              	
            );
				
		$table_limit = 5;
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
		$data['table'] 			= $this->Poblaciones_model->table($table_page*$table_limit,$table_limit,$data['search']);
		$data['table_rows'] 	= $this->Poblaciones_model->table_rows($data['search']);
		$data['table_page'] 	= $table_page;
		$data['table_limit'] 	= $table_limit;

		$this->load->view($this->controller.'/index',$data);			
		
	}



	public function create()
	{
	
		// Control de Acceso
		if(!($this->session->userdata('tipo')=='ADMINISTRADOR'))
   		{     						
		    //If no session, redirect to login page
		    redirect('poblaciones');
		    
		}

		# Data
		$data['meta'] = 'APA ROSA MOLAS | Poblaciones - Lista de Poblaciones';
		$data['title'] = '<i class="fa fa-map"></i> Poblaciones';
		$data['subtitle'] = 'Nuevo Registro';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-map"></i> Poblaciones'		=> 'poblaciones/index',
              	'Nuevo Registro'									=> '',              	
            );            
			
		$this->form_validation->set_rules('poblacion', 'Población', 'trim|required|is_unique[poblaciones.poblacion]');	

		if($this->form_validation->run() == FALSE)
		{
				
			$this->load->view($this->controller.'/create',$data);		

		}else{

			$this->Poblaciones_model->create();
				
			$data['alert']['success'] = 
			array( 
				'Registrado Correctamente',				
			);

			$this->load->view($this->controller.'/create',$data);
		}			
	}

	public function view($id_poblacion=false)
	{			

		# Data
		$data['meta'] = 'APA ROSA MOLAS | Poblaciones - Lista de Poblaciones';
		$data['title'] = '<i class="fa fa-map"></i> Poblaciones';
		$data['subtitle'] = 'Ver Información';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-map"></i> Poblaciones'				=> 'poblaciones/index',
              	'Ver Información'									=> '',              	
            );
			
		$data['row'] = $this->Poblaciones_model->read($id_poblacion);
		
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

	public function update($id_poblacion=false)
	{			

		// Control de Acceso
		if(!($this->session->userdata('tipo')=='ADMINISTRADOR'))
   		{     						
		    //If no session, redirect to login page
		    redirect('poblaciones');
		    
		}

		# Data
		$data['meta'] = 'APA ROSA MOLAS | Poblaciones - Lista de Poblaciones';
		$data['title'] = '<i class="fa fa-map"></i> Poblaciones';
		$data['subtitle'] = 'Editar Información';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-map"></i> Poblaciones'				=> 'poblaciones/index',
              	'Editar Información'								=> '',              	
            );
			
		$data['row'] = $this->Poblaciones_model->read($id_poblacion);
			
		$this->form_validation->set_rules('poblacion', 'Población', 'trim|required|callback_poblacion_check');			

		$this->form_validation->set_message('poblacion_check', 'El campo Población ingresado ya se encuentra ocupado.');
			

		if($this->form_validation->run() == FALSE)
		{
			$data['row'] = $this->Poblaciones_model->read($id_poblacion);
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
				
			$this->Poblaciones_model->update();
				
			$data['row'] = $this->Poblaciones_model->read($id_poblacion);
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

	public function delete($id_poblacion=false)
	{
		
		// Control de Acceso
		if(!($this->session->userdata('tipo')=='ADMINISTRADOR'))
   		{     						
		    //If no session, redirect to login page
		    redirect('poblaciones');
		    
		}

		# Data
		$data['meta'] = 'APA ROSA MOLAS | Poblaciones - Lista de Poblaciones';
		$data['title'] = '<i class="fa fa-map"></i> Poblaciones';
		$data['subtitle'] = 'Eliminar Información';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-map"></i> Poblaciones'	=> 'poblaciones/index',
              	'Eliminar Información'								=> '',              	
            );


        if($id_poblacion===FALSE)
		{
			$data['alert']['danger'] = 
				array( 
					'No exite registro ó No puede ser eliminado',				
				);

			$this->load->view($this->controller.'/message',$data);			
		}else{
			
			$data['alert'] = $this->Poblaciones_model->delete($id_poblacion);
				
			$this->load->view($this->controller.'/message',$data);
		}			
			
	}

	public function poblacion_check()
  	{
      	$check = $this->Poblaciones_model->poblacion_check();
      	if($check)
      	{
           	return false;
      	}
      	else
      	{         
           	return true;
      	}
  	}

}