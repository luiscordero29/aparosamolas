<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Administradores_model extends CI_MODEL
{
	public function __construct()
	{
		parent::__construct();
	}		

	function table($limit,$start,$search)
	{

	    $sql = 
	    "SELECT * FROM usuarios 
	     WHERE (tipo = 'ADMINISTRADOR') 
	     AND (
	     	usuario LIKE '%".$search."%' ESCAPE '!' 
	     	OR correo LIKE '%".$search."%' ESCAPE '!'
	     	OR activo LIKE '%".$search."%'  
	     	)
	     ORDER BY id_usuario DESC
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
	    "SELECT * FROM usuarios 
	     WHERE (tipo = 'ADMINISTRADOR') 
	     AND (
	     	usuario LIKE '%".$search."%' ESCAPE '!' 
	     	OR correo LIKE '%".$search."%' ESCAPE '!'
	     	OR activo LIKE '%".$search."%'  
	     	)
	     ORDER BY id_usuario DESC
	    ";

	    $query = $this->db->query($sql);

	    if($query->num_rows() > 0)
	    {
	      	return $query->num_rows();
	    }
	    else
	    {
	      	return false;
	    }
	}

	function create()
	{
	   
	   	$usuario 	= $this->input->post('usuario');
	   	$clave 		= MD5($this->input->post('usuario'));
	   	$activo 	= $this->input->post('activo');
	   	$correo 	= $this->input->post('correo');	 
	   	$tipo 		= $this->input->post('tipo');	     	

	   	$data = array(
		   'usuario' 	=> $usuario,
		   'activo' 	=> $activo,
		   'clave' 		=> $clave,
		   'correo' 	=> $correo,
		   'tipo' 		=> $tipo,
		);

		$this->db->insert('usuarios', $data); 
	    
	    return true;

	} 

	function read($id_usuario)
	{			    
	    
	    $query = $this->db->get_where('usuarios', array('tipo' => 'ADMINISTRADOR', 'id_usuario' => $id_usuario));	    

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
	    
	    $id_usuario = $this->input->post('id_usuario');

	    $usuario 	= $this->input->post('usuario');
	   	$activo 	= $this->input->post('activo');
	   	$correo 	= $this->input->post('correo');	   	

	   	$data = array(
		   'usuario' 	=> $usuario,
		   'activo' 	=> $activo,
		   'correo' 	=> $correo,
		);
	    
		$query = $this->db->get_where('usuarios', array('tipo' => 'ADMINISTRADOR', 'id_usuario' => $id_usuario));	    

	    if($query->num_rows() > 0)
	    {	      	      	
	      	$this->db->where('id_usuario', $id_usuario);
			$this->db->update('usuarios', $data); 
	      	return true;
	    }
	    else
	    {
	      	return false;
	    }
	} 

	function delete($id_usuario)
	{
	   
	   	$query = $this->db->get_where('usuarios', array('tipo' => 'ADMINISTRADOR', 'id_usuario' => $id_usuario));	
	   	
	    // eliminar
	    if($query->num_rows() > 0)
	    {	      
	      	$data = $query->row_array();

		    /*// conceptos
			$query1 = $this->db->get_where('conceptos', array('usuario' => $data['usuario']));		    		
			if($query1->num_rows() > 0)
		    {	      	      	
		      	return false;
		    }

		    // proveedores
			$query2 = $this->db->get_where('proveedores', array('usuario' => $data['usuario']));		    		
			if($query2->num_rows() > 0)
		    {	      	      	
		      	return false;
		    }

		    // documentos
			$query3 = $this->db->get_where('documentos', array('usuario' => $data['usuario']));		    		
			if($query3->num_rows() > 0)
		    {	      	      	
		      	return false;
		    }

		    // almacenes
			$query4 = $this->db->get_where('almacenes', array('usuario' => $data['usuario']));		    		
			if($query4->num_rows() > 0)
		    {	      	      	
		      	return false;
		    }

		    // unidades
			$query5 = $this->db->get_where('unidades', array('usuario' => $data['usuario']));		    		
			if($query5->num_rows() > 0)
		    {	      	      	
		      	return false;
		    }

		    // articulos
			$query6 = $this->db->get_where('articulos', array('usuario' => $data['usuario']));		    		
			if($query6->num_rows() > 0)
		    {	      	      	
		      	return false;
		    }

		    // grupos
			$query7 = $this->db->get_where('grupos', array('usuario' => $data['usuario']));		    		
			if($query7->num_rows() > 0)
		    {	      	      	
		      	return false;
		    }

		    // subgrupos
			$query8 = $this->db->get_where('subgrupos', array('usuario' => $data['usuario']));		    		
			if($query8->num_rows() > 0)
		    {	      	      	
		      	return false;
		    }

		    // secciones
			$query9 = $this->db->get_where('secciones', array('usuario' => $data['usuario']));		    		
			if($query9->num_rows() > 0)
		    {	      	      	
		      	return false;
		    }*/

	    	$this->db->where('id_usuario', $id_usuario);
			$this->db->delete('usuarios'); 
	      	return true;
	    }
	    else
	    {
	      	return false;
	    }
	}	

	function usuario_check()
	{		
	    $usuario = $this->input->post('usuario');
	    $id_usuario = $this->input->post('id_usuario');

	    $this->db->where('id_usuario !=', $id_usuario);
		$this->db->where('usuario', $usuario); 
		$query = $this->db->get('usuarios');
	    
	    if($query->num_rows() > 0)
	    {	      
	      	return true;
	    }
	    else
	    {
	      	return false;
	    }
	}

}