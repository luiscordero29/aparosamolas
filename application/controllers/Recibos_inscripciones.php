<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Recibos_inscripciones extends CI_Controller {

	/**
	 * Controller: Panel
	 * Comments: Gestor de Recibos_inscripciones - Pagina Privada
	 *
	 * 
	 */

	public $controller = "recibos_inscripciones";

	public function __construct()
	{
		parent::__construct();		
		$this->load->driver('session');
		$this->load->model('Recibos_inscripciones_model','',TRUE);
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
		$data['meta'] = 'APA ROSA MOLAS | Gestión de Recibos - Lista de Registros';
		$data['title'] = '<i class="fa fa-paper-plane"></i> Gestión de Recibos';
		$data['subtitle'] = 'Lista de Registros';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'						=> 'panel/index',
              	'<i class="fa fa-paper-plane"></i> Gestión de Recibos'	=> 'recibos_inscripciones/index',
              	'Lista de Registros'										=> '',              	
            );
				
		$data['tutor'] 		= trim($this->input->post('tutor'));
		$data['hijo'] 		= trim($this->input->post('hijo'));
		$data['deporte'] 	= trim($this->input->post('deporte'));
		$data['estado'] 	= trim($this->input->post('estado'));
		$data['pagado'] 	= trim($this->input->post('pagado'));
		
		$data['table_deportes'] = $this->Recibos_inscripciones_model->table_deportes();

		$data['controller'] 	= $this->controller;				
		$data['table'] 			= $this->Recibos_inscripciones_model->table();

		$this->load->view($this->controller.'/index',$data);			
		
	}

	public function update($id_inscripcion=false)
	{			

		// Control de Acceso
		if(!($this->session->userdata('tipo')=='ADMINISTRADOR'))
   		{     						
		    //If no session, redirect to login page
		    redirect('recibos_inscripciones');
		    
		}

		# Data
		$data['meta'] = 'APA ROSA MOLAS | Recibos_inscripciones - Editar Información';
		$data['title'] = '<i class="fa fa-gears"></i> Gestión de Recibos';
		$data['subtitle'] = 'Editar Información';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'						=> 'panel/index',
              	'<i class="fa fa-paper-plane"></i> Gestión de Recibos'	=> 'recibos_inscripciones/index',
              	'Editar Información'										=> '',              	
            );
				
		$this->form_validation->set_rules('estado', 'Estado del Recibo', 'trim|required');
		$this->form_validation->set_rules('porcentajes', 'Porcentajes', 'trim|required');

		if($this->form_validation->run() == FALSE)
		{
			$data['row'] = $this->Recibos_inscripciones_model->read($id_inscripcion);
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
				
			$this->Recibos_inscripciones_model->update();
				
			$data['row'] = $this->Recibos_inscripciones_model->read($id_inscripcion);
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

	public function cuaderno19()
	{
		// Control de Acceso
		if(!($this->session->userdata('tipo')=='ADMINISTRADOR'))
   		{     						
		    //If no session, redirect to login page
		    redirect('recibos_inscripciones');
		    
		}

		# Data
		$data['meta'] = 'APA ROSA MOLAS | Recibos_inscripciones - Generar Cuaderno 19';
		$data['title'] = '<i class="fa fa-gears"></i> Gestión de Recibos';
		$data['subtitle'] = 'Generar Cuaderno 19';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'						=> 'panel/index',
              	'<i class="fa fa-paper-plane"></i> Gestión de Recibos'	=> 'recibos_inscripciones/index',
              	'Generar Cuaderno 19'										=> '',              	
            );

		$this->form_validation->set_rules('importe', 'Importe', 'trim|required');
		$this->form_validation->set_rules('descargar', 'Descargar', 'trim|required');
		$this->form_validation->set_rules('id_inscripcion[]', '', 'required|callback_validar_items|callback_importe',array('required' => 'Debe Selecionar al menos un Elemento.'));
		$this->form_validation->set_message('validar_items', 'Todos los recibos seleccionados deben tener el mismo porcentaje pagado.');
		$this->form_validation->set_message('importe', 'El porcentaje seleccionado es superior al porcentaje pendiente de pago.');

		if($this->form_validation->run() == FALSE)
		{
				
			$this->load->view($this->controller.'/message',$data);		

		}else{

			$file = $this->Recibos_inscripciones_model->cuaderno19();
				
			$data['alert']['success'] = 
			array( 
				'Generando Cuaderno 19 - <a class="btn btn-info" download target="_get" href="'.base_url($file).'"><i class="fa fa-download" aria-hidden="true"></i> Descargar </a>',				
			);

			$this->load->view($this->controller.'/message',$data);
		}	
	}

	public function validar_items(){
		return $this->Recibos_inscripciones_model->validar_items();
	}

	public function importe(){
		return $this->Recibos_inscripciones_model->importe();
	}

}