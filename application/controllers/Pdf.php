<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pdf extends CI_Controller {
		
	public $controller = "pdf";

	public function __construct()
	{
		parent::__construct();	
		
		$this->load->driver('session');
		$this->load->model('Pdf_model','',TRUE);
		$this->load->helper('pdf_helper');

		// Control de Sessión
		if($this->session->has_userdata('id_usuario'))
   		{     						
			if(!(($this->session->userdata('tipo') === 'ADMINISTRADOR') or ($this->session->userdata('tipo') === 'SUPERVISOR')))
			{
				redirect('account/logout');
			}
		}
		else
		{
		    redirect('account/logout');
		}
		
	}

	public function index()
	{
		redirect('dashboard/index');		
	}	

	public function pagos($id_inscripcion)
	{
					    
		if($id_inscripcion===FALSE)
		{
			redirect('dashboard/index');				
		}

		$data['row'] = $this->Pdf_model->pagos($id_inscripcion);
		if(empty($data['row']))
		{
			redirect('dashboard/index');
		}

		$this->load->view('pdf/pagos',$data);  		    		    
		    
	}

	public function deportista($id_inscripcion)
	{
					    
		if($id_inscripcion===FALSE)
		{
			redirect('dashboard/index');				
		}

		$data['row'] = $this->Pdf_model->deportista($id_inscripcion);
		if(empty($data['row']))
		{
			redirect('dashboard/index');
		}

		$this->load->view('pdf/deportista',$data);  		    		    
		    
	}

	public function listado($id_inscripcion)
	{
					    
		if($id_inscripcion===FALSE)
		{
			redirect('dashboard/index');				
		}

		$data['row'] = $this->Pdf_model->listado($id_inscripcion);
		if(empty($data['row']))
		{
			redirect('dashboard/index');
		}

		$this->load->view('pdf/listado',$data);  		    		    
		    
	}

	public function listados($tutor = null, $hijo = null, $deporte = null, $estado = null, $pagado = null, $orden_campo = null, $orden_tipo = null)
	{
					    
		$data['rows'] = $this->Pdf_model->listados($tutor, $hijo, $deporte, $estado, $pagado, $orden_campo, $orden_tipo);
		
		$this->load->view('pdf/listados',$data);  		    		    
		    
	}

	public function listados_deportes($deporte = null, $apellidos = null, $fechas = null, $sexo = null, $afoto = null, $orden_campo = null, $orden_tipo = null)
	{
					    
		$data['rows'] = $this->Pdf_model->listados_deportes($deporte, $apellidos, $fechas, $sexo, $afoto, $orden_campo, $orden_tipo);
		
		$this->load->view('pdf/listados_deportes',$data);  		    		    
		    
	}

	public function listados_pagos($tutor_apellidos = null, $tutor_nombres = null, $hijo_apellidos = null, $hijo_nombres = null, $deporte = null, $porcentajes = null, $estado = null, $orden_campo = null, $orden_tipo = null)
	{
					    
		$data['rows'] = $this->Pdf_model->listados_pagos($tutor_apellidos, $tutor_nombres, $hijo_apellidos, $hijo_nombres, $deporte, $porcentajes, $estado, $orden_campo, $orden_tipo);
		
		$this->load->view('pdf/listados_pagos',$data);  		    		    
		    
	}
	
}