<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Listados extends CI_Controller {

	/**
	 * Controller: Panel
	 * Comments: Gestor de Listados - Pagina Privada
	 *
	 * 
	 */

	public $controller = "listados";

	public function __construct()
	{
		parent::__construct();		
		$this->load->driver('session');
		$this->load->model('Listados_model','',TRUE);
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
		$data['meta'] = 'APA ROSA MOLAS | Listado de Inscripciones - Lista de Registros';
		$data['title'] = '<i class="fa fa-table"></i> Listado de Inscripciones';
		$data['subtitle'] = 'Listado de Inscripciones';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'						=> 'panel/index',
              	'<i class="fa fa-table"></i> Listado de Inscripciones'		=> 'listados/index',
              	'Listado de Inscripciones'										=> '',              	
            );
						

		$data['tutor'] 			= trim($this->input->post('tutor'));
		$data['hijo'] 			= trim($this->input->post('hijo'));
		$data['deporte'] 		= trim($this->input->post('deporte'));
		$data['estado'] 		= trim($this->input->post('estado'));
		$data['pagado'] 		= trim($this->input->post('pagado'));
		$data['orden_campo'] 	= trim($this->input->post('orden_campo'));
		$data['orden_tipo'] 	= trim($this->input->post('orden_tipo'));
		
		$data['table_deportes'] = $this->Listados_model->table_deportes();

		$data['controller'] 	= $this->controller;				
		$data['table'] 			= $this->Listados_model->table();

		$this->load->view($this->controller.'/index',$data);			
		
	}


}