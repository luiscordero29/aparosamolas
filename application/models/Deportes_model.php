<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Deportes_model extends CI_MODEL
{
	public function __construct()
	{
		parent::__construct();
	}		

	function table($limit,$start,$search)
	{

	    $this->db->order_by('deporte', 'ASC');  
	    $this->db->like('deporte', $search);
	    $this->db->or_like('precio', $search);
	    $this->db->or_like('tipo', $search);
	    $query = $this->db->get('deportes', $start, $limit);

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
	    
	    $this->db->like('deporte', $search);
	    $this->db->or_like('precio', $search);
	    $this->db->or_like('tipo', $search);
	    $this->db->from('deportes');
	    return $this->db->count_all_results();

	}

	function data()
	{
		
		$deporte 		= $this->input->post('deporte');
		$precio 		= $this->input->post('precio'); 
		$tipo 			= $this->input->post('tipo');   
	   	
	   	$data = array(
		   'deporte' 		=> $deporte,
		   'precio' 		=> $precio,
		   'tipo' 			=> $tipo,
		);

		return $data;
	}

	function create()
	{
	   
	   	$data = $this->data();

		$this->db->insert('deportes', $data); 
	    
	    return true;

	} 

	function read($id_deporte)
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

	function update()
	{
	    
	    $id_deporte = $this->input->post('id_deporte');

	    $data = $this->data();
	    
		$query = $this->db->get_where('deportes', array('id_deporte' => $id_deporte));	    

	    if($query->num_rows() > 0)
	    {	      	      	
	      	$this->db->where('id_deporte', $id_deporte);
			$this->db->update('deportes', $data); 
	      	return true;
	    }
	    else
	    {
	      	return false;
	    }
	} 

	function delete($id_deporte)
	{
	   
	   	$query = $this->db->get_where('deportes', array('id_deporte' => $id_deporte));	
	   	
	    // eliminar
	    if($query->num_rows() > 0)
	    {	      
	  		// No eliminar si existe inscripciones
	  		$query = $this->db->get_where('inscripciones', array('id_deporte' => $id_deporte));	
	    	if($query->num_rows() > 0)
	    	{
	    		$data['danger'] = 
					array( 
						'Este deporte posee inscripciones y no puede ser eliminado.',				
					);

	    	}else{
	  		
		    	$this->db->where('id_deporte', $id_deporte);
				$this->db->delete('deportes'); 
		      	
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

	function deporte_check()
	{		
	    $deporte = $this->input->post('deporte');
	    $id_deporte = $this->input->post('id_deporte');

	    $this->db->where('id_deporte !=', $id_deporte);
		$this->db->where('deporte', $deporte); 
		$query = $this->db->get('deportes');
	    
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