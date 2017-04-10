<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Listados_pagos extends CI_Controller {

	/**
	 * Controller: Panel
	 * Comments: Gestor de Listados_pagos - Pagina Privada
	 *
	 * 
	 */

	public $controller = "listados_pagos";

	public function __construct()
	{
		parent::__construct();		
		$this->load->driver('session');
		$this->load->model('Listados_pagos_model','',TRUE);
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
		$data['meta'] = 'APA ROSA MOLAS | Listado de Impagos - Lista de Registros';
		$data['title'] = '<i class="fa fa-table"></i> Listado de Impagos';
		$data['subtitle'] = 'Listado de Impagos';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'						=> 'panel/index',
              	'<i class="fa fa-table"></i> Listado de Impagos'			=> 'listados_pagos/index',
              	'Listado de Impagos'										=> '',              	
            );
						
		$data['tutor_apellidos'] 	= trim($this->input->post('tutor_apellidos'));
		$data['tutor_nombres'] 		= trim($this->input->post('tutor_nombres'));
		$data['hijo_apellidos'] 	= trim($this->input->post('hijo_apellidos'));
		$data['hijo_nombres'] 		= trim($this->input->post('hijo_nombres'));
		$data['deporte'] 			= trim($this->input->post('deporte'));
		$data['porcentajes'] 		= trim($this->input->post('porcentajes'));
		$data['estado'] 			= trim($this->input->post('estado'));
		$data['orden_campo'] 		= trim($this->input->post('orden_campo'));
		$data['orden_tipo'] 		= trim($this->input->post('orden_tipo'));

		$data['table_deportes'] = $this->Listados_pagos_model->table_deportes();

		$data['controller'] 	= $this->controller;				
		$data['table'] 			= $this->Listados_pagos_model->table();

		$this->load->view($this->controller.'/index',$data);			
		
	}


}