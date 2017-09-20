<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Inscripciones_model extends CI_MODEL
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
	    "SELECT inscripciones.* ,hijos.*, deportes.deporte FROM inscripciones 
	     LEFT JOIN deportes ON deportes.id_deporte = inscripciones.id_deporte
	     LEFT JOIN hijos ON hijos.id_hijo = inscripciones.id_hijo
	     LEFT JOIN tutores ON tutores.id_tutor = hijos.id_tutor
	     WHERE (inscripciones.estatus = 'ACTIVO') AND (tutores.id_tutor = ".$data['id_tutor'].")
	     AND (
	     	hijos.dni LIKE '%".$search."%' ESCAPE '!' 
	     	OR hijos.nombres LIKE '%".$search."%' ESCAPE '!'
	     	OR hijos.apellido_1 LIKE '%".$search."%' ESCAPE '!'
	     	OR hijos.apellido_2 LIKE '%".$search."%' ESCAPE '!'   
	     	OR deportes.deporte LIKE '%".$search."%' ESCAPE '!' 
	     	OR inscripciones.estado LIKE '%".$search."%' ESCAPE '!' 
	     	OR inscripciones.porcentajes LIKE '%".$search."%'  
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
	    
	    $id_usuario = $this->session->userdata('id_usuario');
	   	$this->db->select('tutores.id_tutor' );
	   	$this->db->join('accesos','accesos.usuario=usuarios.usuario','left' );
	    $this->db->join('tutores','tutores.id_tutor=accesos.id_tutor','left' );
	    $query = $this->db->get_where('usuarios', array('tipo' => 'USUARIO', 'id_usuario' => $id_usuario));
	    $data = $query->row_array();

	   	$sql = 
	    "SELECT inscripciones.* ,hijos.*, deportes.deporte FROM inscripciones 
	     LEFT JOIN deportes ON deportes.id_deporte = inscripciones.id_deporte
	     LEFT JOIN hijos ON hijos.id_hijo = inscripciones.id_hijo
	     LEFT JOIN tutores ON tutores.id_tutor = hijos.id_tutor
	     WHERE (inscripciones.estatus = 'ACTIVO') AND (tutores.id_tutor = ".$data['id_tutor'].")
	     AND (
	     	hijos.dni LIKE '%".$search."%' ESCAPE '!' 
	     	OR hijos.nombres LIKE '%".$search."%' ESCAPE '!'
	     	OR hijos.apellido_1 LIKE '%".$search."%' ESCAPE '!'
	     	OR hijos.apellido_2 LIKE '%".$search."%' ESCAPE '!'   
	     	OR deportes.deporte LIKE '%".$search."%' ESCAPE '!' 
	     	OR inscripciones.estado LIKE '%".$search."%' ESCAPE '!' 
	     	OR inscripciones.porcentajes LIKE '%".$search."%'   
	     	)
	     ORDER BY id_inscripcion DESC
	    ";

	    $query = $this->db->query($sql);

	    return $query->num_rows();

	}

	function create()
	{
	   
	   	$id_usuario = $this->session->userdata('id_usuario');
	   	$this->db->select('tutores.id_tutor' );
	   	$this->db->join('accesos','accesos.usuario=usuarios.usuario','left' );
	    $this->db->join('tutores','tutores.id_tutor=accesos.id_tutor','left' );
	    $query = $this->db->get_where('usuarios', array('tipo' => 'USUARIO', 'id_usuario' => $id_usuario));
	    $data = $query->row_array();

		$id_tutor 			= $data['id_tutor'];
		$id_hijo 			= $this->input->post('id_hijo');
		$id_deporte 		= $this->input->post('id_deporte');
		// segun el tipo de deporte se realiza la inserssion del valor
		$valor 				= $this->input->post('valor'); 
		// consultar los hijos inscriptos
	   	$query = $this->db->get_where('hijos', array('id_hijo' => $id_hijo));
	   	$hijo = $query->row_array();
		
		# Procesar Descuentos
		$descuento = '0';
	   	if ($hijo['descuento_1'] == 'SI') {
	      	$descuento_1 = 10;
	    }else{
	      	$descuento_1 = 0;
	    }
	    if ($hijo['descuento_2'] == 'SI') {
	      	$descuento_2 = 10;
	    }else{
	      	$descuento_2 = 0;
	    }
	    $sql = 
	    "SELECT inscripciones.id_hijo FROM inscripciones 
	     WHERE (inscripciones.estatus = 'ACTIVO') AND (inscripciones.id_hijo = ".$id_hijo.")
	     GROUP BY inscripciones.id_hijo
	    ";
	    $query = $this->db->query($sql);
	    if($query->num_rows() >= 2)
	    {
	      	$descuento_2 = 10;
	      	$sql = 
			    "UPDATE hijos 
			     SET descuento_2 = 'SI'
			     WHERE id_hijo = ".$id_hijo."
			    ";
			$this->db->query($sql);
	    }
	    $descuento = $descuento_1 + $descuento_2;
	    # actualizar descuentos
	    $sql = 
		    "UPDATE inscripciones 
		     SET inscripciones.descuento = ".$descuento." 
		     WHERE (inscripciones.estatus = 'ACTIVO') AND (inscripciones.id_hijo = ".$id_hijo.")
		    ";
		$this->db->query($sql);
		// precio del deporte
		$this->db->select('precio' );
	   	$query = $this->db->get_where('deportes', array('id_deporte' => $id_deporte));
	    $deporte = $query->row_array();
		$precio 			= $deporte['precio'];
		// cuando se creo el registro
		$fecha 				= date("Y-m-d");
		$hora 				= date("H:i:s");
		$estatus 			= 'ACTIVO';
		$modificar 			= 'NO'; 
		$pagado 			= 'NO'; 
		$estado 			= 'NO ENVIADO'; 
		$porcentajes 		= '0'; 
	   	
	   	$data = array(
		   'id_hijo' 			=> $id_hijo,
		   'id_deporte' 		=> $id_deporte,
		   'valor' 				=> $valor,
		   'descuento' 			=> $descuento,
		   'precio' 			=> $precio,
		   'fecha' 				=> $fecha,
		   'hora' 				=> $hora,
		   'estatus' 			=> $estatus,
		   'modificar' 			=> $modificar,
		   'pagado' 			=> $pagado,
		   'estado' 			=> $estado,
		   'porcentajes' 		=> $porcentajes,
		);

		$this->db->insert('inscripciones', $data); 
	    
	    return true;

	} 

	function read($id_inscripcion)
	{			    
		$this->db->select('hijos.*, deportes.*, inscripciones.* ');
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
	    
	    $id_inscripcion = $this->input->post('id_inscripcion');

	    $id_usuario = $this->session->userdata('id_usuario');
	   	$this->db->select('tutores.id_tutor' );
	   	$this->db->join('accesos','accesos.usuario=usuarios.usuario','left' );
	    $this->db->join('tutores','tutores.id_tutor=accesos.id_tutor','left' );
	    $query = $this->db->get_where('usuarios', array('tipo' => 'USUARIO', 'id_usuario' => $id_usuario));
	    $data = $query->row_array();

		$id_tutor 			= $data['id_tutor'];
		$id_hijo 			= $this->input->post('id_hijo');
		$id_deporte 		= $this->input->post('id_deporte');
		// segun el tipo de deporte se realiza la inserssion del valor
		$valor 				= $this->input->post('valor'); 
		# Procesar Descuentos
		$descuento = '0';
	   	if ($hijo['descuento_1'] == 'SI') {
	      	$descuento_1 = 10;
	    }else{
	      	$descuento_1 = 0;
	    }
	    if ($hijo['descuento_2'] == 'SI') {
	      	$descuento_2 = 10;
	    }else{
	      	$descuento_2 = 0;
	    }
	    $sql = 
	    "SELECT inscripciones.id_hijo FROM inscripciones 
	     WHERE (inscripciones.estatus = 'ACTIVO') AND (inscripciones.id_hijo = ".$id_hijo.")
	     GROUP BY inscripciones.id_hijo
	    ";
	    $query = $this->db->query($sql);
	    if($query->num_rows() >= 2)
	    {
	      	$descuento_2 = 10;
	      	$sql = 
			    "UPDATE hijos 
			     SET descuento_2 = 'SI'
			     WHERE id_hijo = ".$id_hijo."
			    ";
			$this->db->query($sql);
	    }
	    $descuento = $descuento_1 + $descuento_2;
	    # actualizar descuentos
	    $sql = 
		    "UPDATE inscripciones 
		     SET inscripciones.descuento = ".$descuento." 
		     WHERE (inscripciones.estatus = 'ACTIVO') AND (inscripciones.id_hijo = ".$id_hijo.")
		    ";
		$this->db->query($sql);

		/*
		// consultar los hijos inscriptos
		$descuento 			= '0'; 
		$sql = 
	    "SELECT inscripciones.id_hijo FROM inscripciones 
	     LEFT JOIN hijos ON hijos.id_hijo = inscripciones.id_hijo
	     LEFT JOIN tutores ON tutores.id_tutor = hijos.id_tutor
	     WHERE (inscripciones.estatus = 'ACTIVO') AND (tutores.id_tutor = ".$id_tutor.")
	     AND (inscripciones.id_inscripcion != ".$id_inscripcion.")
	     GROUP BY inscripciones.id_hijo
	    ";
	    $query = $this->db->query($sql);
	    if($query->num_rows() >= 2)
	    {
	      	# al menos 3 hijos apuntados en al menos un deporte 
	      	# el sistema aplicará un 10% de descuento en la cuota a 
	      	# todos los hijos de ese tutor en todos los deportes 
	      	$descuento 			= '10'; 

	      	$sql = 
		    "UPDATE inscripciones 
		     LEFT JOIN hijos ON hijos.id_hijo = inscripciones.id_hijo
		     LEFT JOIN tutores ON tutores.id_tutor = hijos.id_tutor
		     SET inscripciones.descuento = '10' 
		     WHERE (inscripciones.estatus = 'ACTIVO') AND (tutores.id_tutor = ".$id_tutor.")
		    ";
		    $query = $this->db->query($sql);

		    #Actulizar los hijos a famlilia numerosa

		    $sql = 
		    "UPDATE hijos 
		     SET hijos.familia = 'SI' 
		     WHERE (hijos.id_tutor = ".$id_tutor.")
		    ";
		    $query = $this->db->query($sql);
	    }
	    */
		// precio del deporte
		$this->db->select('precio' );
	   	$query = $this->db->get_where('deportes', array('id_deporte' => $id_deporte));
	    $deporte = $query->row_array();
		$precio 			= $deporte['precio'];
		
	   	$data = array(
		   'id_hijo' 			=> $id_hijo,
		   'id_deporte' 		=> $id_deporte,
		   'valor' 				=> $valor,
		   'descuento' 			=> $descuento,
		   'precio' 			=> $precio,
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
	
	function delete($id_inscripcion)
	{
	   
	   	$query = $this->db->get_where('inscripciones', array('id_inscripcion' => $id_inscripcion));	
	   	
	    // eliminar
	    if($query->num_rows() > 0)
	    {	      
	    	$data = array(
			   'estatus'	=> 'ELIMINADO',
			);
	      	$this->db->where('id_inscripcion', $id_inscripcion);
			$this->db->update('inscripciones', $data);  
	      	return true;
	    }
	    else
	    {
	      	return false;
	    }
	}	

	function inscripcion_check()
	{		
	    $id_deporte = $this->input->post('id_deporte');
	    $id_hijo = $this->input->post('id_hijo');
	    
	    $sql = 
	    "SELECT id_inscripcion FROM inscripciones 
	     WHERE (id_deporte = ".$id_deporte.") AND (id_hijo = ".$id_hijo.")
	     AND (estatus = 'ACTIVO')";

	    $query = $this->db->query($sql);

	    if($query->num_rows() > 0)
	    {
	      	return false;
	    }
	    else
	    {
	      	return true;
	    }
	    
	}

	function valor_check()
	{		
	    $valor = intval($this->input->post('valor'));
	    if ($valor <> 'NUEVO') {
	    	if ( (is_int($valor)) and (strlen($valor)<=2)) {
	    		return true;
	    	}else{
	    		return false;
	    	}
	    }else{
	    	return true;
	    }
	}

	function inscripcion_check2()
	{		
	    $id_deporte = $this->input->post('id_deporte');
	    $id_hijo = $this->input->post('id_hijo');
	    $id_inscripcion = $this->input->post('id_inscripcion');
	    
	    $sql = 
	    "SELECT id_inscripcion FROM inscripciones 
	     WHERE (id_deporte = ".$id_deporte.") AND (id_hijo = ".$id_hijo.")
	     AND (estatus = 'ACTIVO') AND (id_inscripcion != ".$id_inscripcion.")";

	    $query = $this->db->query($sql);

	    if($query->num_rows() > 0)
	    {
	      	return false;
	    }
	    else
	    {
	      	return true;
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

	function table_hijos()
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
	     ORDER BY id_hijo DESC
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

	function read_deporte($id_deporte)
	{			    
	    
	    $query = $this->db->get_where('deportes', array('id_deporte' => $id_deporte));	    

	    if($query->num_rows() > 0)
	    {	      
	      	return $query->row_array();
	    }
	    else
	    {
	      	return false;
	    }

	}

	function read_deporte_info($id_hijo,$id_deporte)
	{			    
	    
	    $query = $this->db->get_where('inscripciones', array('id_hijo' => $id_hijo, 'id_deporte' => $id_deporte));	    

	    if($query->num_rows() > 0)
	    {	      
	      	#return 'Introduzca el número de DORSAL del año pasado';
	      	return true;
	    }
	    else
	    {
	      	#return 'Introduzca el número del nuevo DORSAL';
	      	return false;
	    }

	}

	function periodo()
	{			    
	    
	    $query = $this->db->get_where('periodos', array('id_periodo' => '1'));	    

	    return $query->row_array();

	}

}