<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Listados_model extends CI_MODEL
{
	public function __construct()
	{
		parent::__construct();
	}		

	function table()
	{

	   	
	   	$sql = 
	    "SELECT 
	     inscripciones.* ,hijos.*, deportes.deporte, deportes.tipo, tutores.dni tdni,
	     tutores.apellidos tapellidos, tutores.nombres tnombres  
	     FROM inscripciones 
	     LEFT JOIN deportes ON deportes.id_deporte = inscripciones.id_deporte
	     LEFT JOIN hijos ON hijos.id_hijo = inscripciones.id_hijo
	     LEFT JOIN tutores ON tutores.id_tutor = hijos.id_tutor
	     WHERE (inscripciones.estatus = 'ACTIVO') AND ( inscripciones.id_inscripcion LIKE '%%' ESCAPE '!') ";

	    $tutor 		= trim($this->input->post('tutor'));
		$hijo 		= trim($this->input->post('hijo'));
		$deporte 	= trim($this->input->post('deporte'));
		$estado 	= trim($this->input->post('estado'));
		$pagado 	= trim($this->input->post('pagado'));
		$orden_campo 	= trim($this->input->post('orden_campo'));
		$orden_tipo 	= trim($this->input->post('orden_tipo'));

		if (!empty($tutor)) {
			# code...
			$sql .=  " AND (
			tutores.dni LIKE '%".$tutor."%' ESCAPE '!'
	     	OR tutores.nombres LIKE '%".$tutor."%' ESCAPE '!'
	     	OR tutores.apellidos LIKE '%".$tutor."%' ESCAPE '!'
			)";
		}

		if (!empty($hijo)) {
			# code...
			$sql .=  " AND (
			hijos.dni LIKE '%".$hijo."%' ESCAPE '!' 
	     	OR hijos.nombres LIKE '%".$hijo."%' ESCAPE '!'
	     	OR hijos.apellido_1 LIKE '%".$hijo."%' ESCAPE '!'
	     	OR hijos.apellido_2 LIKE '%".$hijo."%' ESCAPE '!'
			)";
		}

		if (!empty($deporte)) {
			# code...
			$sql .=  " AND (
			deportes.id_deporte = ".$deporte."
			)";
		}

		if (!empty($estado)) {
			# code...
			$sql .=  " AND (
			inscripciones.estado = '".$estado."'
			)";
		}

		if (!empty($pagado)) {
			# code...
			$sql .=  " AND (
			inscripciones.pagado = '".$pagado."'
			)";
		}
	    
	    if (!empty($orden_campo) AND !empty($orden_tipo)) {
		    $sql .=  " 
		     ORDER BY ".$orden_campo." ".$orden_tipo."
		    ";
		}else{
			$sql .=  " 
		     ORDER BY id_inscripcion DESC
		    ";
		}

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

	function table_deportes()
	{

	    $this->db->order_by('deporte', 'ASC');  
	    $query = $this->db->get('deportes');

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