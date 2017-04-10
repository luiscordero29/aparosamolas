<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tutores extends CI_Controller {

	/**
	 * Controller: Panel
	 * Comments: Gestor de Tutores - Pagina Privada
	 *
	 * 
	 */

	public $controller = "tutores";

	public function __construct()
	{
		parent::__construct();		
		$this->load->driver('session');
		$this->load->model('Tutores_model','',TRUE); 
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
		$data['meta'] = 'APA ROSA MOLAS | Padres - Lista de Padres';
		$data['title'] = '<i class="fa fa-user"></i> Padres';
		$data['subtitle'] = 'Lista de Padres';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'			=> 'panel/index',
              	'<i class="fa fa-user"></i> Padres'				=> 'tutores/index',
              	'Lista de Padres'								=> '',              	
            );
				
		$table_limit = 30;
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
		$data['table'] 			= $this->Tutores_model->table($table_page*$table_limit,$table_limit,$data['search']);
		$data['table_rows'] 	= $this->Tutores_model->table_rows($data['search']);
		$data['table_page'] 	= $table_page;
		$data['table_limit'] 	= $table_limit;

		$this->load->view($this->controller.'/index',$data);			
		
	}

	public function view($id_usuario=false)
	{			

		# Data
		$data['meta'] = 'APA ROSA MOLAS | Padres - Lista de Padres';
		$data['title'] = '<i class="fa fa-user"></i> Padres';
		$data['subtitle'] = 'Ver Información';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-user"></i> Padres'					=> 'tutores/index',
              	'Ver Información'									=> '',              	
            );
			
		$data['row'] = $this->Tutores_model->read($id_usuario);

		
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

	public function update($id_usuario=false)
	{			

		// Control de Acceso
		if(!($this->session->userdata('tipo')=='ADMINISTRADOR'))
   		{     						
		    //If no session, redirect to login page
		    redirect('tutores');
		    
		}

		# Data
		$data['meta'] = 'APA ROSA MOLAS | Padres - Lista de Padres';
		$data['title'] = '<i class="fa fa-user"></i> Padres';
		$data['subtitle'] = 'Editar Información';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-user"></i> Padres'					=> 'tutores/index',
              	'Editar Información'								=> '',              	
            );
			
		$data['row'] = $this->Tutores_model->read($id_usuario);
		
		// Acceso	

		$this->form_validation->set_rules('usuario', 'Usuario', 'trim|required|min_length[6]|max_length[15]|alpha_numeric|callback_usuario_check');
		$this->form_validation->set_rules('activo', 'Activo', 'required');
		$this->form_validation->set_rules('correo', 'E-mail', 'trim|valid_email');				

		// Tutor
		$this->form_validation->set_rules('dni', 'DNI', 'trim|required|callback_dni_check|callback_vdni');
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
		
		$this->form_validation->set_message('usuario_check', 'El campo Usuario ingresado ya se encuentra ocupado.');
		$this->form_validation->set_message('dni_check', 'El campo DNI ingresado ya se encuentra ocupado.');
		$this->form_validation->set_message('cuenta', 'Numero de Cuenta Bancaria No Valido');
		$this->form_validation->set_message('vdni', 'DNI No Valido');

		$data['table_poblaciones'] = $this->Tutores_model->table_poblaciones();

		if($this->form_validation->run() == FALSE)
		{
			$data['row'] = $this->Tutores_model->read($id_usuario);
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
				
			$this->Tutores_model->update();
				
			$data['row'] = $this->Tutores_model->read($id_usuario);
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

	public function delete($id_usuario=false)
	{
		
		// Control de Acceso
		if(!($this->session->userdata('tipo')=='ADMINISTRADOR'))
   		{     						
		    //If no session, redirect to login page
		    redirect('tutores');
		    
		}

		# Data
		$data['meta'] = 'APA ROSA MOLAS | Padres - Lista de Padres';
		$data['title'] = '<i class="fa fa-user"></i> Padres';
		$data['subtitle'] = 'Eliminar Información';
		$data['breadcrumbs'] = 
			array(
              	'<i class="fa fa-dashboard"></i> Home'				=> 'panel/index',
              	'<i class="fa fa-user"></i> Padres'					=> 'tutores/index',
              	'Eliminar Información'								=> '',              	
            );


        if($id_usuario===FALSE)
		{
			$data['alert']['danger'] = 
				array( 
					'No exite registro ó No puede ser eliminado',				
				);

			$this->load->view($this->controller.'/message',$data);			
		}else{
			
			$data['alert'] = $this->Tutores_model->delete($id_usuario);
				
			$this->load->view($this->controller.'/message',$data);
		}			
			
	}

	public function usuario_check()
  	{
      	$check = $this->Tutores_model->usuario_check();
      	if($check)
      	{
           	return false;
      	}
      	else
      	{         
           	return true;
      	}
  	}

  	public function dni_check()
  	{
      	$check = $this->Tutores_model->dni_check();
      	if($check)
      	{
           	return false;
      	}
      	else
      	{         
           	return true;
      	}
  	}

  	public function cuenta()
	{
	    return $this->Tutores_model->cuenta();
	}

	public function vdni()
	{
	    return $this->Tutores_model->dni();
	}

}