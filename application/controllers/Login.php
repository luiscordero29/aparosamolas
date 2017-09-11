<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct()
  	{
    	parent::__construct();  
    	$this->load->driver('session');   
    	$this->load->model('Login_model'); 	
  	}

  	public function none()
	{
		$this->load->view('login/none');
	}

	public function index()
	{
		// rules
		$this->form_validation->set_rules('username', 'Usuario', 'required');
		$this->form_validation->set_rules('password', 'Contraseña', 'required|callback_session');
		// message
		$this->form_validation->set_message('session', '1.- El usuario no existe <br />2.- Contraseña invalidad <br />3.- No tiene acceso temporalmente');
		// views
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('login/index');
		}
		else
		{			
	        redirect('dashboard', 'refresh');	     
		}
	}

	public function register()
	{
		// rules
		$this->form_validation->set_rules('dni', 'DNI', 'trim|required|is_unique[tutores.dni]|callback_vdni',
			 	array('is_unique' => 'El DNI introducido ya está registrado')
			);
		$this->form_validation->set_rules('apellidos', 'Apellidos', 'trim|required');
		$this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');
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
		$this->form_validation->set_rules('cuenta_bancaria', 'Número de cuenta bancaria', 'trim|required|callback_cuenta');
		$this->form_validation->set_rules('password', 'Contraseña', 'trim|required');
		
		// message
		# validar dni - cuenta bancaria  - validar si existe un usuarios con un dni
		$this->form_validation->set_message('cuenta', 'Numero de Cuenta Bancaria No Valido');
		$this->form_validation->set_message('vdni', 'DNI No Valido');
		
		$data['table_poblaciones'] = $this->Login_model->table_poblaciones();
		// views
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('login/register',$data);
		}
		else
		{			
	        $data['alert']['success'] = 
				array( 
					'Registrado Correctamente',				
				);
			$this->Login_model->register();
	        $this->load->view('login/message',$data);     
		}
	}

	public function renovate()
	{
		// rules
		$this->form_validation->set_rules('email_principal', 'Email', 'trim|required|valid_email|callback_vrenovate');
		
		$this->form_validation->set_message('vrenovate', 'Email No Existe');

		// views
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('login/renovate');
		}
		else
		{			
	        $data['alert']['success'] = 
				array( 
					'Cuenta Restaurada Correctamente',				
				);
			$this->Login_model->renovate();
	        $this->load->view('login/message',$data);     
		}
	}

	public function session()
	{
	    $result = $this->Login_model->session();
	    if($result)
	    {
	      	foreach($result as $row)
	      	{           
		        $sess_array = array(
		        	'id_usuario' 	=> $row->id_usuario,
		        	'usuario' 		=> $row->usuario,
		          	'tipo' 			=> $row->tipo,		          	
		        );
	        	$this->session->set_userdata($sess_array);
	      	}
	      	return true;
	    }else{
	      	return false;
	    }
	}

	public function cuenta()
	{
	    return $this->Login_model->cuenta();
	}

	public function vdni()
	{
	    return $this->Login_model->dni();
	}

	public function vrenovate()
	{
	    return $this->Login_model->vrenovate();
	}

}