<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	/**
	 * Account.
	 *
	 **/
	
	public $controller = "account";

	public function __construct()
	{
		parent::__construct();		
		$this->load->driver('session'); 
		$this->load->model('Account_model','',TRUE);
		$this->load->model('Dashboard_model','',TRUE); 
		// Control Sessión
		if(!$this->session->has_userdata('id_usuario'))
   		{     						
		    //If no session, redirect to login page
		    redirect('login');
	
		}
	}

	public function index()
	{
		# Data
		$data['meta'] = 'APA ROSA MOLAS | Mis Datos - Información de la Cuenta';
		$data['title'] = '<i class="fa fa-user"></i> Mis Datos';
		$data['subtitle'] = 'Información de la Cuenta';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'			=> 'panel/index',
              	'<i class="fa fa-user"></i> Mis Datos'			=> 'account/index',
              	'Información de la Cuenta'						=> '',              	
            );

		$data['row'] = $this->Account_model->read();
		$this->load->view($this->controller.'/index',$data);

	}

	public function profile()
	{
		
		# Data
		$data['meta'] = 'APA ROSA MOLAS | Mis Datos - Editar Información';
		$data['title'] = '<i class="fa fa-user"></i> Mis Datos';
		$data['subtitle'] = 'Editar Información';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'			=> 'panel/index',
              	'<i class="fa fa-user"></i> Mis Datos'			=> 'account/index',
              	'Editar Información'							=> '',              	
            );
	    
	    if ($this->session->userdata('tipo') == 'ADMINISTRADOR') {
	    	# TIPO ADMINISTRADOR
			$this->form_validation->set_rules('correo', 'Correo', 'trim|required|valid_email');		
	    }else{
	    	$this->form_validation->set_rules('direccion', 'Dirección', 'trim|required');
			$this->form_validation->set_rules('id_poblacion', 'Población', 'trim|required');
			$this->form_validation->set_rules('codigo_postal', 'Código postal', 'trim|required');
			$this->form_validation->set_rules('telefono_fijo', 'Teléfono fijo (opcional)', 'trim');
			$this->form_validation->set_rules('telefono_movil', 'Teléfono móvil', 'trim|required');
			$this->form_validation->set_rules('email_principal', 'Email 1', 'trim|required|valid_email');
			$this->form_validation->set_rules('email_secundario', 'Email 2 (opcional)', 'trim|valid_email');
			$this->form_validation->set_rules('pareja_nombres', 'Nombres pareja (opcional)', 'trim');
			$this->form_validation->set_rules('pareja_apellidos', 'Apellidos pareja (opcional)', 'trim');
			$this->form_validation->set_rules('pareja_movil', 'Teléfono móvil pareja (opcional)', 'trim');
			$this->form_validation->set_rules('cuenta_bancaria', 'Número de cuenta bancaria', 'trim|required');

			$data['table_poblaciones'] = $this->Account_model->table_poblaciones();
	    }
		
		if($this->form_validation->run() == FALSE)
		{
			$data['row'] = $this->Account_model->read();
			$this->load->view($this->controller.'/profile',$data);		

		}else{
			$this->Account_model->update();
			$data['alert']['success'] = 
				array( 
					'Guardado Correctamente',				
				);
			$data['row'] = $this->Account_model->read();    
			$this->load->view($this->controller.'/profile',$data);
		}	

	}

	public function password()
	{
		
		# Data
		$data['meta'] = 'APA ROSA MOLAS | Mis Datos - Cambiar Contraseña';
		$data['title'] = '<i class="fa fa-user"></i> Mis Datos';
		$data['subtitle'] = 'Cambiar Contraseña';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'			=> 'panel/index',
              	'<i class="fa fa-user"></i> Mis Datos'			=> 'account/index',
              	'Cambiar Contraseña'							=> '',              	
            );
	    
		$this->form_validation->set_rules('pass', 'Contraseña', 'trim|required');
		$this->form_validation->set_rules('confirmar', 'Confirmar Contraseña', 'trim|required|matches[pass]');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['row'] = $this->Account_model->read();
			$this->load->view($this->controller.'/password',$data);		

		}else{
			$this->Account_model->read();
			$data['alert']['success'] = 
				array( 
					'Guardado Correctamente',				
				);
			$data['row'] = $this->Account_model->password();    
			$this->load->view($this->controller.'/password',$data);
		}	

	}

	public function logout()
 	{

		$sess_array = array(
		    'id_usuario' 	=> '',
		    'usuario' 		=> '',
		    'tipo' 			=> '',		          	
		);

		$this->session->unset_userdata($sess_array);
	   	$this->session->sess_destroy();
	   	
	   	redirect('login');
 	}

}
