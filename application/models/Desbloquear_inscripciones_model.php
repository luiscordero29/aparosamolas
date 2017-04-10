<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Desbloquear_inscripciones_model extends CI_MODEL
{
	public function __construct()
	{
		parent::__construct();
	}		

	function table($limit,$start,$search)
	{

	   	
	   	$sql = 
	    "SELECT 
	     inscripciones.* ,hijos.*, deportes.deporte, deportes.tipo, tutores.dni tdni,
	     tutores.apellidos tapellidos, tutores.nombres tnombres  
	     FROM inscripciones 
	     LEFT JOIN deportes ON deportes.id_deporte = inscripciones.id_deporte
	     LEFT JOIN hijos ON hijos.id_hijo = inscripciones.id_hijo
	     LEFT JOIN tutores ON tutores.id_tutor = hijos.id_tutor
	     WHERE (inscripciones.estatus = 'ACTIVO') AND (
	     	hijos.dni LIKE '%".$search."%' ESCAPE '!' 
	     	OR hijos.nombres LIKE '%".$search."%' ESCAPE '!'
	     	OR hijos.apellido_1 LIKE '%".$search."%' ESCAPE '!'
	     	OR hijos.apellido_2 LIKE '%".$search."%' ESCAPE '!'
	     	OR tutores.dni LIKE '%".$search."%' ESCAPE '!'
	     	OR tutores.nombres LIKE '%".$search."%' ESCAPE '!'
	     	OR tutores.apellidos LIKE '%".$search."%' ESCAPE '!'   
	     	OR deportes.deporte LIKE '%".$search."%' ESCAPE '!' 
	     	)
	     ORDER BY id_inscripcion DESC
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
	    "SELECT inscripciones.* ,hijos.*, deportes.deporte FROM inscripciones 
	     LEFT JOIN deportes ON deportes.id_deporte = inscripciones.id_deporte
	     LEFT JOIN hijos ON hijos.id_hijo = inscripciones.id_hijo
	     LEFT JOIN tutores ON tutores.id_tutor = hijos.id_tutor
	     WHERE (
	     	hijos.dni LIKE '%".$search."%' ESCAPE '!' 
	     	OR hijos.nombres LIKE '%".$search."%' ESCAPE '!'
	     	OR hijos.apellido_1 LIKE '%".$search."%' ESCAPE '!'
	     	OR hijos.apellido_2 LIKE '%".$search."%' ESCAPE '!'
	     	OR tutores.dni LIKE '%".$search."%' ESCAPE '!'
	     	OR tutores.nombres LIKE '%".$search."%' ESCAPE '!'
	     	OR tutores.apellidos LIKE '%".$search."%' ESCAPE '!'   
	     	OR deportes.deporte LIKE '%".$search."%' ESCAPE '!' 
	     	)
	     ORDER BY id_inscripcion DESC
	    ";

	    $query = $this->db->query($sql);

	    return $query->num_rows();

	}

	function read($id_inscripcion)
	{			    

		$this->db->select('inscripciones.* ,hijos.*, deportes.deporte, deportes.tipo, tutores.dni tdni, tutores.apellidos tapellidos, tutores.nombres tnombres');
		$this->db->join('hijos','hijos.id_hijo=inscripciones.id_hijo','left');
		$this->db->join('tutores','tutores.id_tutor=hijos.id_tutor','left');
		$this->db->join('deportes','deportes.id_deporte=inscripciones.id_deporte','left');
		$this->db->where('inscripciones.id_inscripcion',$id_inscripcion);
	    $query = $this->db->get('inscripciones');	    

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
	    
	    $id_inscripcion 	= $this->input->post('id_inscripcion');
	    $modificar 			= $this->input->post('modificar');

	    $data = array(
		   'modificar' 			=> $modificar,
		);
	    
		$query = $this->db->get_where('inscripciones', array('id_inscripcion' => $id_inscripcion));	    

	    if($query->num_rows() > 0)
	    {	      	      	
	      	$this->db->where('id_inscripcion', $id_inscripcion);
			$this->db->update('inscripciones', $data); 
	      	return true;
	    }
	    else
	    {
	      	return false;
	    }
	} 

}