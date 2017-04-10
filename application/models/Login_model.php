<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Login_model extends CI_MODEL
{
	public function __construct()
	{
		parent::__construct();
	}

	public function session()
 	{
	    $user = $this->input->post('username',true);
	    $pass = md5($this->input->post('password',true));
	    $this->db->select('id_usuario, usuario, tipo');
	    $this->db->from('usuarios');
	    $this->db->where('usuario', $user);
	    $this->db->where('clave', $pass);	    
	    $this->db->where('activo', 'SI');
	    $this->db->limit(1);

	    $query = $this->db->get();

	    if($query->num_rows() == 1)
	    {
	    	return $query->result();
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

 	public function register()
 	{
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
 		$password 				= $this->input->post('password'); 
 		$noticias 				= $this->input->post('noticias'); 
 		$condiciones_1 			= $this->input->post('condiciones_1'); 
 		$condiciones_2 			= $this->input->post('condiciones_2');

 		if ($noticias <> 'SI') {
 		 	$noticias ='NO';
 		} 
 		if ($condiciones_1 <> 'SI') {
 		 	$condiciones_1 ='NO';
 		} 
 		if ($condiciones_2 <> 'SI') {
 		 	$condiciones_2 ='NO';
 		} 

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
	 		'noticias' 				=> $noticias, 
	 		'condiciones_1' 		=> $condiciones_1, 
	 		'condiciones_2' 		=> $condiciones_2, 
		);
 		
 		$this->db->insert('tutores', $data); 

 		$id = $this->db->insert_id();

		$data = array(
		   	'usuario' 		=> $dni, 
	 		'clave' 		=> md5($password), 
	 		'tipo' 			=> 'USUARIO',
	 		'activo' 		=> 'SI',  
	 		'correo' 		=> $email_principal, 
		);
		
		$this->db->insert('usuarios', $data);

		$data = array(
		   	'usuario' 		=> $dni, 
	 		'id_tutor' 		=> $id,  
		);
		
		$this->db->insert('accesos', $data); 

		# ENVIO DE CORREO
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'mail.luiscordero29.com';
		$config['smtp_user'] = 'info@luiscordero29.com';
		$config['smtp_pass'] = 'cggQfKz2MwmTAJUKT6';
		$config['smtp_port'] = '25';
		$config['charset'] = 'iso-8859-1';
		$config['mailtype'] = 'html';
		$this->email->initialize($config);


		$text = '<h2>DATOS DE ACCESO</h2>';
		$text .= '<p><b>USUARIO:</b> '.$dni.'</p>';
		$text .= '<p><b>CLAVE:</b> '.$password.'</p>';
		$text .= '<h2>DATOS DE USUARIO</h2>';
		$text .= '<p><b>DNI:</b> '.$dni.'</p>';
		$text .= '<p><b>APELLIDOS:</b> '.$apellidos.'</p>';
		$text .= '<p><b>NOMBRES:</b> '.$nombres.'</p>';
		$text .= '<p><b>DIRECCION:</b> '.$direccion.'</p>';

		# ENVIO ADMINISTRADOR 
		
		$this->email->to('app@aparosamolas.com');
		$this->email->bcc('miguel@webactual.com ');
		$this->email->from($email_principal);
		$this->email->subject('REGISTRO DE USUARIO');
		$this->email->message($text);
		$this->email->send();

		# ENVIO TUTOR

		$this->email->clear();
		$this->email->to($email_principal);
		$this->email->bcc('miguel@webactual.com ');
		$this->email->from('app@aparosamolas.com');
		$this->email->subject('REGISTRO DE APA ROSA MOLAS');
		$this->email->message($text);
		$this->email->send();

		return true;

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

	public function vrenovate()
 	{
	    $email_principal = $this->input->post('email_principal',true);
	    
	    $this->db->from('usuarios');
	    $this->db->where('correo', $email_principal);
	    $this->db->limit(1);

	    $query = $this->db->get();

	    if($query->num_rows() == 1)
	    {
	    	return true;
	    }
	    else
	    {
	    	return false;
	    }
 	}

 	public function renovate()
 	{
	    $email_principal = $this->input->post('email_principal',true);
	    
	    $this->db->from('usuarios');
	    $this->db->where('correo', $email_principal);
	    $this->db->limit(1);

	    $query = $this->db->get();

	    if($query->num_rows() == 1)
	    {
	    	$pass = rand(1000, 9999);
	    	$row = $query->row_array();

		    $data = array(
		 		'clave' 		=> md5($pass),  
			);
			$this->db->where('correo', $email_principal);
			$this->db->update('usuarios', $data);

			# ENVIO DE CORREO
			$this->load->helper('email');
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'mail.luiscordero29.com';
			$config['smtp_user'] = 'info@luiscordero29.com';
			$config['smtp_pass'] = 'cggQfKz2MwmTAJUKT6';
			$config['smtp_port'] = '25';
			$config['charset'] = 'iso-8859-1';
			$config['mailtype'] = 'html';
			$this->email->initialize($config);

			// sent mail 
			$text = '<h2>DATOS DE ACCESO</h2>';
			$text .= '<p><b>USUARIO:</b> '.$row['usuario'].'</p>';
			$text .= '<p><b>CLAVE:</b> '.$pass.'</p>';

			$this->email->to($email_principal);
			$this->email->bcc('miguel@webactual.com ');
			$this->email->from('app@aparosamolas.com');
			$this->email->subject('RESTAURAR USUARIO');
			$this->email->message($text);
			$this->email->send();
			
			return true;

	    }
	    else
	    {
	    	return false;
	    }
 	}

 	function limpia_espacios($cadena){
		$cadena = str_replace(' ', '', $cadena);
		return $cadena;
	}

}