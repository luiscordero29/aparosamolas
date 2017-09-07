<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller {

	/**
	 * Controller: Dashboard
	 * Comments: Dashboard de Control - Pagina Privada
	 *
	 * @version 1.0, 11/01/2013
	 * @since   Sublime Text 3059
	 */
	public $controller = "dashboard";

	public function __construct()
	{
		parent::__construct();		
		$this->load->driver('session');
		$this->load->model('Dashboard_model','',TRUE); 
		// Control Sessión
		if(!$this->session->has_userdata('id_usuario'))
   		{     						
		    //If no session, redirect to login page
		    redirect('account/logout');
	
		}
	}

	public function index()
	{
		# Data
		$data['meta'] = 'APA ROSA MOLAS | Mis Datos - Información de la Cuenta';
		$data['title'] = '<i class="fa fa-dashboard"></i> Home';
		$data['subtitle'] = 'Panel de Control';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'			=> 'panel/index',
              	'Panel de Control'								=> '',              	
            );

        $data['hijos'] = $this->Dashboard_model->hijos();
        $data['tutores'] = $this->Dashboard_model->tutores();
        $data['inscripciones'] = $this->Dashboard_model->inscripciones();
        $data['deportes'] = $this->Dashboard_model->deportes();

        $this->load->view($this->controller.'/index',$data);
	}

	public function inscripciones()
	{
		# Data
		$data['meta'] = 'APA ROSA MOLAS | Mis Datos - Editar Información';
		$data['title'] = '<i class="fa fa-lock"></i> Cerrar Inpscripciones';
		$data['subtitle'] = 'Cerrar Inpscripciones';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'			=> 'panel/index',
              	'Cerrar Inpscripciones'							=> '',              	
            );
	    
	    
	    $this->form_validation->set_rules('estatus', 'Estatus', 'trim|required');
			
		if($this->form_validation->run() == FALSE)
		{
			$data['row'] = $this->Dashboard_model->inscripciones_read();
			$this->load->view($this->controller.'/inscripciones',$data);		

		}else{
			$this->Dashboard_model->inscripciones_update();
			$data['alert']['success'] = 
				array( 
					'Guardado Correctamente',				
				);
			$data['row'] = $this->Dashboard_model->inscripciones_read();    
			$this->load->view($this->controller.'/inscripciones',$data);
		}	

	}

	public function descuentos()
	{
		# Data
		$data['meta'] = 'APA ROSA MOLAS | Validar descuentos';
		$data['title'] = '<i class="fa fa-check"></i> Validar descuentos';
		$data['subtitle'] = 'Validar descuentos';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'			=> 'panel/index',
              	'Validar descuentos'							=> '',              	
            );
	        
	   	$this->Dashboard_model->descuentos();
		$data['alert']['success'] = 
			array( 
				'Procesado Exitosamente',				
			);   
		$this->load->view($this->controller.'/descuentos',$data);

	}

}