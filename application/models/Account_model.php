<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Account_model extends CI_MODEL
{
	public function __construct()
	{
		parent::__construct();
	}

	function read()
	{			    
	    $id_usuario = $this->session->userdata('id_usuario');

	    $this->db->join('accesos','accesos.usuario=usuarios.usuario','left' );
	    $this->db->join('tutores','tutores.id_tutor=accesos.id_tutor','left' );
	    $this->db->join('poblaciones','poblaciones.id_poblacion=tutores.id_poblacion','left' );
	    $query = $this->db->get_where('usuarios', array('id_usuario' => $id_usuario));	    

	    if($query->num_rows() > 0)
	    {	      
	      	return $query->row_array();
	    }
	    else
	    {
	      	return false;
	    }
	}

	function update()
	{
	    if ($this->session->userdata('tipo') == 'ADMINISTRADOR' or $this->session->userdata('tipo') == 'SUPERVISOR') {
	    	# TIPO ADMINISTRADOR
	    	$id_usuario = $this->input->post('id_usuario');
			$correo 	= $this->input->post('correo');

			$data = array(
	               'correo' 	=> $correo,
	            );

			$this->db->where('id_usuario', $id_usuario);
			$this->db->update('usuarios', $data); 	

	    }else{

	    	$id_usuario 		= $this->input->post('id_usuario');
			$correo 	= $this->input->post('email_principal');

			$data = array(
	            'correo' 	=> $correo,
	        );

			$this->db->where('id_usuario', $id_usuario);
			$this->db->update('usuarios', $data); 	

	    	$id_tutor = $this->input->post('id_tutor');
 			$familia 				= $this->input->post('familia'); 
 			$carnet 				= $this->input->post('carnet'); 
	 		$direccion 				= $this->input->post('direccion'); 
	 		$id_poblacion 			= $this->input->post('id_poblacion'); 
	 		$codigo_postal 			= $this->input->post('codigo_postal'); 
	 		$telefono_movil 		= $this->input->post('telefono_movil'); 
	 		$telefono_fijo 			= $this->input->post('telefono_fijo'); 
	 		$email_principal 		= $this->input->post('email_principal'); 
	 		$email_secundario 		= $this->input->post('email_secundario'); 
	 		$pareja_nombres 		= $this->input->post('pareja_nombres'); 
	 		$pareja_apellidos 		= $this->input->post('pareja_apellidos'); 
	 		$pareja_movil 			= $this->input->post('pareja_movil'); 
	 		$cuenta_bancaria 		= $this->input->post('cuenta_bancaria'); 

	 		$data = array(
		 		'familia' 				=> $familia, 
		   		'carnet' 				=> $carnet, 
		   		'direccion' 			=> $direccion, 
		 		'id_poblacion' 			=> $id_poblacion, 
		 		'codigo_postal' 		=> $codigo_postal, 
		 		'telefono_movil' 		=> $telefono_movil, 
		 		'telefono_fijo' 		=> $telefono_fijo, 
		 		'email_principal' 		=> $email_principal, 
		 		'email_secundario' 		=> $email_secundario, 
		 		'pareja_nombres' 		=> $pareja_nombres, 
		 		'pareja_apellidos' 		=> $pareja_apellidos, 
		 		'pareja_movil' 			=> $pareja_movil, 
		 		'cuenta_bancaria' 		=> $cuenta_bancaria, 
			);
		    
		    $this->db->where('id_tutor', $id_tutor);
			$this->db->update('tutores', $data); 
			
	    }
	   

		return true;
	} 

	function password()
	{
	    $id_usuario 	= $this->input->post('id_usuario');
	    $clave 			= $this->input->post('pass');

	    $data = array(
			'clave' 		=> md5($clave),  
		);
	    
	    $query = $this->db->get_where('usuarios', array('id_usuario' => $id_usuario));

	    if($query->num_rows() > 0)
	    {	      
	      	$this->db->where('id_usuario', $id_usuario);
			$this->db->update('usuarios', $data); 
	      	return true;
	    }
	    else
	    {
	      	return false;
	    }
	}

	public function table_poblaciones()
 	{
	    $this->db->order_by('poblacion', 'ASC');  
	    $query = $this->db->get('poblaciones');
	    
	    if($query->num_rows() > 0)
	    {
	      	return $query->result_array();
	    }
	    else
	    {
	      	return false;
	    }
 	}

}