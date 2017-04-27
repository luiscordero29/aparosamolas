	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Recibos_inscripciones_model extends CI_MODEL
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
	     tutores.apellidos tapellidos, tutores.nombres tnombres
	     FROM inscripciones
	     LEFT JOIN deportes ON deportes.id_deporte = inscripciones.id_deporte
	     LEFT JOIN hijos ON hijos.id_hijo = inscripciones.id_hijo
	     LEFT JOIN tutores ON tutores.id_tutor = hijos.id_tutor
	     WHERE (inscripciones.estatus = 'ACTIVO') AND ( inscripciones.id_inscripcion LIKE '%%' ESCAPE '!') ";

	    $tutor 		= trim($this->input->post('tutor'));
		$hijo 		= trim($this->input->post('hijo'));
		$deporte 	= trim($this->input->post('deporte'));
		$estado 	= trim($this->input->post('estado'));
		$pagado 	= trim($this->input->post('pagado'));

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

	    $sql .=  "
	     ORDER BY id_inscripcion DESC
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

	function read($id_inscripcion)
	{

		$this->db->select('inscripciones.* ,hijos.*, deportes.deporte, deportes.tipo, tutores.dni tdni, tutores.apellidos tapellidos, tutores.nombres tnombres');
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

	    $id_inscripcion 	= $this->input->post('id_inscripcion');
	    $estado 			= $this->input->post('estado');
	    $porcentajes 		= $this->input->post('porcentajes');

	    switch ($porcentajes) {
	    	case '0':
	    		$pagado = 'NO';
	    		break;
	    	case '50':
	    		$pagado = 'MITAD';
	    		break;
	    	case '100':
	    		$pagado = 'COMPLETO';
	    		break;
	    }

	    $data = array(
		   'estado' 			=> $estado,
		   'porcentajes' 		=> $porcentajes,
		   'pagado' 			=> $pagado,
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

	function validar_items()
	{

	    $rows 	= $this->input->post('id_inscripcion[]');
	    $v0 = $v50 = false;
	    foreach ($rows as $key => $value)
        {

            $query = $this->db->get_where('inscripciones', array('id_inscripcion' => $value));
        	$row = $query->row_array();
        	if ($row['porcentajes']=='0') {
        		$v0 = true;
        	}
        	if ($row['porcentajes']=='50') {
        		$v50 = true;
        	}

        }

	    if($v0 <> $v50)
	    {
	      	return true;
	    }
	    else
	    {
	      	return false;
	    }
	}

	function importe()
	{
	    $importe 	= $this->input->post('importe');
	    if ($importe == '100') {
	    	# code...
	    	$v50 = false;
	    	$rows 	= $this->input->post('id_inscripcion[]');
		    foreach ($rows as $key => $value)
	        {

	            $query = $this->db->get_where('inscripciones', array('id_inscripcion' => $value));
	        	$row = $query->row_array();
	        	if ($row['porcentajes']=='50') {
	        		$v50 = true;
	        	}

	        }
	        if ($v50 == true) {
	        	return false;
	        }else{
	        	return true;
	        }
	    }else{
	    	return true;
	    }

	}

	function cuaderno19()
	{
		$this->load->helper('download');

		$descargar 	= $this->input->post('descargar');

		switch ($descargar) {
			case 'cuaderno19':
				include(FCPATH . 'application/libraries/TCuaderno19.php');
			    # Creamos el objeto
		    	$cuaderno19 = new T_cuaderno19;

		    	// Configuramos el Presentador
		    	$cuaderno19->configuraPresentador("G50372903","112","APA COLEGIO MARIA ROSA MOLAS","2086","0014");

		    	// Generamos un Ordenante
		    	$ultOrdenante=$cuaderno19->agregaOrdenante("G50372903","001","APA COLEGIO MARIA ROSA MOLAS-ACTIVIDADES","2086","0014","80","3300258743");

			    $importe 	= $this->input->post('importe');
			    if ($importe == '100') {
			    	$data =
			    		array(
			    			'pagado' => 'COMPLETO',
			    			'estado' => 'ENVIADO',
			    			'porcentajes' => '100',
			    			);
			    	$rows 	= $this->input->post('id_inscripcion[]');
				    foreach ($rows as $key => $value)
			        {
			            # loop cuaderno
			            $this->db->select('hijos.nombres hn, hijos.apellido_1 ha1, hijos.apellido_2 ha2, tutores.cuenta_bancaria, inscripciones.precio, inscripciones.descuento, deportes.deporte, hijos.colegio');
			            $this->db->where('id_inscripcion', $value);
			            $this->db->join('hijos', 'hijos.id_hijo=inscripciones.id_hijo','left');
			            $this->db->join('tutores', 'tutores.id_tutor=hijos.id_tutor','left');
			            $this->db->join('deportes', 'deportes.id_deporte=inscripciones.id_deporte','left');
			            $query = $this->db->get('inscripciones');
			            $r = $query->row_array();
						
						# hijo
			            $hijo = $this->limpiarCaracteresEspeciales(trim($r['ha1'].' '.$r['ha2'].' '.$r['hn']));
						$hijo = substr($hijo, 0, 20);
						$hijo = str_pad($hijo, 20, '#');/* 
						if (strlen($hijo)<20) {
							for ($i=strlen($hijo); $i < 20; $i++) { 
								# agregar espacios en blanco hasta que llege a 20
								$hijo = $hijo.' ';
							}
						}*/

			            # cuenta bancaria
			            $ban1 = substr($r['cuenta_bancaria'], 4, 8);
			            $ban2 = substr($r['cuenta_bancaria'], 8, 12);
			            $ban3 = substr($r['cuenta_bancaria'], 12, 14);
			            $ban4 = substr($r['cuenta_bancaria'], -10);

			            # monto

			            $monto = $r['precio'] - $r['precio']*$r['descuento']*0.01;
			            $precio = $r['precio'];
			            if ($r['colegio'] == 'NO') {
			            	$monto = $monto + 50;
			            	$precio = $r['precio'] + 50;
			            }

			            # concepto
			            #$con = $r['deporte']."     ".number_format($precio, 2, ',', '.')." EUR";
			            $con = strtoupper($r['deporte']);

			            # line
			            $cuaderno19->agregaRecibo($ultOrdenante,"$value","$hijo","$ban1","$ban2","$ban3","$ban4",$monto,"$con");

			            # update registro
			            $this->db->where('id_inscripcion', $value);
						$this->db->update('inscripciones', $data);

			        }
			    }

			    if ($importe == '50') {
			    	$data0 =
			    		array(
			    			'pagado' => 'COMPLETO',
			    			'estado' => 'ENVIADO',
			    			'porcentajes' => '100',
			    			);
			    	$data1 =
			    		array(
			    			'pagado' => 'MITAD',
			    			'estado' => 'ENVIADO',
			    			'porcentajes' => '50',
			    			);
			    	$rows 	= $this->input->post('id_inscripcion[]');
				    foreach ($rows as $key => $value)
			        {
			            # loop cuaderno
			            $this->db->select('hijos.nombres hn, hijos.apellido_1 ha1, hijos.apellido_2 ha2, tutores.cuenta_bancaria, inscripciones.precio, inscripciones.descuento, deportes.deporte, inscripciones.porcentajes, hijos.colegio');
			            $this->db->where('inscripciones.id_inscripcion', $value);
			            $this->db->join('hijos', 'hijos.id_hijo=inscripciones.id_hijo','left');
			            $this->db->join('tutores', 'tutores.id_tutor=hijos.id_tutor','left');
			            $this->db->join('deportes', 'deportes.id_deporte=inscripciones.id_deporte','left');
			            $query = $this->db->get('inscripciones');
			            $r = $query->row_array();

			            # hijo
			            $hijo = $this->limpiarCaracteresEspeciales(trim($r['ha1'].' '.$r['ha2'].' '.$r['hn']));
						$hijo = substr($hijo, 0, 20);
						$hijo = str_pad($hijo, 20, '#');/* 
						if (strlen($hijo)<20) {
							for ($i=strlen($hijo); $i < 20; $i++) { 
								# agregar espacios en blanco hasta que llege a 20
								$hijo = $hijo.' ';
							}
						}*/


			            # cuenta bancaria
			            $ban1 = substr($r['cuenta_bancaria'], 4, 8);
			            $ban2 = substr($r['cuenta_bancaria'], 8, 12);
			            $ban3 = substr($r['cuenta_bancaria'], 12, 14);
			            $ban4 = substr($r['cuenta_bancaria'], -10);

			            # monto
			            $monto = $r['precio']*0.5 - $r['precio']*$r['descuento']*0.01*0.5;
			            $precio = $r['precio'];
			            if ($r['colegio'] == 'NO') {
			            	$monto = $monto + 25;
			            	$precio = $r['precio'] + 50;
			            }

			            # concepto
			            $con = $r['deporte']."                         ".number_format($precio, 2, ',', '.')." EUR";
			            $con = strtoupper($r['deporte']);

			            # line
			            $cuaderno19->agregaRecibo($ultOrdenante,"$value","$hijo","$ban1","$ban2","$ban3","$ban4",$monto,"$con");

			            # update registro
			        	if ($r['porcentajes']=='0') {
				            $this->db->where('id_inscripcion', $value);
							$this->db->update('inscripciones', $data1);
			        	}
			        	if ($r['porcentajes']=='50') {
				            $this->db->where('id_inscripcion', $value);
							$this->db->update('inscripciones', $data0);
			        	}
			        }
			    }

			    // Load the file helper and write the file to your server
				$this->load->helper('file');
				$file = './assets/cuaderno19/CSB006-'.date("Y-m-d_H-i-s").'.q19';
				write_file($file, $cuaderno19->generaRemesa());
				force_download($file, null);
				break;

			case 'excel':
				$this->load->library('PHPExcel.php');
				$this->load->library('PHPExcel/IOFactory.php');

				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setTitle("APA ROSA MOLAS");
		        $objPHPExcel->getProperties()->setDescription("GESTIÓN DE RECIBOS");
		        $objPHPExcel->getProperties()->setCreator("App - APA ROSA MOLAS");
				$objPHPExcel->getProperties()->setSubject("EMISIÓN DE RECIBOS");
				$objPHPExcel->getProperties()->setKeywords("PHP PHPExcel");
				$objPHPExcel->getProperties()->setCategory("SISTEMAS");
		        $objPHPExcel->setActiveSheetIndex(0);
		        $item = 0;

		        # VALORES
		        $importe 	= $this->input->post('importe');
			    if ($importe == '100') {
			    	$data =
			    		array(
			    			'pagado' => 'COMPLETO',
			    			'estado' => 'ENVIADO',
			    			'porcentajes' => '100',
			    			);
			    	$rows 	= $this->input->post('id_inscripcion[]');
				    foreach ($rows as $key => $value)
			        {
			            # loop cuaderno
			            $this->db->select('hijos.nombres hnombres, hijos.apellido_1, hijos.apellido_2, tutores.nombres , tutores.apellidos, tutores.cuenta_bancaria, inscripciones.precio, inscripciones.descuento, deportes.deporte, hijos.colegio');
			            $this->db->where('id_inscripcion', $value);
			            $this->db->join('hijos', 'hijos.id_hijo=inscripciones.id_hijo','left');
			            $this->db->join('tutores', 'tutores.id_tutor=hijos.id_tutor','left');
			            $this->db->join('deportes', 'deportes.id_deporte=inscripciones.id_deporte','left');
			            $query = $this->db->get('inscripciones');
			            $r = $query->row_array();

			            # monto

			            $monto = $r['precio'] - $r['precio']*$r['descuento']*0.01;
			            $precio = $r['precio'];
			            if ($r['colegio'] == 'NO') {
			            	$monto = $monto + 50;
			            	$precio = $r['precio'] + 50;
			            }

			            # concepto
			            $con = $r['deporte']."     ".number_format($precio, 2, ',', '.')." EUR";

			            # data - excel
			            $item++;
		        		$objPHPExcel->getActiveSheet()->setCellValue('A'.$item, strtoupper(date('mY').' '.$r['nombres'].' '.$r['apellidos']));
						$objPHPExcel->getActiveSheet()->setCellValue('B'.$item, strtoupper($r['hnombres'].' '.$r['apellido_1'].' '.$r['apellido_2']));
		        		$objPHPExcel->getActiveSheet()->setCellValue('C'.$item, strtoupper($r['cuenta_bancaria']));
		        		$objPHPExcel->getActiveSheet()->setCellValue('D'.$item, strtoupper(number_format($monto, 2, ',', '.').""));
		        		$objPHPExcel->getActiveSheet()->setCellValue('E'.$item, strtoupper($r['deporte']));

			            # update registro
			            $this->db->where('id_inscripcion', $value);
						$this->db->update('inscripciones', $data);

			        }
			    }

			    if ($importe == '50') {
			    	$data0 =
			    		array(
			    			'pagado' => 'COMPLETO',
			    			'estado' => 'ENVIADO',
			    			'porcentajes' => '100',
			    			);
			    	$data1 =
			    		array(
			    			'pagado' => 'MITAD',
			    			'estado' => 'ENVIADO',
			    			'porcentajes' => '50',
			    			);
			    	$rows 	= $this->input->post('id_inscripcion[]');
				    foreach ($rows as $key => $value)
			        {
			            # loop cuaderno
			            $this->db->select('hijos.nombres hnombres, hijos.apellido_1, hijos.apellido_2, tutores.nombres , tutores.apellidos, tutores.cuenta_bancaria, inscripciones.precio, inscripciones.descuento, deportes.deporte, hijos.colegio, inscripciones.porcentajes');
			            $this->db->where('inscripciones.id_inscripcion', $value);
			            $this->db->join('hijos', 'hijos.id_hijo=inscripciones.id_hijo','left');
			            $this->db->join('tutores', 'tutores.id_tutor=hijos.id_tutor','left');
			            $this->db->join('deportes', 'deportes.id_deporte=inscripciones.id_deporte','left');
			            $query = $this->db->get('inscripciones');
			            $r = $query->row_array();

			            # monto
			            $monto = $r['precio']*0.5 - $r['precio']*$r['descuento']*0.01*0.5;
			            $precio = $r['precio'];
			            if ($r['colegio'] == 'NO') {
			            	$monto = $monto + 25;
			            	$precio = $r['precio'] + 50;
			            }

			            # data - excel
			            $item++;
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$item, strtoupper(date('mY').' '.$r['nombres'].' '.$r['apellidos']));
						$objPHPExcel->getActiveSheet()->setCellValue('B'.$item, strtoupper($r['hnombres'].' '.$r['apellido_1'].' '.$r['apellido_2']));
			        	$objPHPExcel->getActiveSheet()->setCellValue('C'.$item, strtoupper($r['cuenta_bancaria']));
			        	$objPHPExcel->getActiveSheet()->setCellValue('D'.$item, strtoupper(number_format($monto, 2, ',', '.').""));
			        	$objPHPExcel->getActiveSheet()->setCellValue('E'.$item, strtoupper($r['deporte']));

			            # update registro
			        	if ($r['porcentajes']=='0') {
				            $this->db->where('id_inscripcion', $value);
							$this->db->update('inscripciones', $data1);
			        	}
			        	if ($r['porcentajes']=='50') {
				            $this->db->where('id_inscripcion', $value);
							$this->db->update('inscripciones', $data0);
			        	}
			        }
			    }

		        // Save it as an excel 2003 file
				$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
				$file = './assets/excel/CSB006-'.date("Y-m-d_H-i-s").'.xls';
				$objWriter->save($file);
				force_download($file, NULL);

				break;
		}

		return $file;


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

	function limpiarCaracteresEspeciales($string )
	{
	 	$string = htmlentities($string);
	 	$string = preg_replace('/\&(.)[^;]*;/', '\\1', $string);
	 	return $string;
	}

}
