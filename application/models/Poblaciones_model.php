<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Poblaciones_model extends CI_MODEL
{
	public function __construct()
	{
		parent::__construct();
	}		

	function table($limit,$start,$search)
	{

	    $this->db->order_by('poblacion', 'ASC');  
	    $this->db->like('poblacion', $search);
	    $query = $this->db->get('poblaciones', $start, $limit);

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
	    
	    $this->db->like('poblacion', $search);
	    $this->db->from('poblaciones');
	    return $this->db->count_all_results();

	}

	function data()
	{
		
		$poblacion 		= $this->input->post('poblacion');   
	   	
	   	$data = array(
		   'poblacion' 		=> $poblacion,
		);

		return $data;
	}

	function create()
	{
	   
	   	$data = $this->data();

		$this->db->insert('poblaciones', $data); 
	    
	    return true;

	} 

	function read($id_poblacion)
	{			    
	    
	    $query = $this->db->get_where('poblaciones', array('id_poblacion' => $id_poblacion));	    

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
	    
	    $id_poblacion = $this->input->post('id_poblacion');

	    $data = $this->data();
	    
		$query = $this->db->get_where('poblaciones', array('id_poblacion' => $id_poblacion));	    

	    if($query->num_rows() > 0)
	    {	      	      	
	      	$this->db->where('id_poblacion', $id_poblacion);
			$this->db->update('poblaciones', $data); 
	      	return true;
	    }
	    else
	    {
	      	return false;
	    }
	} 

	function delete($id_poblacion)
	{
	   
	   	$query = $this->db->get_where('poblaciones', array('id_poblacion' => $id_poblacion));	
	   	
	    // eliminar
	    if($query->num_rows() > 0)
	    {	      
			# verificar si esta inscritp 
	    	$query = $this->db->get_where('tutores', array('id_poblacion' => $id_poblacion));	
	    	if($query->num_rows() > 0)
	    	{
	    		$data['danger'] = 
					array( 
						'Este poblado contiene tutores y no puede ser eliminado.',				
					);

	    	}else{

	    		$this->db->where('id_poblacion', $id_poblacion);
				$this->db->delete('poblaciones');
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

	function poblacion_check()
	{		
	    $poblacion = $this->input->post('poblacion');
	    $id_poblacion = $this->input->post('id_poblacion');

	    $this->db->where('id_poblacion !=', $id_poblacion);
		$this->db->where('poblacion', $poblacion); 
		$query = $this->db->get('poblaciones');
	    
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