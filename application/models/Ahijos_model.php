<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Ahijos_model extends CI_MODEL
{
	public function __construct()
	{
		parent::__construct();
	}		

	function table($limit,$start,$search)
	{

	   	$sql = 
	    "SELECT 
	     tutores.dni tdni, tutores.apellidos tapellidos,tutores.nombres tnombres, hijos.* 
	     FROM hijos 
	     LEFT JOIN tutores ON tutores.id_tutor=hijos.id_tutor
	     WHERE 
	     (
	     	tutores.dni LIKE '%".$search."%' ESCAPE '!' 
	     	OR tutores.nombres LIKE '%".$search."%' ESCAPE '!' 
	     	OR tutores.apellidos LIKE '%".$search."%' ESCAPE '!' 
	     	OR hijos.nombres LIKE '%".$search."%' ESCAPE '!' 
	     	OR hijos.apellido_1 LIKE '%".$search."%' ESCAPE '!'
	     	OR hijos.apellido_2 LIKE '%".$search."%'  
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
	    
	   	$sql = 
	    "SELECT 
	     tutores.dni tdni, tutores.apellidos tapellidos,tutores.nombres tnombres, hijos.* 
	     FROM hijos 
	     LEFT JOIN tutores ON tutores.id_tutor=hijos.id_tutor
	     WHERE 
	     (
	     	tutores.dni LIKE '%".$search."%' ESCAPE '!' 
	     	OR tutores.nombres LIKE '%".$search."%' ESCAPE '!' 
	     	OR tutores.apellidos LIKE '%".$search."%' ESCAPE '!' 
	     	OR hijos.nombres LIKE '%".$search."%' ESCAPE '!' 
	     	OR hijos.apellido_1 LIKE '%".$search."%' ESCAPE '!'
	     	OR hijos.apellido_2 LIKE '%".$search."%'  
	     	)
	     ORDER BY id_hijo DESC
	    ";

	    $query = $this->db->query($sql);

	    return $query->num_rows();

	}

	function data()
	{
		
		$dni 				= $this->input->post('dni');
		$nombres 			= $this->input->post('nombres');
		$apellido_1 		= $this->input->post('apellido_1'); 
		$apellido_2 		= $this->input->post('apellido_2');
		$date_array 		= explode('/',$this->input->post('fecha_nacimiento'));
		$date_array 		= array_reverse($date_array);		
		$fecha_nacimiento 	= date(implode('-', $date_array));	
		$sexo 				= $this->input->post('sexo');
		$colegio 			= $this->input->post('colegio'); 
		$centro_escolar 	= $this->input->post('centro_escolar'); 
		$afoto 				= $this->input->post('afoto'); 
	   	
	   	$data = array(
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

	function read($id_hijo)
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

	function update()
	{
	    
	    $id_hijo = $this->input->post('id_hijo');

	    $data = $this->data();
	    
		$query = $this->db->get_where('hijos', array('id_hijo' => $id_hijo));	    

	    if($query->num_rows() > 0)
	    {	      	      	
	      	$this->db->where('id_hijo', $id_hijo);
			$this->db->update('hijos', $data); 
	      	return true;
	    }
	    else
	    {
	      	return false;
	    }
	} 

	function delete($id_hijo)
	{
	   
	   	$query = $this->db->get_where('hijos', array('id_hijo' => $id_hijo));	
	   	
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

		      	$this->db->where('id_hijo', $id_hijo);
				$this->db->delete('hijos');
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

	function dni_check()
	{		
	    $dni = $this->input->post('dni');
	    
	    if (strlen($dni)>0) {
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

	function dni_check2()
	{		
	    $dni = $this->input->post('dni');
	    $id_hijo = $this->input->post('id_hijo');
	    
	    if (strlen($dni)>0) {
	    	$this->db->where('id_hijo !=', $id_hijo);
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
	    $fecha_nacimiento = $this->input->post('fecha_nacimiento');
	    $date_array = explode('/',$fecha_nacimiento);
	    $fn = $date_array[2]; // 2005
	    $year = date('Y'); // 2016
	    $year_1 = $year - 4; // 2012
	    $year_2 = $year - 20; // 1996
	    
	    if ( ($year_1 >= $fn) and ($year_2 <= $fn) ) {
		    return true;
	    }else{
	    	return false;
	    }

	}

}