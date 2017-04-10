<?php
	/********************************************************************************************
	
		Clase creada por Enrique David de zeroDesigners
		
		Su utilidad es generar el fichero de la norma 19
		para adeudos por domiciliacion bancaria en España
		
		Proyecto:					Generacion de fichero Cuaderno 19
		Version:						1
		Autor:						Enrique David
		Empresa:						zeroDesigners.com
		Ultima Modificacion:		12 de enero 2007
		Fecha de Inicio:			12 de enero 2007
		Fecha de Finalizacion:	12 de enero 2007
		
		Copyright (C): 2007 Spherical Pixel SL, All Rights Reserved 
		
		Donaciones PayPal en: paypal@zerodesigners.com
		PayPal Donations in: paypal@zerodesigners.com
	
	*********************************************************************************************/


	class T_cuaderno19
	{
		var $_arPresentador = array(
			"nif"=>"",
			"sufijo"=>"",
			"nombre"=>"",
			"entidad"=>"",
			"oficina"=>"",
			"total"=>0,
			"nOrd"=>0,
			"nRec"=>0,
			"nReg"=>0
		);

		var $_arOrdenantes = array();

		var $_arIndividual = array();

		/*
			Funcion:
				configuraPresentador(nif,sufijo,nombre,entidad,oficina)
				
			Parametros:
				nif: NIF del presentador
				sufijo: SUFIJO del presentador
				nombre: NOMBRE del presentador
				entidad: ENTIDAD BANCARIA del presentador
				oficina: OFICINA BANCARIA del presentador
			
			Devuelve:
				0: El ID del presentador ya que solo se permite un presentador por remesa
		*/
		function configuraPresentador($nif,$sufijo,$nombre,$entidad,$oficina)
		{
			$this->_arPresentador["nif"]=strtoupper($nif);
			$this->_arPresentador["sufijo"]=strtoupper($sufijo);
			$this->_arPresentador["nombre"]=strtoupper($nombre);
			$this->_arPresentador["entidad"]=strtoupper($entidad);
			$this->_arPresentador["oficina"]=strtoupper($oficina);
			$this->_arPresentador["total"]=0;
			$this->_arPresentador["nOrd"]=0;
			$this->_arPresentador["nRec"]=0;
			$this->_arPresentador["nReg"]=2;

			return 0;
		}

		/*
			Funcion:
				agregaOrdenante($nif,$sufijo,$nombre,$entidad,$oficina,$dc,$cuenta)
				
			Parametros:
				nif: NIF del ordenante
				sufijo: SUFIJO del ordenante
				nombre: NOMBRE del ordenante
				entidad: ENTIDAD BANCARIA del ordenante
				oficina: OFICINA BANCARIA del ordenante
				dc: DIGITO DE CONTROL DE LA CUENTA BANCARIA del ordenante
				cuenta: NUMERO DE CUENTA BANCARIA del ordenante
			
			Devuelve:
				entero: El ID del ordenante generado
		*/
		function agregaOrdenante($nif,$sufijo,$nombre,$entidad,$oficina,$dc,$cuenta)
		{
			$this->_arOrdenantes[]=array(
				"nif"=>strtoupper($nif),
				"sufijo"=>strtoupper($sufijo),
				"nombre"=>strtoupper($nombre),
				"entidad"=>strtoupper($entidad),
				"oficina"=>strtoupper($oficina),
				"dc"=>strtoupper($dc),
				"cuenta"=>strtoupper($cuenta),
				"total"=>0,
				"nRec"=>0,
				"nReg"=>2
			);

			return count($this->_arOrdenantes)-1;
		}

		/*
			Funcion:
				agregaRecibo($idOrdenante,$ref,$nombre,$entidad,$oficina,$dc,$cuenta,$importe,$concepto)
				
			Parametros:
				idOrdenante: ID DEL ORDENANTE al que le asignamos el recibo agregado
				ref: REFERENCIA del cliente
				nombre: NOMBRE del cliente
				entidad: ENTIDAD BANCARIA del cliente
				oficina: OFICINA BANCARIA del cliente
				dc: DIGITO DE CONTROL DE LA CUENTA BANCARIA del cliente
				cuenta: NUMERO DE CUENTA BANCARIA del cliente
				importe: IMPORTE del recibo
				concepto: CONCEPTO del recibo
			
			Devuelve:
				entero: El ID del recibo
		*/
		function agregaRecibo($idOrdenante,$ref,$nombre,$entidad,$oficina,$dc,$cuenta,$importe,$concepto)
		{
			$this->_arIndividual[$idOrdenante][]=array(
				"ref"=>strtoupper($ref),
				"nombre"=>strtoupper($nombre),
				"entidad"=>strtoupper($entidad),
				"oficina"=>strtoupper($oficina),
				"dc"=>strtoupper($dc),
				"cuenta"=>strtoupper($cuenta),
				"importe"=>$importe,
				"concepto"=>strtoupper($concepto)
			);

			return count($this->_arIndividual)-1;
		}

		/*
			Funcion:
				generaRemesa()
				
			Parametros:
				Ninguno
			
			Devuelve:
				cadena de texto con el fichero del cuaderno 19
		*/
		function generaRemesa()
		{
			$remesa = "";

			$remesa.= $this->_generaPresentador($this->_arPresentador["nif"],$this->_arPresentador["sufijo"],
														$this->_arPresentador["nombre"],$this->_arPresentador["entidad"],
														$this->_arPresentador["oficina"],date("dmy"));

			foreach($this->_arOrdenantes as $k=>$v)
			{
				$remesa.= $this->_generaOrdenante($v["nif"],$v["sufijo"],$v["nombre"],$v["entidad"],$v["oficina"],
														$v["dc"],$v["cuenta"],date("dmy"),date("dmy"),$k+1);
				foreach($this->_arIndividual[$k] as $r)
				{
					$remesa.= $this->_generaIndividual($v["nif"],$v["sufijo"],$r["ref"],$r["nombre"],$r["entidad"],
															$r["oficina"],$r["dc"],$r["cuenta"],$this->_convierteImporte($r["importe"]),$r["concepto"]);

					$this->_arOrdenantes[$k]["nRec"]++;
					$this->_arPresentador["nRec"]++;
					$this->_arOrdenantes[$k]["nReg"]++;
					$this->_arPresentador["nReg"]++;
					$this->_arOrdenantes[$k]["total"]+=$r["importe"];
					$this->_arPresentador["total"]+=$r["importe"];
				}
				$remesa.= $this->_generaTotalOrdenante($v["nif"],$v["sufijo"],$this->_convierteImporte($this->_arOrdenantes[$k]["total"]),$this->_arOrdenantes[$k]["nRec"],$this->_arOrdenantes[$k]["nReg"]);
				$this->_arPresentador["nOrd"]++;
			}
			$this->_arPresentador["nReg"]+=$this->_arPresentador["nOrd"]*2;

			$remesa.= $this->_generaTotalGeneral($this->_arPresentador["nif"],$this->_arPresentador["sufijo"],
														$this->_convierteImporte($this->_arPresentador["total"]),
														$this->_arPresentador["nOrd"],$this->_arPresentador["nRec"],
														$this->_arPresentador["nReg"]);

			return $remesa;
		}


		// Funciones privadas de la Clase

		function _generaTotalGeneral( $nif,$sufijo, $importe, $nOrd, $nRec, $nReg )
		{
			$texto = "5980";
			$texto.= $this->_rellenaIzquierda($nif," ",9);
			$texto.= $this->_rellenaIzquierda($sufijo,0,3);
			$texto.= $this->_rellenaIzquierda(""," ",12);
			$texto.= $this->_rellenaIzquierda(""," ",40);
			$texto.= $this->_rellenaIzquierda($nOrd,0,4);
			$texto.= $this->_rellenaIzquierda(""," ",16);
			$texto.= $this->_rellenaIzquierda($importe,0,10);
			$texto.= $this->_rellenaIzquierda(""," ",6);
			$texto.= $this->_rellenaIzquierda($nRec,0,10);
			$texto.= $this->_rellenaIzquierda($nReg,0,10);
			$texto.= $this->_rellenaIzquierda(""," ",20);
			$texto.= $this->_rellenaIzquierda(""," ",18);
			$texto.= "\r\n";

			return $texto;
		}

		function _generaTotalOrdenante( $nif,$sufijo, $importe, $nRec, $nReg )
		{
			$texto = "5880";
			$texto.= $this->_rellenaIzquierda($nif," ",9);
			$texto.= $this->_rellenaIzquierda($sufijo,0,3);
			$texto.= $this->_rellenaIzquierda(""," ",12);
			$texto.= $this->_rellenaIzquierda(""," ",40);
			$texto.= $this->_rellenaIzquierda(""," ",20);
			$texto.= $this->_rellenaIzquierda($importe,0,10);
			$texto.= $this->_rellenaIzquierda(""," ",6);
			$texto.= $this->_rellenaIzquierda($nRec,0,10);
			$texto.= $this->_rellenaIzquierda($nReg,0,10);
			$texto.= $this->_rellenaIzquierda(""," ",20);
			$texto.= $this->_rellenaIzquierda(""," ",18);
			$texto.= "\r\n";

			return $texto;
		}

		function _generaIndividual( $nif,$sufijo, $ref,$nombre,$entidad,$oficina,$dc,$cuenta,$importe,$concepto )
		{
			$texto = "5680";
			$texto.= $this->_rellenaIzquierda($nif," ",9);
			$texto.= $this->_rellenaIzquierda($sufijo,0,3);
			$texto.= $this->_rellenaIzquierda($ref,0,12);
			$texto.= $this->_rellenaDerecha  ($nombre," ",40);
			$texto.= $this->_rellenaIzquierda($entidad," ",4);
			$texto.= $this->_rellenaIzquierda($oficina," ",4);
			$texto.= $this->_rellenaIzquierda($dc,0,2);
			$texto.= $this->_rellenaIzquierda($cuenta,0,10);
			$texto.= $this->_rellenaIzquierda($importe,0,10);
			$texto.= $this->_rellenaIzquierda(""," ",16);
			$texto.= $this->_rellenaDerecha  ($concepto," ",40);
			$texto.= $this->_rellenaIzquierda(""," ",8);
			$texto.= "\r\n";

			return $texto;
		}

		function _generaPresentador( $nif,$sufijo,$nombre,$entidad,$oficina,$fecha )
		{
			$texto = "5180";
			$texto.= $this->_rellenaIzquierda($nif," ",9);
			$texto.= $this->_rellenaIzquierda($sufijo,0,3);
			$texto.= $this->_rellenaIzquierda($fecha," ",6);
			$texto.= $this->_rellenaIzquierda(""," ",6);
			$texto.= $this->_rellenaDerecha  ($nombre," ",40);
			$texto.= $this->_rellenaIzquierda(""," ",20);
			$texto.= $this->_rellenaIzquierda($entidad," ",4);
			$texto.= $this->_rellenaIzquierda($oficina," ",4);
			$texto.= $this->_rellenaIzquierda(""," ",12);
			$texto.= $this->_rellenaIzquierda(""," ",40);
			$texto.= $this->_rellenaIzquierda(""," ",14);
			$texto.= "\r\n";

			return $texto;
		}

		function _generaOrdenante( $nif,$sufijo,$nombre,$entidad,$oficina,$dc,$cuenta,$fecha,$fechaCargo,$procedimiento )
		{
			$texto = "5380";
			$texto.= $this->_rellenaIzquierda($nif," ",9);
			$texto.= $this->_rellenaIzquierda($sufijo,0,3);
			$texto.= $this->_rellenaIzquierda($fecha," ",6);
			$texto.= $this->_rellenaIzquierda($fechaCargo," ",6);
			$texto.= $this->_rellenaDerecha  ($nombre," ",40);
			$texto.= $this->_rellenaIzquierda($entidad," ",4);
			$texto.= $this->_rellenaIzquierda($oficina," ",4);
			$texto.= $this->_rellenaIzquierda($dc,0,2);
			$texto.= $this->_rellenaIzquierda($cuenta,0,10);
			$texto.= $this->_rellenaIzquierda(""," ",8);
			$texto.= $this->_rellenaIzquierda($procedimiento,0,2);
			$texto.= $this->_rellenaIzquierda(""," ",10);
			$texto.= $this->_rellenaIzquierda(""," ",40);
			$texto.= $this->_rellenaIzquierda(""," ",14);
			$texto.= "\r\n";

			return $texto;
		}

		function _convierteImporte($importe)
		{
			return number_format($importe,2,"","");
		}

		function _rellenaDerecha($texto,$caracter,$longitud,$cortar=true)
		{
			if ($cortar)
				$texto=substr($texto,0,$longitud);

			for($i=strlen($texto);$i<$longitud;$i++)
				$texto=$texto.$caracter;

			return $texto;
		}

		function _rellenaIzquierda($texto,$caracter,$longitud,$cortar=true)
		{
			if ($cortar)
				$texto=substr($texto,0,$longitud);

			for($i=strlen($texto);$i<$longitud;$i++)
				$texto=$caracter.$texto;

			return $texto;
		}
	}
?>