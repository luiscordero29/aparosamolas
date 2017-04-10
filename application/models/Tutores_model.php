<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Tutores_model extends CI_MODEL
{
	public function __construct()
	{
		parent::__construct();
	}		

	function table($limit,$start,$search)
	{

	    $sql = 
	    "SELECT * FROM usuarios 
	     LEFT JOIN accesos ON accesos.usuario = usuarios.usuario
	     LEFT JOIN tutores ON tutores.id_tutor = accesos.id_tutor
	     WHERE (usuarios.tipo = 'USUARIO') 
	     AND (
	     	usuarios.usuario LIKE '%".$search."%' ESCAPE '!' 
	     	OR usuarios.correo LIKE '%".$search."%' ESCAPE '!'
	     	OR tutores.nombres LIKE '%".$search."%' ESCAPE '!'
	     	OR tutores.apellidos LIKE '%".$search."%' ESCAPE '!'
	     	OR usuarios.activo LIKE '%".$search."%'  
	     	)
	     ORDER BY usuarios.id_usuario DESC
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
	     LEFT JOIN accesos ON accesos.usuario = usuarios.usuario
	     LEFT JOIN tutores ON tutores.id_tutor = accesos.id_tutor
	     WHERE (usuarios.tipo = 'USUARIO') 
	     AND (
	     	usuarios.usuario LIKE '%".$search."%' ESCAPE '!' 
	     	OR usuarios.correo LIKE '%".$search."%' ESCAPE '!'
	     	OR tutores.nombres LIKE '%".$search."%' ESCAPE '!'
	     	OR tutores.apellidos LIKE '%".$search."%' ESCAPE '!'
	     	OR usuarios.activo LIKE '%".$search."%'  
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

	function read($id_usuario)
	{			    
	    $this->db->join('accesos','accesos.usuario=usuarios.usuario','left' );
	    $this->db->join('tutores','tutores.id_tutor=accesos.id_tutor','left' );
	    $this->db->join('poblaciones','poblaciones.id_poblacion=tutores.id_poblacion','left' );
	    $query = $this->db->get_where('usuarios', array('tipo' => 'USUARIO', 'id_usuario' => $id_usuario));	    

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
	    
		$query = $this->db->get_where('usuarios', array('tipo' => 'USUARIO', 'id_usuario' => $id_usuario));	    

	    if($query->num_rows() > 0)
	    {	      	      	
	      	$this->db->where('id_usuario', $id_usuario);
			$this->db->update('usuarios', $data); 
	      	$bam = true;
	    }
	    else
	    {
	      	$bam = false;
	    }

	    $id_tutor = $this->input->post('id_tutor');

	    $dni 					= $this->input->post('dni'); 
 		$apellidos 				= $this->input->post('apellidos'); 
 		$nombres 				= $this->input->post('nombres'); 
 		$direccion 				= $this->input->post('direccion'); 
 		$id_poblacion 			= $this->input->post('id_poblacion'); 
 		$codigo_postal 			= $this->input->post('codigo_postal'); 
 		$telefono_movil 		= $this->input->post('telefono_movil'); 
 		$telefono_fijo 			= $this->input->post('telefono_fijo'); 
 		$email_principal 		= $this->input->post('email_principal'); 
 		$email_secundario 		= $this->input->post('email_secundario'); 
 		$pareja_nombres 		= $this->input->post('pareja_nombres'); 
 		$pareja_apellidos 		= $this->input->post('pareja_apellidos'); 
 		$pareja_movil 			= $this->input->post('pareja_movil'); 
 		$cuenta_bancaria 		= $this->limpia_espacios($this->input->post('cuenta_bancaria')); 

 		$data = array(
		   	'dni' 					=> $dni, 
	 		'apellidos' 			=> $apellidos, 
	 		'nombres' 				=> $nombres, 
	 		'direccion' 			=> $direccion, 
	 		'id_poblacion' 			=> $id_poblacion, 
	 		'codigo_postal' 		=> $codigo_postal, 
	 		'telefono_movil' 		=> $telefono_movil, 
	 		'telefono_fijo' 		=> $telefono_fijo, 
	 		'email_principal' 		=> $email_principal, 
	 		'email_secundario' 		=> $email_secundario, 
	 		'pareja_nombres' 		=> $pareja_nombres, 
	 		'pareja_apellidos' 		=> $pareja_apellidos, 
	 		'pareja_movil' 			=> $pareja_movil, 
	 		'cuenta_bancaria' 		=> $cuenta_bancaria, 
		);
	    
		$query = $this->db->get_where('tutores', array('id_tutor' => $id_tutor));	    

	    if($query->num_rows() > 0)
	    {	      	      	
	      	$this->db->where('id_tutor', $id_tutor);
			$this->db->update('tutores', $data); 
	      	$bam = true;
	    }
	    else
	    {
	      	$bam = false;
	    }

	    return $bam;
	} 

	function delete($id_usuario)
	{
	   	$this->db->join('accesos','accesos.usuario=usuarios.usuario','left' );
	    $this->db->join('tutores','tutores.id_tutor=accesos.id_tutor','left' );
	   	$query = $this->db->get_where('usuarios', array('tipo' => 'USUARIO', 'id_usuario' => $id_usuario));	
	   	
	    // eliminar
	    if($query->num_rows() > 0)
	    {	      
	      	$data = $query->row_array();

	      	# verificar si esta inscritp 
	    	$query = $this->db->get_where('hijos', array('id_tutor' => $data['id_tutor']));
	    	if($query->num_rows() > 0)
	    	{
	    		$data['danger'] = 
					array( 
						'Este tutor posee deportista y no puede ser eliminado.',				
					);

	    	}else{
		  		
		  		$this->db->where('id_usuario', $id_usuario);
				$this->db->delete('usuarios');

		      	$this->db->where('id_tutor', $data['id_tutor']);
				$this->db->delete('tutores');

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

	function dni_check()
	{		
	    $dni = $this->input->post('dni');
	    $id_tutor = $this->input->post('id_tutor');

	    $this->db->where('id_tutor !=', $id_tutor);
		$this->db->where('dni', $dni); 
		$query = $this->db->get('tutores');
	    
	    if($query->num_rows() > 0)
	    {	      
	      	return true;
	    }
	    else
	    {
	      	return false;
	    }
	}

	public function table_poblaciones()
 	{
	    $this->db->order_by('poblacion', 'ASC');  
	    $query = $this->db->get('poblaciones');
	    
	    if($query->num_rows() > 0)
	    {
	      	return $query->result_array();
	    }
	    else
	    {
	      	return false;
	    }
 	}

 	function cuenta()
	{
	   	$iban=trim($this->input->post('cuenta_bancaria') );
	   	$iban=$this->limpia_espacios($iban);
	   	$iban=strtoupper($iban);

	   	if(strlen($iban)!=24)
	   	{
	      	return false;
	   	}
	   	else
	   	{
	      	$letra1 = substr($iban, 0, 1);
	      	$letra2 = substr($iban, 1, 1);

	      	$num1 = $this->numeroLetra($letra1);
	      	$num2 = $this->numeroLetra($letra2);

	      	$final= substr($iban, 2, 2);

	      	$temp = substr($iban, 4, strlen($iban)).$num1.$num2.$final;

	      	if($this->my_bcmod($temp,97)==1)
	      	{
	         	return true;
	      	}
	      	else
	      	{
	         	return false;
	      	}
	   }
	}

	function numeroLetra($letra)
	{

	   	$letras["A"]=10;
	   	$letras["B"]=11;
	   	$letras["C"]=12;
	   	$letras["D"]=13;
	   	$letras["E"]=14;
	   	$letras["F"]=15;
	   	$letras["G"]=16;
	   	$letras["H"]=17;
	   	$letras["I"]=18;
	   	$letras["J"]=19;
	   	$letras["K"]=20;
	   	$letras["L"]=21;
	   	$letras["M"]=22;
	   	$letras["N"]=23;
	   	$letras["O"]=24;
	   	$letras["P"]=25;
	   	$letras["Q"]=26;
	   	$letras["R"]=27;
	   	$letras["S"]=28;
	   	$letras["T"]=29;
	   	$letras["U"]=30;
	   	$letras["V"]=31;
	   	$letras["W"]=32;
	   	$letras["X"]=33;
	   	$letras["Y"]=34;
	   	$letras["Z"]=35;

	   	return($letras[$letra]);
	}

	function my_bcmod( $x, $y ) 
	{ 
	    // how many numbers to take at once? carefull not to exceed (int) 
	    $take = 5;     
	    $mod = ''; 

	    do 
	    { 
	        $a = (int)$mod.substr( $x, 0, $take ); 
	        $x = substr( $x, $take ); 
	        $mod = $a % $y;    
	    } 
	    while ( strlen($x) ); 

	    return (int)$mod; 
	} 


	function dni() {
		
		$dni = $this->input->post('dni'); 

		if(strlen($dni)<9) {
			return false;
		}
	 
		$dni = strtoupper($dni);
	 
		$letra = substr($dni, -1, 1);
		$numero = substr($dni, 0, 8);
	 
		// Si es un NIE hay que cambiar la primera letra por 0, 1 ó 2 dependiendo de si es X, Y o Z.
		$numero = str_replace(array('X', 'Y', 'Z'), array(0, 1, 2), $numero);	
	 
		$modulo = $numero % 23;
		$letras_validas = "TRWAGMYFPDXBNJZSQVHLCKE";
		$letra_correcta = substr($letras_validas, $modulo, 1);
	 
		if($letra_correcta!=$letra) {
			return false;
		}
		else {
			return true;
		}
	}

	function limpia_espacios($cadena){
		$cadena = str_replace(' ', '', $cadena);
		return $cadena;
	}

}