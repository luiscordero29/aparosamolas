<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Hijos_model extends CI_MODEL
{
	public function __construct()
	{
		parent::__construct();
	}		

	function table($limit,$start,$search)
	{

	   	$id_usuario = $this->session->userdata('id_usuario');
	   	$this->db->select('tutores.id_tutor' );
	   	$this->db->join('accesos','accesos.usuario=usuarios.usuario','left' );
	    $this->db->join('tutores','tutores.id_tutor=accesos.id_tutor','left' );
	    $query = $this->db->get_where('usuarios', array('tipo' => 'USUARIO', 'id_usuario' => $id_usuario));
	    $data = $query->row_array();

	   	$sql = 
	    "SELECT * FROM hijos 
	     WHERE (estatus = 'ACTIVO') AND (id_tutor = ".$data['id_tutor'].")
	     AND (
	     	nombres LIKE '%".$search."%' ESCAPE '!' 
	     	OR apellido_1 LIKE '%".$search."%' ESCAPE '!'
	     	OR apellido_2 LIKE '%".$search."%'  
	     	)
	     ORDER BY id_hijo DESC
	     LIMIT  ".$limit.",".$start."
	    ";

	    $query = $this->db->query($sql);

	    if($query->num_rows() > 0)
	    {
	      	return $query->result_array();
	    }
	    else
	    {
	      	return false;
	    }
	}

	function table_rows($search)
	{
	    
	    $id_usuario = $this->session->userdata('id_usuario');
	   	$this->db->select('tutores.id_tutor' );
	   	$this->db->join('accesos','accesos.usuario=usuarios.usuario','left' );
	    $this->db->join('tutores','tutores.id_tutor=accesos.id_tutor','left' );
	    $query = $this->db->get_where('usuarios', array('tipo' => 'USUARIO', 'id_usuario' => $id_usuario));
	    $data = $query->row_array();

	   	$sql = 
	    "SELECT * FROM hijos 
	     WHERE (estatus = 'ACTIVO') AND (id_tutor = ".$data['id_tutor'].")
	     AND (
	     	nombres LIKE '%".$search."%' ESCAPE '!' 
	     	OR apellido_1 LIKE '%".$search."%' ESCAPE '!'
	     	OR apellido_2 LIKE '%".$search."%'  
	     	)
	     ORDER BY id_hijo DESC
	    ";

	    $query = $this->db->query($sql);

	    return $query->num_rows();

	}

	/*
	function data()
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
		);

		return $data;
	}

	function create($upload)
	{
	   
	   	$data = $this->data();

		$this->db->insert('hijos', $data); 


		if(!$_FILES['userfile']['error']) {
			# tiene imagen
			$id_hijo = $this->db->insert_id();
			$path = FCPATH.'assets/uploads/';
			$new_file_name = strtolower($_FILES['userfile']['tmp_name']);
			move_uploaded_file($_FILES['userfile']['tmp_name'], $path.$new_file_name);

			$data = array(
			   'foto' 		=> $new_file_name,
			);

			$this->db->where('id_hijo', $id_hijo);
			$this->db->update('hijos', $data); 
		}
	    
	    $this->familia();

	    return true;

	} */

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

	/*function update()
	{
	    
	    $id_hijo = $this->input->post('id_hijo');

	    $data = $this->data();
	    
		$query = $this->db->get_where('hijos', array('id_hijo' => $id_hijo));	    

	    if($query->num_rows() > 0)
	    {	      	      	
	      	$this->db->where('id_hijo', $id_hijo);
			$this->db->update('hijos', $data); 
	      	$this->familia();
	      	return true;
	    }
	    else
	    {
	      	return false;
	    }
	} */

	function delete($id_hijo)
	{
	   	
	   	$id_usuario = $this->session->userdata('id_usuario');

	   	$this->db->select('tutores.id_tutor');
	   	$this->db->join('accesos','accesos.usuario=usuarios.usuario','left' );
	    $this->db->join('tutores','tutores.id_tutor=accesos.id_tutor','left' );
	    $this->db->join('poblaciones','poblaciones.id_poblacion=tutores.id_poblacion','left' );
	    $query = $this->db->get_where('usuarios', array('id_usuario' => $id_usuario));
	    $data = $query->row_array();
	    $id_tutor = $data['id_tutor'];

	   	$query = $this->db->get_where('hijos', array('id_hijo' => $id_hijo, 'id_tutor' => $id_tutor));	
	   	
	    // eliminar
	    if($query->num_rows() > 0)
	    {	      
	  		
	    	# verificar si esta inscritp 
	    	$query = $this->db->get_where('inscripciones', array('id_hijo' => $id_hijo));	
	    	if($query->num_rows() > 0)
	    	{
	    		$data['danger'] = 
					array( 
						'Este deportista esta inscrito y no puede ser eliminado.',				
					);

	    	}else{
		  		# eliminar registro
		    	$data = array(
				   'estatus'	=> 'INACTIVO',
				);
		      	$this->db->where('id_hijo', $id_hijo);
				$this->db->update('hijos', $data); 

		      	$data['success'] = 
					array( 
						'Registro Eliminado Exitosamente',				
					);
	    	}
	    }
	    else
	    {
	      	$data['danger'] = 
				array( 
					'No exite registro ó No puede ser eliminado',				
				);
	    }
	    
	    return $data;
	}	

	/*function dni_check()
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
	    $dni = $this->input->post('dni');
	    $id_hijo = $this->input->post('id_hijo');
	    
	    if (strlen($dni)>0) {
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
	    }else{
	    	return false;
	    }

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

	function familia(){

		$id_usuario = $this->session->userdata('id_usuario');
	   	$this->db->select('tutores.id_tutor' );
	   	$this->db->join('accesos','accesos.usuario=usuarios.usuario','left' );
	    $this->db->join('tutores','tutores.id_tutor=accesos.id_tutor','left' );
	    $query = $this->db->get_where('usuarios', array('tipo' => 'USUARIO', 'id_usuario' => $id_usuario));
	    $data = $query->row_array();

		$id_tutor 			= $data['id_tutor']; 

		$query = $this->db->get_where('hijos', array('id_tutor' => $id_tutor));	    

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