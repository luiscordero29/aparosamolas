<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Listados_deportes extends CI_Controller {

	/**
	 * Controller: Panel
	 * Comments: Gestor de Listados_deportes - Pagina Privada
	 *
	 * 
	 */

	public $controller = "listados_deportes";

	public function __construct()
	{
		parent::__construct();		
		$this->load->driver('session');
		$this->load->model('Listados_deportes_model','',TRUE);
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
		$data['meta'] = 'APA ROSA MOLAS | Listado de Deportistas - Lista de Registros';
		$data['title'] = '<i class="fa fa-table"></i> Listado de Deportistas';
		$data['subtitle'] = 'Listado de Deportistas';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'						=> 'panel/index',
              	'<i class="fa fa-table"></i> Listado de Deportistas'		=> 'listados_deportes/index',
              	'Listado de Deportistas'									=> '',              	
            );
						
		$data['deporte'] 		= trim($this->input->post('deporte'));
		$data['apellidos'] 		= trim($this->input->post('apellidos'));
		$data['familia'] 		= trim($this->input->post('familia'));
		$data['fechas'] 		= trim($this->input->post('fechas'));
		$data['sexo'] 			= trim($this->input->post('sexo'));
		$data['afoto'] 			= trim($this->input->post('afoto'));
		$data['orden_campo'] 	= trim($this->input->post('orden_campo'));
		$data['orden_tipo'] 	= trim($this->input->post('orden_tipo'));
		
		$data['table_deportes'] = $this->Listados_deportes_model->table_deportes();

		$data['controller'] 	= $this->controller;				
		$data['table'] 			= $this->Listados_deportes_model->table();

		$this->load->view($this->controller.'/index',$data);			
		
	}


}