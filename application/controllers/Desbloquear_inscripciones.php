<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Desbloquear_inscripciones extends CI_Controller {

	/**
	 * Controller: Panel
	 * Comments: Gestor de Desbloquear_inscripciones - Pagina Privada
	 *
	 * 
	 */

	public $controller = "desbloquear_inscripciones";

	public function __construct()
	{
		parent::__construct();		
		$this->load->driver('session');
		$this->load->model('Desbloquear_inscripciones_model','',TRUE);
		$this->load->model('Dashboard_model','',TRUE);  
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
		$data['meta'] = 'APA ROSA MOLAS | Desbloquear Inscripciones - Lista de Registros';
		$data['title'] = '<i class="fa fa-unlock"></i> Desbloquear Inscripciones';
		$data['subtitle'] = 'Lista de Registros';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'						=> 'panel/index',
              	'<i class="fa fa-unlock"></i> Desbloquear Inscripciones'	=> 'desbloquear_inscripciones/index',
              	'Lista de Registros'										=> '',              	
            );
				
		$table_limit = 50;
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
		$data['table'] 			= $this->Desbloquear_inscripciones_model->table($table_page*$table_limit,$table_limit,$data['search']);
		$data['table_rows'] 	= $this->Desbloquear_inscripciones_model->table_rows($data['search']);
		$data['table_page'] 	= $table_page;
		$data['table_limit'] 	= $table_limit;

		$this->load->view($this->controller.'/index',$data);			
		
	}

	public function update($id_inscripcion=false)
	{			

		// Control de Acceso
		if(!($this->session->userdata('tipo')=='ADMINISTRADOR'))
   		{     						
		    //If no session, redirect to login page
		    redirect('desbloquear_inscripciones');
		    
		}

		# Data
		$data['meta'] = 'APA ROSA MOLAS | Desbloquear_inscripciones - Editar Información';
		$data['title'] = '<i class="fa fa-gears"></i> Desbloquear Inscripciones';
		$data['subtitle'] = 'Editar Información';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'						=> 'panel/index',
              	'<i class="fa fa-unlock"></i> Desbloquear Inscripciones'	=> 'desbloquear_inscripciones/index',
              	'Editar Información'										=> '',              	
            );
				
		$this->form_validation->set_rules('modificar', 'Desbloquear Inscripción para el tutor', 'trim|required');
	

		if($this->form_validation->run() == FALSE)
		{
			$data['row'] = $this->Desbloquear_inscripciones_model->read($id_inscripcion);
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
				
			$this->Desbloquear_inscripciones_model->update();
				
			$data['row'] = $this->Desbloquear_inscripciones_model->read($id_inscripcion);
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


}