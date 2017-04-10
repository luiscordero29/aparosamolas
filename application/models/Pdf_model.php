<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Pdf_model extends CI_MODEL
{
	public function __construct()
	{
		parent::__construct();
	}

	function pagos($id_inscripcion)
	{			    

		$this->db->select('inscripciones.* ,hijos.*, deportes.deporte, deportes.tipo, tutores.dni tdni,	tutores.apellidos tapellidos, tutores.nombres tnombres, tutores.telefono_movil, tutores.email_principal, tutores.direccion ');
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

	function deportista($id_inscripcion)
	{			    

		$this->db->select('inscripciones.* ,hijos.*, deportes.deporte, deportes.tipo, tutores.dni tdni,	tutores.apellidos tapellidos, tutores.nombres tnombres, tutores.telefono_movil, tutores.email_principal, tutores.direccion ');
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

	function listado($id_inscripcion)
	{			    

		$this->db->select('inscripciones.* ,hijos.*, deportes.deporte, deportes.tipo, tutores.dni tdni,	tutores.apellidos tapellidos, tutores.nombres tnombres, tutores.telefono_movil, tutores.email_principal, tutores.direccion ');
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


	function listados($tutor, $hijo, $deporte, $estado, $pagado, $orden_campo, $orden_tipo)
	{			    
		if (strlen($tutor)==0) {
            $tutor = ''; 
        }
        if (strlen($hijo)==0) {
            $hijo = ''; 
        }
        if (strlen($deporte)==0) {
            $deporte = ''; 
        }
        if (strlen($estado)==0) {
         	$estado = ''; 
        }
        if (strlen($pagado)==0) {
            $pagado = ''; 
        }
        if (strlen($orden_campo)==0) {
            $orden_campo = ''; 
        }
        if (strlen($orden_tipo)==0) {
            $orden_tipo = ''; 
        }


		$sql = 
	    "SELECT 
	     inscripciones.* ,hijos.*, deportes.deporte, deportes.tipo, tutores.dni tdni,
	     tutores.apellidos tapellidos, tutores.nombres tnombres  
	     FROM inscripciones 
	     LEFT JOIN deportes ON deportes.id_deporte = inscripciones.id_deporte
	     LEFT JOIN hijos ON hijos.id_hijo = inscripciones.id_hijo
	     LEFT JOIN tutores ON tutores.id_tutor = hijos.id_tutor
	     WHERE (inscripciones.estatus = 'ACTIVO') AND ( inscripciones.id_inscripcion LIKE '%%' ESCAPE '!') ";

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

	function listados_deportes($deporte, $apellidos, $fechas, $sexo, $afoto, $orden_campo, $orden_tipo)
	{			    
		if (strlen($deporte)==0) {
            $deporte = ''; 
        }
        if (strlen($apellidos)==0) {
            $apellidos = ''; 
        }
        if (strlen($fechas)==0) {
            $fechas = ''; 
        }
        if (strlen($sexo)==0) {
         	$sexo = ''; 
        }
        if (strlen($afoto)==0) {
            $afoto = ''; 
        }
        if (strlen($orden_campo)==0) {
            $orden_campo = ''; 
        }
        if (strlen($orden_tipo)==0) {
            $orden_tipo = ''; 
        }

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

	function listados_pagos($tutor_apellidos, $tutor_nombres, $hijo_apellidos, $hijo_nombres, $deporte, $porcentajes, $estado, $orden_campo, $orden_tipo)
	{			    
		if (strlen($tutor_apellidos)==0) {
            $tutor_apellidos = ''; 
        }
        if (strlen($tutor_nombres)==0) {
            $tutor_nombres = ''; 
        }
        if (strlen($hijo_apellidos)==0) {
            $hijo_apellidos = ''; 
        }
        if (strlen($hijo_nombres)==0) {
         	$hijo_nombres = ''; 
        }
        if (strlen($deporte)==0) {
            $deporte = ''; 
        }
        if (strlen($porcentajes)==0) {
            $porcentajes = ''; 
        }
        if (strlen($estado)==0) {
            $estado = ''; 
        }
        if (strlen($orden_campo)==0) {
            $orden_campo = ''; 
        }
        if (strlen($orden_tipo)==0) {
            $orden_tipo = ''; 
        }

		$sql = 
	    "SELECT 
	     inscripciones.* ,hijos.*, deportes.deporte, deportes.tipo, tutores.dni tdni,
	     tutores.apellidos tapellidos, tutores.nombres tnombres, tutores.telefono_movil, tutores.email_principal  
	     FROM inscripciones 
	     LEFT JOIN deportes ON deportes.id_deporte = inscripciones.id_deporte
	     LEFT JOIN hijos ON hijos.id_hijo = inscripciones.id_hijo
	     LEFT JOIN tutores ON tutores.id_tutor = hijos.id_tutor
	     WHERE (inscripciones.estatus = 'ACTIVO') AND ( inscripciones.id_inscripcion LIKE '%%' ESCAPE '!') ";

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

}