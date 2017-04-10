<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Upload_model extends CI_MODEL
{
	public function __construct()
	{
		parent::__construct();
	}

	function aread($id_hijo)
	{			    

	    $query = $this->db->get_where('hijos', array('id_hijo' => $id_hijo));	    

	    if($query->num_rows() > 0)
	    {	      
	      return $query->row_array();
	    }
	    else
	    {
	      return false;
	    }

	}

	function read($id_hijo)
	{			    
	    $id_usuario = $this->session->userdata('id_usuario');
	   	$this->db->select('tutores.id_tutor' );
	   	$this->db->join('accesos','accesos.usuario=usuarios.usuario','left' );
	    $this->db->join('tutores','tutores.id_tutor=accesos.id_tutor','left' );
	    $query = $this->db->get_where('usuarios', array('tipo' => 'USUARIO', 'id_usuario' => $id_usuario));
	    $data = $query->row_array();

	    $query = $this->db->get_where('hijos', array('id_hijo' => $id_hijo, 'id_tutor' => $data['id_tutor']));	    

	    if($query->num_rows() > 0)
	    {	      
	      return $query->row_array();
	    }
	    else
	    {
	      return false;
	    }

	}


	function archivo($upload)
	{
	   	
		$id_hijo = $this->input->post('id_hijo');
		
	   	$data = array(
		   'foto' 		=> $upload['file_name'],
		);

		$this->db->where('id_hijo', $id_hijo);
		$this->db->update('hijos', $data); 

	    return true;

	} 

	function hijos_data()
	{
		$id_usuario = $this->session->userdata('id_usuario');
	   	$this->db->select('tutores.id_tutor' );
	   	$this->db->join('accesos','accesos.usuario=usuarios.usuario','left' );
	    $this->db->join('tutores','tutores.id_tutor=accesos.id_tutor','left' );
	    $query = $this->db->get_where('usuarios', array('tipo' => 'USUARIO', 'id_usuario' => $id_usuario));
	    $data = $query->row_array();

		$id_tutor 			= $data['id_tutor']; 
		$dni 				= $this->input->post('dni');
		$nombres 			= $this->input->post('nombres');
		$apellido_1 		= $this->input->post('apellido_1'); 
		$apellido_2 		= $this->input->post('apellido_2');
		#$date_array 		= explode('/',$this->input->post('fecha_nacimiento'));
		#$date_array 		= array_reverse($date_array);		
		#$fecha_nacimiento 	= date(implode('-', $date_array));	
		$fecha_nacimiento 	= date($this->input->post('fn_ano').'-'.$this->input->post('fn_mes').'-'.$this->input->post('fn_dia'));
		$sexo 				= $this->input->post('sexo');
		$colegio 			= $this->input->post('colegio'); 
		$centro_escolar 	= $this->input->post('centro_escolar'); 
		$afoto 				= $this->input->post('afoto'); 
	   	
	   	$data = array(
		   'id_tutor' 			=> $id_tutor,
		   'dni' 				=> $dni,
		   'nombres' 			=> $nombres,
		   'apellido_1' 		=> $apellido_1,
		   'apellido_2' 		=> $apellido_2,
		   'fecha_nacimiento' 	=> $fecha_nacimiento,
		   'sexo' 				=> $sexo,
		   'colegio' 			=> $colegio,
		   'centro_escolar' 	=> $centro_escolar,
		   'afoto' 				=> $afoto,
		   'foto' 				=> 'sinfoto.png',

		);

		return $data;
	}

	function hijos_data_update()
	{
		$id_usuario = $this->session->userdata('id_usuario');
	   	$this->db->select('tutores.id_tutor' );
	   	$this->db->join('accesos','accesos.usuario=usuarios.usuario','left' );
	    $this->db->join('tutores','tutores.id_tutor=accesos.id_tutor','left' );
	    $query = $this->db->get_where('usuarios', array('tipo' => 'USUARIO', 'id_usuario' => $id_usuario));
	    $data = $query->row_array();

		$id_tutor 			= $data['id_tutor']; 
		$dni 				= $this->input->post('dni');
		$nombres 			= $this->input->post('nombres');
		$apellido_1 		= $this->input->post('apellido_1'); 
		$apellido_2 		= $this->input->post('apellido_2');
		#$date_array 		= explode('/',$this->input->post('fecha_nacimiento'));
		#$date_array 		= array_reverse($date_array);		
		#$fecha_nacimiento 	= date(implode('-', $date_array));	
		$fecha_nacimiento 	= date($this->input->post('fn_ano').'-'.$this->input->post('fn_mes').'-'.$this->input->post('fn_dia'));
		$sexo 				= $this->input->post('sexo');
		$colegio 			= $this->input->post('colegio'); 
		$centro_escolar 	= $this->input->post('centro_escolar'); 
		$afoto 				= $this->input->post('afoto'); 
		$foto 				= $this->input->post('foto'); 
	   	
	   	$data = array(
		   'id_tutor' 			=> $id_tutor,
		   'dni' 				=> $dni,
		   'nombres' 			=> $nombres,
		   'apellido_1' 		=> $apellido_1,
		   'apellido_2' 		=> $apellido_2,
		   'fecha_nacimiento' 	=> $fecha_nacimiento,
		   'sexo' 				=> $sexo,
		   'colegio' 			=> $colegio,
		   'centro_escolar' 	=> $centro_escolar,
		   'afoto' 				=> $afoto,
		   'foto' 				=> $foto,

		);

		return $data;
	}

	function hijos_create()
	{
	   
	   	$data = $this->hijos_data();

		$this->db->insert('hijos', $data); 

		$id_hijo = $this->db->insert_id();
	    
	    #$this->hijos_familia();

	    return $id_hijo;

	} 

	function hijos_upload($id_hijo)
	{
		
		$upload = $this->upload->data();                                

		if(strlen($upload['file_name'])>0) {
			# tiene imagen

			$data = array(
			   'foto' 		=> $upload['file_name'],
			);

			$this->db->where('id_hijo', $id_hijo);
			$this->db->update('hijos', $data); 
		}

	    return true;

	} 

	function hijos_update()
	{
	    
	    $id_hijo = $this->input->post('id_hijo');

	    $data = $this->hijos_data_update();
	    
		$query = $this->db->get_where('hijos', array('id_hijo' => $id_hijo));	    

	    if($query->num_rows() > 0)
	    {	      	      	
	      	$this->db->where('id_hijo', $id_hijo);
			$this->db->update('hijos', $data); 
	      	#$this->hijos_familia();

	      	return $id_hijo;
	    }
	    else
	    {
	      	return false;
	    }
	}

	function hijos_read($id_hijo)
	{			    
	    $id_usuario = $this->session->userdata('id_usuario');
	   	$this->db->select('tutores.id_tutor' );
	   	$this->db->join('accesos','accesos.usuario=usuarios.usuario','left' );
	    $this->db->join('tutores','tutores.id_tutor=accesos.id_tutor','left' );
	    $query = $this->db->get_where('usuarios', array('tipo' => 'USUARIO', 'id_usuario' => $id_usuario));
	    $data = $query->row_array();

	    $query = $this->db->get_where('hijos', array('id_hijo' => $id_hijo, 'id_tutor' => $data['id_tutor']));	    

	    if($query->num_rows() > 0)
	    {	      
	      	return $query->row_array();
	    }
	    else
	    {
	      	return false;
	    }

	}

	function dni_check()
	{		
	    $dni = $this->input->post('dni');
	    
	    if (strlen($dni)>0) {
	    	$this->db->where('dni', $dni);
	    	$this->db->where('estatus', 'ACTIVO');
			$query = $this->db->get('hijos');
		    
		    if($query->num_rows() > 0)
		    {	      
		      	return true;
		    }
		    else
		    {
		      	return false;
		    }
	    }else{
	    	return false;
	    }

	}

	function dni_check2()
	{		
	    return true;
	    /*$dni = $this->input->post('dni');
	    $id_hijo = $this->input->post('id_hijo');
	    //echo 'saqui'.$dni;
	    if(strlen($dni)<=0) {
			return true;
		}/*else{
	    	$this->db->where('id_hijo !=', $id_hijo);
	    	$this->db->where('estatus', 'ACTIVO');
	    	$this->db->where('dni', $dni);
			$query = $this->db->get('hijos');
		    
		    if($query->num_rows() > 0)
		    {	      
		      	return true;
		    }
		    else
		    {
		      	return false;
		    }
	    }*/

	}

	function fn_check()
	{		
	    #$fecha_nacimiento = $this->input->post('fecha_nacimiento');
	    #$date_array = explode('/',$fecha_nacimiento);
	    #$fn = $date_array[2]; // 2005
	    $fn = $this->input->post('fn_ano');
	    $year = date('Y'); // 2016
	    $year_1 = $year - 4; // 2012
	    $year_2 = $year - 20; // 1996
	    
	    if ( ($year_1 >= $fn) and ($year_2 <= $fn) ) {
		    return true;
	    }else{
	    	return false;
	    }

	}

	function dni() {
		
		$dni = $this->input->post('dni'); 

		if(strlen($dni)<=0) {
			return true;
		}

		if(strlen($dni)<9) {
			return false;
		}
	 
		$dni = strtoupper($dni);
	 
		$letra = substr($dni, -1, 1);
		$numero = substr($dni, 0, 8);
	 
		// Si es un NIE hay que cambiar la primera letra por 0, 1 ó 2 dependiendo de si es X, Y o Z.
		$numero = str_replace(array('X', 'Y', 'Z'), array(0, 1, 2), $numero);	
	 
		$modulo = $numero % 23;
		$letras_validas = "TRWAGMYFPDXBNJZSQVHLCKE";
		$letra_correcta = substr($letras_validas, $modulo, 1);
	 
		if($letra_correcta!=$letra) {
			return false;
		}
		else {
			return true;
		}
	}

	/*
	function hijos_familia(){

		$id_usuario = $this->session->userdata('id_usuario');
	   	$this->db->select('tutores.id_tutor' );
	   	$this->db->join('accesos','accesos.usuario=usuarios.usuario','left' );
	    $this->db->join('tutores','tutores.id_tutor=accesos.id_tutor','left' );
	    $query = $this->db->get_where('usuarios', array('tipo' => 'USUARIO', 'id_usuario' => $id_usuario));
	    $data = $query->row_array();

		$id_tutor 			= $data['id_tutor']; 

		$this->db->group_by("hijos.id_tutor");
		$this->db->where('hijos.id_tutor', $id_tutor);
		$this->db->where('inscripciones.estatus', 'ACTIVO');
		$this->db->join('hijos','hijos.id_hijo=inscripciones.id_hijo','left');
		$query = $this->db->get('inscripciones');	    

	    if($query->num_rows() >= 3)
	    {	      	      	
	      	$data = array(
			   'familia' => 'SI',
			);
	      	$this->db->where('id_tutor', $id_tutor);
			$this->db->update('hijos', $data); 
	    }
	    else
	    {
	      	$data = array(
			   'familia' => 'NO',
			);
	      	$this->db->where('id_tutor', $id_tutor);
			$this->db->update('hijos', $data); 
	    }
	}*/

}