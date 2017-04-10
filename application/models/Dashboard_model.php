<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Dashboard_model extends CI_MODEL
{
	public function __construct()
	{
		parent::__construct();
	}

	public function session()
 	{
	    $user = $this->input->post('user',true);
	    $pass = md5($this->input->post('pass',true));

	    $query 	= 	$this->db->get_where('usuarios', 
	    			array('usuario' => $user, 'clave' => $pass, 'activo' => 'SI')
	    			);	    

	    if($query->num_rows() == 1)
	    {
	    	return $query->result();
	    }
	    else
	    {
	    	return false;
	    }
 	}

 	public function set_row_usuario($id_usuario)
	{		
	    
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

	public function  update_usuario()
	{
		$id_usuario = $this->input->post('id_usuario');
		$apellidos 	= $this->input->post('apellidos');
		$nombres 	= $this->input->post('nombres');
		$cargo 		= $this->input->post('cargo');
		$direccion 	= $this->input->post('direccion');
		$telefono 	= $this->input->post('telefono');

		$data = array(
               'apellidos' 	=> $apellidos,
               'nombres' 	=> $nombres,
               'cargo' 		=> $cargo,
               'direccion' 	=> $direccion,
               'telefono' 	=> $telefono
            );

		$this->db->where('id_usuario', $id_usuario);
		$this->db->update('usuarios', $data); 

		return true;
	}

	public function  update_usuario_clave()
	{
		$id_usuario = $this->input->post('id_usuario');
		$pass 		= md5($this->input->post('pass'));
		
		$data = array(
               'clave' 	=> $pass
            );

		$this->db->where('id_usuario', $id_usuario);
		$this->db->update('usuarios', $data); 

		return true;
	}

	public function  nick()
	{
		$usuario = $this->session->userdata('usuario');
		
		$query = $this->db->get_where('accesos', array('usuario' => $usuario));
	
		if($query->num_rows() > 0)
	    {
	      	$data = $query->row_array();
	      
	      	$query2 = $this->db->get_where('tutores', array('id_tutor' => $data['id_tutor']));
	      	if($query2->num_rows() > 0)
			{
			    $info = $query2->row_array();
			    return $info['apellidos'].' '.$info['nombres'];
			}
			else
			{
			    return false;
			}

	    }
	    else
	    {
	      	return false;
	    }

	}

	public function deportes()
	{		
	    
	    $query = $this->db->get_where('deportes');
	    return $query->num_rows();

	}

	public function hijos()
	{		
	    
	    $query = $this->db->get_where('hijos', array('estatus' => 'ACTIVO' ));
	    return $query->num_rows();

	}

	public function tutores()
	{		
	    
	    $query = $this->db->get_where('tutores');
	    return $query->num_rows();

	}

	public function inscripciones()
	{		
	    
	    $query = $this->db->get_where('inscripciones', array('estatus' => 'ACTIVO' ));
	    return $query->num_rows();

	}

	function inscripciones_read()
	{			    
	    
	    $query = $this->db->get_where('periodos', array('id_periodo' => '1'));	    

	    if($query->num_rows() > 0)
	    {	      
	      	return $query->row_array();
	    }
	    else
	    {
	      	return false;
	    }

	}

	function inscripciones_update()
	{
	    
	    $id_periodo = $this->input->post('id_periodo');

	    $estatus 		= $this->input->post('estatus');
		
	   	$data = array(
		   'estatus' 		=> $estatus,
		);

		$query = $this->db->get_where('periodos', array('id_periodo' => $id_periodo));	    

	    if($query->num_rows() > 0)
	    {	      	      	
	      	$this->db->where('id_periodo', $id_periodo);
			$this->db->update('periodos', $data); 
	      	return true;
	    }
	    else
	    {
	      	return false;
	    }
	} 

	function familia()
	{			    
	    # FAMILIA NO
	    $data = array(
		   'familia' 		=> 'NO',
		);
		$this->db->update('hijos', $data);

		# DESCUENTO 0
	    $data = array(
		   'descuento' 		=> 0,
		);
		$this->db->update('inscripciones', $data);

		# LISTAR TUTORES
	    $query = $this->db->get('tutores');

	    if($query->num_rows() > 0)
	    {
	      	$tutores = $query->result_array();

	      	foreach ($tutores as $tutor) {

	      		$sql = 
			    "SELECT inscripciones.id_hijo FROM inscripciones 
			     LEFT JOIN hijos ON hijos.id_hijo = inscripciones.id_hijo
			     LEFT JOIN tutores ON tutores.id_tutor = hijos.id_tutor
			     WHERE (inscripciones.estatus = 'ACTIVO') AND (tutores.id_tutor = ".$tutor['id_tutor'].")
			     GROUP BY inscripciones.id_hijo
			    ";
			    $query = $this->db->query($sql);
			    if($query->num_rows() >= 3)
			    {
			      	# al menos 3 hijos apuntados en al menos un deporte 
			      	# el sistema aplicará un 10% de descuento en la cuota a 
			      	# todos los hijos de ese tutor en todos los deportes 

			      	$sql = 
				    "UPDATE inscripciones 
				     LEFT JOIN hijos ON hijos.id_hijo = inscripciones.id_hijo
				     LEFT JOIN tutores ON tutores.id_tutor = hijos.id_tutor
				     SET inscripciones.descuento = '10' 
				     WHERE (inscripciones.estatus = 'ACTIVO') AND (tutores.id_tutor = ".$tutor['id_tutor'].")
				    ";
				    $query = $this->db->query($sql);

				    #Actulizar los hijos a famlilia numerosa

				    $sql = 
				    "UPDATE hijos 
				     SET hijos.familia = 'SI' 
				     WHERE (hijos.id_tutor = ".$tutor['id_tutor'].")
				    ";
				    $query = $this->db->query($sql);
			    }
	      	}
	    }
	    
	}
}