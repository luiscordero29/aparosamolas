<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Deportes extends CI_Controller {

	/**
	 * Controller: Panel
	 * Comments: Gestor de Deportes - Pagina Privada
	 *
	 * 
	 */

	public $controller = "deportes";

	public function __construct()
	{
		parent::__construct();		
		$this->load->driver('session');
		$this->load->model('Deportes_model','',TRUE); 
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
		$data['meta'] = 'APA ROSA MOLAS | Deportes - Lista de Deportes';
		$data['title'] = '<i class="fa fa-fa"></i> Deportes';
		$data['subtitle'] = 'Lista de Deportes';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'		=> 'panel/index',
              	'<i class="fa fa-fa"></i> Deportes'		=> 'deportes/index',
              	'Lista de Deportes'							=> '',              	
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
		$data['table'] 			= $this->Deportes_model->table($table_page*$table_limit,$table_limit,$data['search']);
		$data['table_rows'] 	= $this->Deportes_model->table_rows($data['search']);
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
		    redirect('deportes');
		    
		}

		# Data
		$data['meta'] = 'APA ROSA MOLAS | Deportes - Lista de Deportes';
		$data['title'] = '<i class="fa fa-fa"></i> Deportes';
		$data['subtitle'] = 'Nuevo Registro';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-fa"></i> Deportes'		=> 'deportes/index',
              	'Nuevo Registro'									=> '',              	
            );            
			
		$this->form_validation->set_rules('deporte', 'Deporte', 'trim|required|is_unique[deportes.deporte]');
		$this->form_validation->set_rules('precio', 'Precio', 'trim|required|numeric');
		$this->form_validation->set_rules('tipo', 'Tipo', 'trim|required');	

		if($this->form_validation->run() == FALSE)
		{
				
			$this->load->view($this->controller.'/create',$data);		

		}else{

			$this->Deportes_model->create();
				
			$data['alert']['success'] = 
			array( 
				'Registrado Correctamente',				
			);

			$this->load->view($this->controller.'/create',$data);
		}			
	}

	public function view($id_deporte=false)
	{			

		# Data
		$data['meta'] = 'APA ROSA MOLAS | Deportes - Lista de Deportes';
		$data['title'] = '<i class="fa fa-fa"></i> Deportes';
		$data['subtitle'] = 'Ver Información';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-fa"></i> Deportes'				=> 'deportes/index',
              	'Ver Información'									=> '',              	
            );
			
		$data['row'] = $this->Deportes_model->read($id_deporte);
		
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

	public function update($id_deporte=false)
	{			

		// Control de Acceso
		if(!($this->session->userdata('tipo')=='ADMINISTRADOR'))
   		{     						
		    //If no session, redirect to login page
		    redirect('deportes');
		    
		}

		# Data
		$data['meta'] = 'APA ROSA MOLAS | Deportes - Lista de Deportes';
		$data['title'] = '<i class="fa fa-fa"></i> Deportes';
		$data['subtitle'] = 'Editar Información';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-fa"></i> Deportes'				=> 'deportes/index',
              	'Editar Información'								=> '',              	
            );
			
		$data['row'] = $this->Deportes_model->read($id_deporte);
			
		$this->form_validation->set_rules('deporte', 'Deporte', 'trim|required|callback_deporte_check');
		$this->form_validation->set_rules('precio', 'Precio', 'trim|required|numeric');
		$this->form_validation->set_rules('tipo', 'Tipo', 'trim|required');				

		$this->form_validation->set_message('deporte_check', 'El campo Deporte ingresado ya se encuentra ocupado.');
			

		if($this->form_validation->run() == FALSE)
		{
			$data['row'] = $this->Deportes_model->read($id_deporte);
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
				
			$this->Deportes_model->update();
				
			$data['row'] = $this->Deportes_model->read($id_deporte);
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

	public function delete($id_deporte=false)
	{
		
		// Control de Acceso
		if(!($this->session->userdata('tipo')=='ADMINISTRADOR'))
   		{     						
		    //If no session, redirect to login page
		    redirect('deportes');
		    
		}

		# Data
		$data['meta'] = 'APA ROSA MOLAS | Deportes - Lista de Deportes';
		$data['title'] = '<i class="fa fa-fa"></i> Deportes';
		$data['subtitle'] = 'Eliminar Información';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-fa"></i> Deportes'	=> 'deportes/index',
              	'Eliminar Información'								=> '',              	
            );


        if($id_deporte===FALSE)
		{
			$data['alert']['danger'] = 
				array( 
					'No exite registro ó No puede ser eliminado',				
				);

			$this->load->view($this->controller.'/message',$data);			
		}else{
			
			$data['alert'] = $this->Deportes_model->delete($id_deporte);
				
			$this->load->view($this->controller.'/message',$data);
		}			
			
	}

	public function deporte_check()
  	{
      	$check = $this->Deportes_model->deporte_check();
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