<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Listados_pagos_model extends CI_MODEL
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
	     tutores.apellidos tapellidos, tutores.nombres tnombres, tutores.telefono_movil, tutores.email_principal  
	     FROM inscripciones 
	     LEFT JOIN deportes ON deportes.id_deporte = inscripciones.id_deporte
	     LEFT JOIN hijos ON hijos.id_hijo = inscripciones.id_hijo
	     LEFT JOIN tutores ON tutores.id_tutor = hijos.id_tutor
	     WHERE (inscripciones.estatus = 'ACTIVO') AND ( inscripciones.id_inscripcion LIKE '%%' ESCAPE '!') ";

	    $tutor_apellidos 	= trim($this->input->post('tutor_apellidos'));
		$tutor_nombres 		= trim($this->input->post('tutor_nombres'));
		$hijo_apellidos 	= trim($this->input->post('hijo_apellidos'));
		$hijo_nombres 		= trim($this->input->post('hijo_nombres'));
		$deporte 			= trim($this->input->post('deporte'));
		$porcentajes 		= trim($this->input->post('porcentajes'));
		$estado 			= trim($this->input->post('estado'));
		$orden_campo 		= trim($this->input->post('orden_campo'));
		$orden_tipo 		= trim($this->input->post('orden_tipo'));

		if (!empty($tutor_apellidos)) {
			# code...
			$sql .=  " AND (
	     	tutores.apellidos LIKE '%".$tutor_apellidos."%' ESCAPE '!'
			)";
		}

		if (!empty($tutor_nombres)) {
			# code...
			$sql .=  " AND (
	     	tutores.nombres LIKE '%".$tutor_nombres."%' ESCAPE '!'
			)";
		}

		if (!empty($hijo_apellidos)) {
			# code...
			$sql .=  " AND (
	     	hijos.apellido_1 LIKE '%".$hijo_apellidos."%' ESCAPE '!'
	     	OR hijos.apellido_2 LIKE '%".$hijo_apellidos."%' ESCAPE '!'
			)";
		}

		if (!empty($hijo_nombres)) {
			# code...
			$sql .=  " AND (
	     	hijos.nombres LIKE '%".$hijo_nombres."%' ESCAPE '!'
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

		if (!empty($porcentajes)) {
			# code...
			$sql .=  " AND (
			inscripciones.porcentajes = '".$porcentajes."'
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