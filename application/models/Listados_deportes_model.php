<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Listados_deportes_model extends CI_MODEL
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
	     tutores.apellidos tapellidos, tutores.nombres tnombres, tutores.telefono_movil, tutores.email_principal,
	     tutores.direccion  
	     FROM inscripciones 
	     LEFT JOIN deportes ON deportes.id_deporte = inscripciones.id_deporte
	     LEFT JOIN hijos ON hijos.id_hijo = inscripciones.id_hijo
	     LEFT JOIN tutores ON tutores.id_tutor = hijos.id_tutor
	     WHERE (inscripciones.estatus = 'ACTIVO') AND ( inscripciones.id_inscripcion LIKE '%%' ESCAPE '!') ";

	    $deporte 		= trim($this->input->post('deporte'));
		$apellidos 		= trim($this->input->post('apellidos'));
		$familia 		= trim($this->input->post('familia'));
		$fechas 		= trim($this->input->post('fechas'));
		$sexo 			= trim($this->input->post('sexo'));
		$afoto 			= trim($this->input->post('afoto'));
		$orden_campo 	= trim($this->input->post('orden_campo'));
		$orden_tipo 	= trim($this->input->post('orden_tipo'));


		if (!empty($fechas)) {

			$rangos = explode("-", $fechas);
			$rango1 = trim($rangos[0]);
			$rango2 = trim($rangos[1]);

			$date_array = explode('/',$rango1);
			$date_array = array_reverse($date_array);		
			$fecha1 	= date(implode('-', $date_array));

			$date_array = explode('/',$rango2);
			$date_array = array_reverse($date_array);		
			$fecha2 	= date(implode('-', $date_array));	

			$sql .=  " AND (
				fecha_nacimiento BETWEEN '".$fecha1."' AND '".$fecha2."'
			)";
		}

		if (!empty($deporte)) {
			# code...
			$sql .=  " AND (
			deportes.id_deporte = ".$deporte."
			)";
		}

		if (!empty($apellidos)) {
			# code...
			$sql .=  " AND (
	     	hijos.apellido_1 LIKE '%".$apellidos."%' ESCAPE '!'
	     	OR hijos.apellido_2 LIKE '%".$apellidos."%' ESCAPE '!'
			)";
		}

		if (!empty($sexo)) {
			# code...
			$sql .=  " AND (
	     	hijos.sexo = '".$sexo."'
			)";
		}

		if (!empty($afoto)) {
			# code...
			$sql .=  " AND (
	     	hijos.afoto = '".$afoto."'
			)";
		}

		if (!empty($familia)) {
			# code...
			$sql .=  " AND (
	     	hijos.familia = '".$familia."'
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