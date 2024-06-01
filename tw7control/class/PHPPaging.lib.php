<?php
class PHPPaging {


	var $mostrarResto = '{n}';
	/**
	*	Número de elementos por página
	*
	*	Valor por default: 5
	*
	*	Número de elementos que será mostrado por página. Puede ser definido en el script
	*	mediante la funcion porPagina()
	*
	*	<code>
	*	var $porPagina = 10;
	*	</code>
	*	@var int
	*/
	var $porPagina = 20;
	
	/**
	*	Número de páginas anteriores a la actual a las que se mostrará un link directo
	*
	*	Valor por default: 3
	*
	*	En barra de links, número de páginas anteriores a la actual a mostrar. Puede ser 
	*	definido en el script mediante la funcion paginasAntes()
	*
	*	<code>
	*	var $paginasAntes = 5;
	*	</code>
	*	@var int
	*/
	var $paginasAntes = 4;
	
	/**
	*	Número de páginas posteriores a la actual a las que se mostrará un link directo
	*
	*	Valor por default: 3
	*
	*	En barra de links, número de páginas posteriores a la actual a mostrar. Puede ser
	*	definido en el script mediante la funcion paginasDespues()
	*
	*	<code>
	*	var $paginasDespues = 5;
	*	</code>
	*	@var int
	*/
	var $paginasDespues = 4;
	
	/**
	*	Estilo para los links en barra de links
	*
	*	Valor por default: NULL
	*
	*	Estilo (clase) que se usará en la barra de links. Puede ser definido en el script 
	*	mediante la funcion linkClase()
	*
	*	<code>
	*	var $linkClase = "links_paging";
	*	</code>
	*	@var string
	*/
	var $linkClase;
	
	/**
	*	Separador para la barra de links
	*
	*	Valor por default: "&nbsp;"
	*
	*	Separador que se usara en la barra de links, entre página y página. 
	*	Puede ser definido en el script mediante la funcion linkSeparador()
	*
	*	<code>
	*	var $linkSeparador = " | ";
	*	</code>
	*	@var string
	*/
	var $linkSeparador = "&nbsp;";
	
	/**
	*	Separador "especial" para la barra de links
	*
	*	Valor por default: "&nbsp;"
	*
	*	Separador que se usara en la barra de links, cuando se ha definido
	* 	un salto de páginas
	*
	*	<code>
	*	var $linkSeparador = " - ";
	*	</code>
	*	@var string
	* 	@version 2.0
	*/
	var $linkSeparadorEspecial = "&nbsp;";
	
	/**
	*	Cadena que se agregará al final de cada link
	*
	*	Valor por default: NULL
	*
	*	Añadido que será agregado al final de cada link. Puede ser definido en el
	*	script mediante la funcion linkAgregar()
	*
	*	<code>
	*	var $linkAgregar = "#resultados";
	*	</code>
	*
	*	@var string
	**/
	var $linkAgregar;
	
	/**
	*	Mensaje para el atributo <i>title</i> de los links
	*
	*	Valor por default: Según el tipo de link
	*
	*	Mensaje a mostrar cuando el mouse es colocado sobre los links. Puede ser definido
	*	en el script mediante la funcion linkTitulo(). El mensaje debe estar en formato: 
	*	XXXX %1$s XXXX %2$s XXXX %3$s XXXX %4$s XXXX. Los caracteres %n$s seran reemplazados 
	*   según el número por:
	*		- %1$s = Número de página
	*		- %2$s = Primer resultado mostrado
	*		- %3$s = Último Resultado mostrado
	*		- %4$s = Total de resultados de la BD
	*
	*	<code>
	*	var $linkTitulo = "Resultados del %2\$s al %3\$s de %4\$s encontrados (Página %1\$s)";
	*	</code>
	*	Podria ser reemplazado por:
	*	"Resultados del 13 al 18 de 127 encontrados (Página 3)"
	*	@var string
	**/
	var $linkTitulo = true;
	
	/**
	*	Cadena que se mostrará en el link hacia la PRIMERA página
	*
	*	Valor por default: "&laquo; Primera"
	*
	*	Cadena de texto que se mostrará en el enlace hacia la primera página.
	*
	*	<code>
	*	var $mostrarPrimera = "- Ir a la primera página";
	*	</code>
	*	@var string
	**/
	var $mostrarPrimera = "|<";
	
	/**
	*	Cadena que se mostrará en el link hacia la ÚLTIMA página
	*
	*	Valor por default: "Última &raquo;"
	*
	*	Cadena de texto que se mostrará en el enlace hacia la última página.
	*
	*	<code>
	*	var $mostrarPrimera = "Ir a la última página -";
	*	</code>
	*	@var string
	**/
	var $mostrarUltima = ">|";
	
	/**
	*	Cadena que se mostrará en el link hacia la página ANTERIOR
	*
	*	Valor por default: "&lt; Anterior"
	*
	*	Cadena de texto que se mostrará en el enlace hacia la página anterior
	*
	*	<code>
	*	var $mostrarAnterior = "Anterior";
	*	</code>
	*	@var string
	**/
	var $mostrarAnterior = "<";
	
	/**
	*	Cadena que se mostrará en el link hacia la página SIGUIENTE
	*
	*	Valor por default: "Siguiente &gt;"
	*
	*	Cadena de texto que se mostrará en el enlace hacia la página siguiente
	*
	*	<code>
	*	var $mostrarSiguiente = "Siguiente";
	*	</code>
	*	@var string
	**/
	var $mostrarSiguiente = ">";
	
	/**
	*	Cadena que se mostrará en el link hacia las páginas accesibles en barra de links
	*
	*	Valor por default: "{n}"
	*
	*	Cadena de texto que se mostrará para indicar las páginas a las que se puede
	*	acceder desde la barra de links, y que SÍ SERÁN LINKS. El lugar donde se desea 
	*	que vaya el número de página se debe indicar por medio del caracter {n}.
	*
	*	<code>
	*	var $mostrarAdyacentes = "Ir a la p. {n}";
	*	</code>
	*	@var string
	**/
	var $mostrarAdyacentes = "{n}";
	
	/**
	*	Cadena que se mostrará en vez del link hacia la página ACTUAL
	*
	*	Valor por default: "{n}"
	*
	*	Cadena de texto que se mostrará para indicar la página actual, que estará en 
	*	la barra de links, pero NO SERÁ UN LINK. El lugar donde se desea que vaya el
	*	número de página se debe indicar por medio del caracter {n}.
	*
	*	<code>
	*	var $mostrarActual = "Página <b>{n}</b>";
	*	</code>
	*	@var string
	**/
	var $mostrarActual = "<span class=\"navthis\">{n}</span>";
	
	/**
	*	Nombre de variable en la url
	*
	*	Valor por default: "page"
	*
	*	Cadena de texto que representará el nombre de la variable que define
	*   el número de página en la url
	*
	*	<code>
	*	var $nombreVariable = "p";
	*	</code>
	*	@var string
	**/
	var $nombreVariable = "pagina";
	
	/**
	*	Estrutura del link generado
	*
	*	Valor por default: NULL
	*
	*	Se puede definir una estrutura personalizada para generar los links en
	*   la barra de navegaci&oacute;n. Esto es especialmente útil cuando se usa "URLs
	* 	amigables". Si no se define, el número de página se propaga por la URL
	* 	de esta forma: pagina.php?page=4. En la estructura que usted coloque
	* 	el lugar donde debe ponerse el número de página debe ir indicado como
	* 	%1$s
	*
	*	<code>
	* 	// La barra invertida es para escapar el caracter $
	*	var $nombreVariable = "http://sitio/contenido/pagina/%1\$s"; 
	*	</code>
	*	@var string
	* 	@version 2.0
	**/
	var $linkEstructura;
	
	/**
	*	Variables de la URL que se desea mantener
	*
	*	Valor por default: NULL
	*
	*	Especifique cuáles de las variables definidas en la URL desea propagar
	* 	y mantener en los links de la barra de navegaci&oacute;n. La variable que 
	* 	propaga el número de página es incluída siempre automáticamente. Esta 
	* 	opci&oacute;n s&oacute;lo funciona si NO se ha establecido una estructura personalizada
	* 	para la URL
	*
	*	<code>
	* 	var $mantenerURLVar = array('page', 'id'); 
	*	</code>
	*	@var string
	* 	@version 2.0
	**/
	var $mantenerURLVar = array();
	
	/**
	*	Variables de la URL que se NO desea mantener
	*
	*	Valor por default: NULL
	*
	*	Especifique cuáles de las variables definidas en la URL no desea propagar
	* 	ni mantener en los links de la barra de navegaci&oacute;n. La variable que 
	* 	propaga el número de página siempre se incluye en la URL
	* 	automáticamente. Esta opci&oacute;n s&oacute;lo funciona si NO se ha establecido una 
	* 	estructura personalizada para la URL
	*
	*	<code>
	* 	var $mantenerURLVar = array('page', 'id'); 
	*	</code>
	*	@var string
	* 	@version 2.0
	**/
	var $quitarURLVar = array();

	/**
	*	Modo de ejecuci&oacute;n del script
	*
	*	Valor por default: 'reporte'
	*
	*	Indica el modo de ejecuci&oacute;n del script. 
	*
	*	<code>
	* 	var $modo = 'publicacion'; 
	*	</code>
	*	@var string
	* 	@version 2.0
	**/
	var $modo = 'reporte';
	
	
	
	/**
	*******************************************************
	*******************************************************
	***													***
	***		VARIABLES DE USO INTERNO. NO MODIFICAR!		***
	***													***
	*******************************************************
	*******************************************************
	**/
	/**
	*	@access private
	*/
	var $estilo;
	/**
	*	@access private
	*/
	var $numTotalPaginas;
	/**
	*	@access private
	*/
	var $numEstaPagina;
	/**
	*	@access private
	*/
	var $numPrimerRegistro;
	/**
	*	@access private
	*/
	var $numUltimoRegistro;
	/**
	*	@access private
	*/
	var $numTotalRegistros;
	/**
	*	@access private
	*/
	var $numTotalRegistros_actual;
	/**
	*	@access private
	*/
	var $data = false;
	/**
	*	@access private
	*/
	var $ejecutard = array();
	/**
	*	@access private
	*/
	var $sql = false;
	/**
	*	@access private
	*/
	var $conn;
	/**
	*	@access private
	*/
	var $done;
	/**
	*	@access private
	* 	@version 2.0
	*/
	var $error = null;
	/**
	*	@access private
	* 	@version 2.0
	*/
	var $mostre_error = false;
	/**
	*	@access private
	* 	@version 2.0
	*/
	var $paginasAntesEspecial = array();
	/**
	*	@access private
	* 	@version 2.0
	*/
	var $paginasDespuesEspecial = array();
	/**
	*	@access private
	* 	@version 2.0
	*/
	var $verPost = array();
	

	var $pagina_proceso;
	
	
	/**
	  ***********************************************************************
	  *																		*
	  *		FUNCIONES QUE ESTABLECEN LOS CRITERIOS PARA LA PAGINACION		*
	  *																		*
	  ***********************************************************************
	**/
	
	/**
	*	@access private
	*/
	function __construct ($conn = null)
  {
		//$this->conn = $conn;
		$bd = new BD();
		if($bd->status==BD::CERRADA) $bd->open();
		$this->conn = $bd->cn;
	}
	
	/**
	*	Array con datos para paginar
	*
	*	Define los datos para paginar
	*	@param array $input Array que contiene los datos a paginar
	*	@returns void
	* 	@version 2.0
	**/
	function modo($modo) {
		$modos = array('publicacion', 'reporte', 'desarrollo');
		$modo = trim($modo);
		$modo = strtolower($modo);
		if(in_array($modo, $modos)) $this->modo = $modo;
		else return $this->error(true, "No se pudo cambiar el modo de ejecuci&oacute;n pues ingres&oacute; uno que no existe o que es inválido.");
		return true;
	}
	
	/**
	*	Activar recepci&oacute;n de datos POST
	*
	*	Activar o desactivar la recepci&oacute;n de datos por POST
	*	@param array $boolean Array que contiene los datos a paginar
	*	@returns void
	* 	@version 2.0
	**/
	function verPost($boolean = true) {
		$this->verPost = $boolean == true;
		return true;
	}
	
	/**
	*	Array con datos para paginar
	*
	*	Define los datos para paginar
	*	@param array $input Array que contiene los datos a paginar
	*	@returns void
	**/
	function agregarArray ($input) {
		if (!is_array($input)) return $this->error(true, "El arreglo de datos ingresado no es válido. Recuerde que debe indicar una variable de tipo array.");
		$this->data = (array)$input;
		return true;
	}
	
	/**
	*	Consulta SQL para obtener los datos para el paginado. La consulta no deberá especificar l&iacute;mites
    * 	pues de eso se encargará el script	
	*
	*	Define una consulta SQL en base a la cual se realizará el paginado
	*	@param string $sql Una consulta SQL estandar. La consulta no debe terminar con punto y coma. 	
	*	@returns bool
	**/
	function agregarConsulta ($sql) {
		if (empty($sql)) return $this->error(true, "La consulta SQL que está indicando está vac&iacute;a.");
		$this->sql = $sql;
		return true;
	}
	
	/**
	*	Número de elementos por página
	*
	*	Define el número de registros que serán mostrados en cada página
	*	@param number $num Número de registros por página que se usará
	*	@returns bool
	**/
	function porPagina ($num) {
		if (is_numeric($num) and $num >= 1 and $num !== true) $this->porPagina = intval($num);
		else return $this->error(true, "El número de elementos por página indicado es inválido. S&oacute;lo puede poner números enteros mayores o iguales a 1.");
		return true;
	}
	
	/**
	*	Nombre de variable en la URL
	*
	*	Define el nombre de la variable de url que indicará el número de página
	*	@param string $var Nombre de la variable de url
	*	@returns bool
	**/
	function nombreVariable ($var) {
		if(!is_string($var) or empty($var)) return $this->error(true, "El nombre de variable indicado está vac&iacute;o o es inválido.");
		if(!preg_match("/(^[a-zA-Z0-9]+)$/",$var)) return $this->error(true, "El nombre de la variable indicado contiene caracteres no válidos");
		$this->nombreVariable = (string)$var; 
		return true;
	}
	
	/**
	*	Número de páginas anteriores a la actual a las que se mostrará un link directo
	*
	*	Define el número de links a páginas anteriores a la actual que serán mostrados en
	*	la barra de links
	*	@param number $num Número de páginas anteriores a la actual
	*	@returns bool
	**/
	function paginasAntes () { // Funci&oacute;n modificada version 2.0
		$n = func_get_args();
		$num = array_shift($n);
		if (is_numeric($num) and $num >= 1 and $num !== true) $this->paginasAntes = intval($num);
		elseif($num === false or $num === '' or $num === 0 or $num === '0' or $num === null) $this->paginasAntes = false; // version 2.0
		else return $this->error(true, "El número indicado en el método paginasAntes() es inválido");
		if(count($n) > 0) {
			foreach($n as $numero) {
				if(is_numeric($numero) and $numero > 0) $this->paginasAntesEspecial[] = intval($numero);
				elseif($this->modo == 'desarrollo') return $this->error(true, "Los parámetros del método paginasAntes() deben ser todos números");
			}
		}
		return true;
	}
	
	/**
	*	Número de páginas posteriores a la actual a las que se mostrará un link directo
	*
	*	Define el número de links a páginas posteriores a la actual que serán mostrados en
	*	la barra de links
	*	@param number $num Número de páginas posteriores a la actual
	*	@returns bool
	**/
	function paginasDespues () { // Funci&oacute;n modificada version 2.0
		$n = func_get_args();
		$num = array_shift($n);
		if (is_numeric($num) and $num >= 1 and $num !== true) $this->paginasDespues = intval($num);
		elseif($num === false or $num === '' or $num === 0 or $num === '0' or $num === null) $this->paginasDespues = false; // version 2.0
		else return $this->error(true, "El número indicado en el método paginasDespues() es inválido");
		if(count($n) > 0) {
			foreach($n as $numero) {
				if(is_numeric($numero) and $numero > 0) $this->paginasDespuesEspecial[] = intval($numero);
				elseif($this->modo == 'desarrollo') return $this->error(true, "Los parámetros del método paginasDespues() deben ser todos números");
			}
		}
		return true;
	}
  
	/**
	*	Separador para la barra de links
	*
	*	Define el separador que se usará entre cada link en la barra de links
	*	@param string $separador Separador entre links
	*	@returns void
	**/
	function linkSeparador ($separador = '', $convertir = false) {
		if($separador === false or $separador === null or $separador === '') $this->linkSeparador = '';
		if($separador === true) $this->linkSeparador = 1;
		if($separador === 0 or $separador === '0') $this->linkSeparador = (string)'0'; // Arreglado v2.1 (Gracias a Cuauhtémoc)
		else $this->linkSeparador = ($convertir == true) ? htmlentities((string)$separador, ENT_QUOTES) : (string)$separador;
	}
  
	/**
	*	Separador "especial"para la barra de links
	*
	*	Define el separador que se usará entre los links "especiales" de la
	* 	barra de navegaci&oacute;n
	*	@param string $separador Separador
	*	@returns void
	* 	@version 2.0
	**/
	function linkSeparadorEspecial ($separador = '', $convertir = false) {
		if($separador === false) $this->linkSeparadorEspecial = false;
		if($separador === true) $this->linkSeparadorEspecial = 1;
		if($separador === 0 or $separador === '0') $this->linkSeparadorEspecial = (string)'0';
		else $this->linkSeparadorEspecial = ($convertir == true) ? htmlentities((string)$separador, ENT_QUOTES) : (string)$separador;
	}
  
	/**
	*	Cadena que se mostrará en el link hacia la PRIMERA página
	*
	*	Define la cadena que será mostrada en el enlace hacia la primera página
	*	@param string $str Cadena a mostrar
	*	@returns void
	**/
	function mostrarPrimera ($str, $convertir = false) {
		if($str === false or $str === null or $str === '') $this->mostrarPrimera = false;
		elseif($str === 0 or $str === '0') $this->mostrarPrimera = '0';
		elseif(!empty($str) and $str !== true) $this->mostrarPrimera = ($convertir == true) ? htmlentities((string)$str, ENT_QUOTES) : (string)$str;
		else return $this->error(true, "El valor indicado en el método mostrarPrimera() es inválido");
		return true;
	}
  
	/**
	*	Cadena que se mostrará en el link hacia la ÚLTIMA página
	*
	*	Define la cadena que será mostrada en el enlace hacia la última página
	*	@param string $str Cadena a mostrar
	*	@returns void
	**/
	function mostrarUltima ($str, $convertir = false) {
		if($str === false or $str === null or $str === '') $this->mostrarUltima = false;
		elseif($str === 0 or $str === '0') $this->mostrarUltima = '0';
		elseif(!empty($str) and $str !== true) $this->mostrarUltima = ($convertir == true) ? htmlentities((string)$str, ENT_QUOTES) : (string)$str;
		else return $this->error(true, "El valor indicado en el método mostrarUltima() es inválido");
		return true;
	}
  
	/**
	*	Cadena que se mostrará en el link hacia la página ANTERIOR
	*
	*	Define la cadena que será mostrada en el enlace hacia la página anterior
	*	@param string $str Cadena a mostrar
	*	@returns void
	**/
	function mostrarAnterior ($str, $convertir = false) {
		if($str === false or $str === null or $str === '') $this->mostrarAnterior = false;
		elseif($str === 0 or $str === '0') $this->mostrarAnterior = '0';
		elseif(!empty($str) and $str !== true) $this->mostrarAnterior = ($convertir == true) ? htmlentities((string)$str, ENT_QUOTES) : (string)$str;
		else return $this->error(true, "El valor indicado en el método mostrarAnterior() es inválido");
		return true;
	}
  
	/**
	*	Cadena que se mostrará en el link hacia la página SIGUIENTE
	*
	*	Define la cadena que será mostrada en el enlace hacia la página siguiente
	*	@param string $str Cadena a mostrar
	*	@returns void
	**/
	function mostrarSiguiente ($str, $convertir = false) {
		if($str === false or $str === null or $str === '') $this->mostrarSiguiente = false;
		elseif($str === 0 or $str === '0') $this->mostrarSiguiente = '0';
		elseif(!empty($str) and $str !== true) $this->mostrarSiguiente = ($convertir == true) ? htmlentities((string)$str, ENT_QUOTES) : (string)$str;
		else return $this->error(true, "El valor indicado en el método mostrarSiguiente() es inválido");
		return true;
	}
  
	/**
	*	Cadena que se mostrará en el link hacia las páginas accesibles en barra de links
	*
	*	Define la cadena que será mostrada en el enlace hacia las páginas accesibles 
	*	desde la barra de links. El número de página deberá ser indicado como {n}
	*	@param string $str Cadena a mostrar
	*	@returns void
	* 	@version 2.0
	**/
	function mostrarAdyacentes ($str, $convertir = false) {
		if($str === 0 or $str === '0') $this->mostrarAdyacentes = '0';
		elseif(!empty($str) and $str !== true) $this->mostrarAdyacentes = ($convertir == true) ? htmlentities((string)$str, ENT_QUOTES) : (string)$str;
		else return $this->error(true, "El valor indicado en el método mostrarAdyacentes() es inválido");
		return true;
	}
  
	/**
	*	Alias de mostrarAdyacente(), obsoleto desde la version 2.0
	**/
	function mostrarIntermedias ($str, $convertir = false) {
		return $this->mostrarAdyacentes($str, $convertir);
	}
  
	/**
	*	Cadena que se mostrará en vez del link hacia la página ACTUAL
	*
	*	Define la cadena que será mostrada como página actual en la barra de links. El 
	*	número de página (Página actual) deberá ser indicado como {n}
	*	@param string $str Cadena a mostrar
	*	@returns void
	**/
	function mostrarActual ($str, $convertir = false) {
		if($str === false or $str === null or $str === '') $this->mostrarActual = false;
		elseif($str === 0 or $str === '0') $this->mostrarActual = (string)'0';
		elseif(!empty($str) and $str !== true) $this->mostrarActual = ($convertir == true) ? htmlentities((string)$str, ENT_QUOTES) : (string)$str;
		else return $this->error(true, "El valor indicado en el método mostrarActual() es inválido");
		return true;
	}
	
	/**
	*	Cadena que se agregará al final de cada link
	*
	*	Agrega una cadena "addon" al final de cada link en la barra de links
	*	@param string $gr Cadena que será añadida
	*	@returns void
	**/
	function linkAgregar ($agr) {
		if(empty($agr)) return $this->error(true, "El valor indicado en el método linkClase() está vac&iacute;o");
		$this->linkAgregar = $agr;
		return true;
	}

	/* hector2c: toda esta funcion obteiene el div a mostrar*/
	function div($div) {
		if(empty($div)) return $this->error(true, "El valor indicado en el método linkClase() está vac&iacute;o");
		$this->div = $div;
		return true;
	}


	/**
	*	Estilo para los links en barra de links
	*
	*	Define la clase CSS que será aplicada a los links de la barra de links
	*	@param string $id Clase CSS a aplicar
	*	@returns void
	**/
	function linkClase ($id) {
		if(empty($id)) return $this->error(true, "El valor indicado en el método linkClase() está vac&iacute;o");
		if(!preg_match("/(^[a-zA-Z0-9_ ]+)$/",$id) or $id === true) return $this->error(true, "El nombre indicado en el método linkClase() es inválido");
		$this->linkClase = $id;
		return true;
	}
	
	/**
	*	Mensaje para el atributo <i>title</i> de los links en barra de links
	*
	*	Define un mensaje para el atributo 'title' de los links de la barra de links. El 
	*	mensaje debe ser en formato: XXXX %1$s XXXX %2$s XXXX %3$s XXXX %4$s XXXX. 
	*   Los caracteres %n$s seran reemplazados en orden según el número por:
	*		- %1$s = Número de página
	*		- %2$s = Primer resultado mostrado
	*		- %3$s = Último Resultado mostrado
	*		- %4$s = Total de resultados de la BD
	*		- %5$s = Número total de páginas // version 2.0
	*	@param string $msg Mensaje que será inclu&iacute;do en los links
	*	@returns void
	**/
	function linkTitulo ($str, $convertir = true) {
		if($str === true) $this->linkTitulo = true;
		elseif($str === false or $str === null or $str === '') $this->linkTitulo = false;
		elseif($str === 0 or $str === '0') $this->linkTitulo = (string)'0';
		elseif(!empty($str)) $this->linkTitulo = ($convertir == true) ? htmlentities((string)$str, ENT_QUOTES) : (string)$str;
		else return $this->error(true, "El valor indicado en el método linkTitulo() está vac&iacute;o");
		return true;
	}
	
	/**
	*	Estructura de los links en la barra de navegaci&oacute;n
	*
	*	Define una estructura para los links en la barra de navegaci&oacute;n, que reemplazará
	* 	a la estructura predefinida. Esto es útil si se usa el Mod Rewrite para reescribir
	* 	las URLs en una forma "amigable". El lugar donde debe ir el número de página debe ser
	* 	indicado como %1$s dentro de la estructura
	*	@param string $estructura Estructura de los links
	*	@returns void
	* 	@version 2.0
	**/
	function linkEstructura ($estructura) {
		if($estructura === 0 or $estructura === '0') $this->linkEstructura = (string)'0';
		elseif($estructura === false) $this->linkEstructura = false;
		elseif(!empty($estructura) and $estructura !== true) $this->linkEstructura = (string)$estructura;
		else return $this->error(true, "El valor indicado en el método linkEstructura() está vac&iacute;o");
		return true;
	}
	
	/**
	*	Variables que se desea mantener en la URL de los links en la barra de navegaci&oacute;n
	*
	*	Indique qué variables desea mantener en la URL al momento de generar los links para
	* 	la barra de navegaci&oacute;n. La variable que propaga el número de página es incluida siempre y 
	* 	automáticamente. Esta funci&oacute;n s&oacute;lo funcionará si no se ha definido una estructura para los
	* 	links (linkEstructura()) ni se ha hecho uso de la funci&oacute;n (quitarVar()).
	*	@param string $str[, $str[, ...]] Nombres de las variables que se desea mantener
	*	@returns void
	* 	@version 2.0
	**/
	function mantenerVar ($args) {
		//$args = func_get_args();
		 return $this->mantenerURLVar=$args;
		//return $this->mantenerURLVar = array_merge($this->mantenerURLVar, $args);
	}
	
	/**
	*	Variables que se desea quitar de la URL de los links en la barra de navegaci&oacute;n
	*
	*	Indique qué variables desea quitar de la URL al momento de generar los links para
	* 	la barra de navegaci&oacute;n. La variable que propaga el número de página no puede ser quitada,
	* 	y se propaga siempre. Esta funci&oacute;n s&oacute;lo funcionará si no se ha definido una estructura para 
	* 	los links (linkEstructura()) ni se ha hecho uso de la funci&oacute;n (mantenerVar()).
	*	@param string $str[, $str[, ...]] Nombres de las variables que se desea quitar
	*	@returns void
	* 	@version 2.0
	**/
	function quitarVar () {
		$args = func_get_args();
		return $this->quitarURLVar = array_merge($this->quitarURLVar, $args);
	}
	
	/**
	  *******************************************************************
	  *																	*
	  *		FUNCIONES QUE DEVUELVEN VALORES RELATIVOS AL PAGINADO		*
	  *																	*
	  *******************************************************************
	**/
	
	/**
	*	Número total de páginas
	*
	*	Devuelve el número total de páginas
	*	@returns int
	**/
	function numTotalPaginas () {
		if($this->done != true) return $this->error(true, "No se puede mostrar el número total de páginas pues no se ha realizado ninguna paginaci&oacute;n");
		return $this->numTotalPaginas;
	}
	
	/**
	*	Número de página actual
	*
	*	Devuelve el número de página actual
	*	@returns int
	**/
	function numEstaPagina () {
		if($this->done != true) return $this->error(true, "No se puede mostrar el número de página actual pues no se ha realizado ninguna paginaci&oacute;n");
		return $this->numEstaPagina;
	}
	
	/**
	*	Número de primer registro mostrado
	*
	*	Devuelve el número del primer registro mostrado, en relaci&oacute;n al total de registros
	*	@returns int
	**/
	function numPrimerRegistro () {
		if($this->done != true) return $this->error(true, "No se puede mostrar el número del primer registro mostrado pues no se ha realizado ninguna paginaci&oacute;n");
		return $this->numPrimerRegistro;
	}
	
	/**
	*	Número de último registro mostrado
	*
	*	Devuelve el número del último registro mostrado, en relaci&oacute;n al total de registros
	*	@returns int
	**/
	function numUltimoRegistro () {
		if($this->done != true) return $this->error(true, "No se puede mostrar el número del último registro mostrado pues no se ha realizado ninguna paginaci&oacute;n");
		return $this->numUltimoRegistro;
	}
	
	/**
	*	Número de total registros
	*
	*	Devuelve el número total de registros encontrados
	*	@returns int
	**/
	function numTotalRegistros () {
		if($this->done != true) return $this->error(true, "No se puede generar la barra de navegaci&oacute;n pues no se ha realizado ninguna paginaci&oacute;n");
		return $this->numTotalRegistros;
	}
	
	/**
	*	Número de registros mostrados en esta página
	*
	*	Devuelve el número de registros mostrados en la página actual
	*	@returns int
	**/
	function numRegistrosMostrados () {
		if($this->done != true) return $this->error(true, "No se puede obtener el número de registros mostrados en la página actual pues no se ha realizado ninguna paginaci&oacute;n");
		return $this->numTotalRegistros_actual;
	}
	
	/**
	*	Obtener los valores de configuraci&oacute;n
	*
	*	Devuelve un array con los valores de configuraci&oacute;n
	*	@returns void
	**/
	function superArray () {
		if($this->done != true) return $this->error(true, "No se puede mostrar la informaci&oacute;n de la paginaci&oacute;n pues no se ha realizado ninguna paginaci&oacute;n");
		return array("numPrimerRegistro"=>$this->numPrimerRegistro, "numUltimoRegistro"=>$this->numUltimoRegistro, "numTotalRegistros"=>$this->numTotalRegistros, "porPagina"=>$this->porPagina, "numRegistrosMostrados"=>$this->numTotalRegistros_actual, "nombreVariable"=>$this->nombreVariable, "linkAgregar"=>$this->linkAgregar, "linkClase"=>$this->linkClase, "linkSeparador"=>$this->linkSeparador, "linkSeparadorEspecial"=>$this->linkSeparadorEspecial, "numEstaPagina"=>$this->numEstaPagina, "numTotalPaginas"=>$this->numTotalPaginas, "paginasAntes"=>$this->paginasAntes, "paginasDespues"=>$this->paginasDespues, "mostrarPrimera"=>$this->mostrarPrimera, "mostrarUltima"=>$this->mostrarUltima, "mostrarAnterior"=>$this->mostrarAnterior, "mostrarSiguiente"=>$this->mostrarSiguiente, "mostrarAdyacentes"=>$this->mostrarAdyacentes, "mostrarActual"=>$this->mostrarActual, "linkEstructura"=>$this->linkEstructura);
	}
	
	/**
	*	Obtener los registros a mostrar
	*
	*	Devuelve un array con los registros seleccionados para mostrar
	*	@returns array
	**/
	function fetchResultado () {
		if($this->done != true) return $this->error(false, "No se puede mostrar los resultados porque no se ha realizado la paginaci&oacute;n.");
		if(is_array($this->ejecutard)) {
			if(list($key, $row) = each($this->ejecutard)) return $row;
		} elseif($row = @mysqli_fetch_array($this->ejecutard)) {
			return $row;
		}
		else return false;
	}
	
	function fetchTodo () {
		if($this->done != true) return $this->error(false, "No se puede mostrar los resultados porque no se ha realizado la paginaci&oacute;n.");
		if(is_array($this->ejecutard))
			return (count($this->ejecutard) > 0) ? $this->ejecutard : null;		
		$r = array();
		while($f = $this->fetchResultado()) {
			$r[] = $f;
		}
		return (count($r) > 0) ? $r : null; 
	}
	
	/**
	*	Obtener barra de links
	*
	*	Devuelve una cadena conteniendo la barra de links en formato HTML
	*	@returns string
	**/
	function fetchNavegacion () {
		if($this->done != true) return $this->error(false, "No se puede generar la barra de navegaci&oacute;n pues no se ha realizado ninguna paginaci&oacute;n"); // version 2.0
		if(empty($this->linkEstructura)) {
			$i = array();
			if(count($this->mantenerURLVar) > 0) define ('MANTENERURLVARS',1); // version 2.0
			elseif(count($this->quitarURLVar) > 0) define ('QUITARURLVARS',1); // version 2.0
			$vars = $_GET;
			if($this->verPost == true) $vars = array_merge($vars, $_POST); // version 2.0
			foreach($vars as $key=>$val) {
				if($key != $this->nombreVariable) {
					if(defined('MANTENERURLVARS') and !in_array($key, $this->mantenerURLVar) or defined('QUITARURLVARS') and in_array($key, $this->quitarURLVar)) continue;
					$i[] = "$key".(empty($val) ? '' : "=".urlencode($val)); // Modificado version 2.0
				}
			}
			$i[] = $this->nombreVariable.'={n}';
			$this->query_string = implode('&amp;',$i); // Modificado version 2.0
			
			//$this->linkEstructura = 'http://'.trim($_SERVER['HTTP_HOST'], '/').'/'.ltrim($_SERVER['PHP_SELF'], '/').'?'.$this->query_string;
			//if($this->pagina_proceso=="") $this->pagina_proceso=$_SERVER['PHP_SELF'];
			$this->linkEstructura = ltrim($this->pagina_proceso, '/').'?'.$this->query_string;
			
		}
		//hector2c
		//$this->estilo = (!empty($this->linkClase)) ? ' class="'.$this->linkClase.'"' : NULL;
		$this->estilo = ' class="nav"';
		$before = $this->paginasAntes;
		$after = $this->paginasDespues;
		$pthis = $this->numEstaPagina;
		$ptotal = $this->numTotalPaginas;
		$before = (($pthis - $before) < 1) ? 1 : ($pthis - $before);
		$after = (($pthis + $after) > $ptotal) ? $ptotal : ($pthis + $after);
		$link_string1 = array(); // version 2.0
		$link_string2 = array(); // version 2.0
		$link_string3 = array(); // version 2.0
		$link_string4 = array(); // version 2.0
		$link_string5 = array(); // version 2.0
		if($this->mostrarPrimera !== false and $pthis > $this->paginasAntes+1) { // Modificado version 2.0
			$link_string1[] = $this->do_link(1,$this->addlinkmsg(1,1,$this->porPagina,1),$this->mostrarPrimera);
		}
		if($this->mostrarAnterior !== false and $pthis > 1) { // Modificado version 2.0
			$link_string1[] = $this->do_link(($pthis-1),$this->addlinkmsg(($pthis-1),(($this->porPagina*($pthis-2))+1),($this->porPagina*($pthis-1)),2),$this->mostrarAnterior);
		}
		if(count($this->paginasAntesEspecial) > 0) { // version 2.0
			$this->paginasAntesEspecial = array_unique($this->paginasAntesEspecial);
			rsort($this->paginasAntesEspecial);
			foreach($this->paginasAntesEspecial as $n) {
				$page = $before-$n;
				if($page < 1 or $page == 1 and $this->mostrarPrimera !== false) continue;
				$link_string2[] = $this->do_link($page,$this->addlinkmsg($page,(($this->porPagina*($page-1))+1),($this->porPagina*$page),3),str_replace("{n}", $page, $this->mostrarAdyacentes));
			}
		}
		$i = 0;
		while($before <= $after) { // Ciclo modificado version 2.0
			if($this->mostrarAdyacentes !== false and $pthis <> $before) {
				$link_string3[] = $this->do_link($before,$this->addlinkmsg($before,(($this->porPagina*($before-1))+1),($this->porPagina*($before)),3),str_replace("{n}", $before, $this->mostrarAdyacentes));
			} elseif($this->mostrarActual != false and $pthis == $before) {
				$link_string3[] = str_replace("{n}", $before, $this->mostrarActual);
			}
			$before++;
		}
		if(count($this->paginasDespuesEspecial) > 0) { // version 2.0
			$this->paginasDespuesEspecial = array_unique($this->paginasDespuesEspecial);
			sort($this->paginasDespuesEspecial);
			foreach($this->paginasDespuesEspecial as $n) {
				$page = $after+$n;
				if($page > $ptotal or $page == $ptotal and $this->mostrarUltima !== false) continue;
				$link_string4[] = $this->do_link($page,$this->addlinkmsg($page,(($this->porPagina*($page-1))+1),($this->porPagina*$page),3),str_replace("{n}", $page, $this->mostrarAdyacentes));
			}
		}
		if($this->mostrarSiguiente !== false and $pthis < $ptotal) { // Modificado version 2.0
			$link_string5[] = $this->do_link($pthis+1,$this->addlinkmsg(($pthis+1),(($this->porPagina*$pthis)+1),($this->porPagina*($pthis+1)),4),$this->mostrarSiguiente);
		}
		if($this->mostrarUltima !== false and $pthis < ($ptotal-$this->paginasDespues)) { // Modificado version 2.0
			$link_string5[] = $this->do_link($ptotal,$this->addlinkmsg($ptotal,(($this->porPagina*($ptotal-1))+1),$this->numTotalRegistros,5),$this->mostrarUltima);
		}
		$link_string = null;
		if(!empty($link_string1)) $link_string .= implode($this->linkSeparador,$link_string1).$this->linkSeparador;
		if(!empty($link_string2)) $link_string .= implode($this->linkSeparadorEspecial,$link_string2).$this->linkSeparadorEspecial;
		if(!empty($link_string3)) $link_string .= implode($this->linkSeparador,$link_string3);
		if(!empty($link_string4)) $link_string .= $this->linkSeparadorEspecial.implode($this->linkSeparadorEspecial,$link_string4);
		if(!empty($link_string5)) $link_string .= $this->linkSeparador.implode($this->linkSeparador,$link_string5);
		
		return $link_string;
	}

	/**
	*******************************************************
	*******************************************************
	***													***
	***		FUNCIONES DE USO INTERNO. NO MODIFICAR!		***
	***													***
	*******************************************************
	*******************************************************
	**/
	/**
	*	@access private
	*/
	function addlinkmsg ($tp,$rs,$rt,$type = null) {
		$total = $this->numTotalRegistros;
		$rt = ($rt > $total) ? $total : $rt;
		if($this->linkTitulo === true) {
			switch($type) {
				case 1: return "Primera p&aacute;gina. Resultados del $rs al $rt de $total"; break;
				case 2: return "P&aacute;gina anterior: Resultados del $rs al $rt de $total"; break;
				case 3: return "P&aacute;gina $tp: Resultados del $rs al $rt de $total"; break; // Corregido version 2.0
				case 4: return "P&aacute;gina siguiente. Resultados del $rs al $rt de $total"; break;
				case 5: return "&Uacute;ltima p&aacute;gina. Resultados del $rs al $rt de $total"; break;
				default: return $this->addlinkmsg($tp,$rs,$rt,3);
			}
		} elseif($this->linkTitulo === false or $this->linkTitulo === '' or $this->linkTitulo === null) {
			return false;
		} else {
			return sprintf((string)$this->linkTitulo,$tp,$rs,$rt,$this->numTotalRegistros,$this->numTotalPaginas);
		}
	}
	
	/**
	*	@access private
	*/
	function check_vars () { // Funci&oacute;n modificada version 2.0
		$modo = $this->modo;
		$this->modo = 'publicacion';
		if(!$this->porPagina($this->porPagina)) $this->porPagina = 5;
		if(!$this->mostrarPrimera($this->mostrarPrimera)) $this->mostrarPrimera = "&laquo; Primera";
		if(!$this->mostrarAnterior($this->mostrarAnterior)) $this->mostrarAnterior = "&lt; Anterior";
		if(!$this->mostrarSiguiente($this->mostrarSiguiente)) $this->mostrarSiguiente = "Siguiente &gt;";
		if(!$this->mostrarUltima($this->mostrarUltima)) $this->mostrarUltima = "&Uacute;ltima &raquo;";
		if(!$this->mostrarAdyacentes($this->mostrarAdyacentes)) $this->mostrarAdyacentes = "{n}";
		if(!$this->mostrarActual($this->mostrarActual)) $this->mostrarActual = "{n}";
		if(!$this->paginasAntes($this->paginasAntes)) $this->paginasAntes =  3;
		if(!$this->paginasDespues($this->paginasDespues)) $this->paginasDespues = 3;
		if(!$this->nombreVariable($this->nombreVariable)) $this->nombreVariable = "page"; 
		if($this->linkSeparador === false or $this->linkSeparador === null or $this->linkSeparador === '') $this->linkSeparador = '';
		elseif($this->linkSeparador === 0 or $this->linkSeparador === '0') $this->linkSeparador = (string)'0';
		elseif($this->linkSeparador === true) $this->linkSeparador = 1;
		if($this->linkSeparadorEspecial === false) $this->linkSeparadorEspecial = $this->linkSeparador;
		elseif($this->linkSeparadorEspecial === 0 or $this->linkSeparadorEspecial === '0') $this->linkSeparador = (string)'0';
		elseif($this->linkSeparadorEspecial === true) $this->linkSeparadorEspecial = 1;
		$this->modo = $modo;
		return true;
	}
	
	/**
	*	@access private
	*/
	function do_link ($page, $title = false,$content) { // Funci&oacute;n modificada version 2.0
		$href = str_replace('{n}', $page, $this->linkEstructura);
		if(!empty($this->linkAgregar)) $href.= $this->linkAgregar;
		$estilo = $this->estilo;
		$title = $title === false ? '' : " title=\"$title\"";
		$div = $this->div;
		return strtr($this->mostrarResto,array('{n}'=>"<a href=\"javascript: fn_paginar('$div', '$href');\"$title$estilo>$content</a>"));
	}
  
	/**
	*	@access private
	*/
	function ejecutar() {
		$this->check_vars();
		if($this->sql === false and $this->data === false) return $this->error(false, "No se ha definido los datos ni la consulta SQL para realizar la paginaci&oacute;n"); // version 2.0
		$vars = $_GET;
		if($this->verPost == true) $vars = array_merge($vars, $_POST); // version 2.0
		$numEstaPagina = (isset($vars[$this->nombreVariable]) and is_numeric($vars[$this->nombreVariable]) and $vars[$this->nombreVariable] >= 1) ? intval($vars[$this->nombreVariable]) : 1; // Modificado version 2.0
		$this->numEstaPagina = &$numEstaPagina;
		$numPrimerRegistro = ($numEstaPagina - 1) * $this->porPagina;
		if(!empty($this->sql)) {
			$result = (isset($this->conn)) ? @mysqli_query($this->conn,$this->sql) : @mysqli_query(null,$this->sql);
			if(!$result) return $this->error(false, @mysqli_error(), $this->sql); // version 2.0
			$this->numTotalRegistros = @mysqli_num_rows($result);
		} else {
			$data = array_values($this->data);
			$data_keys = array_keys($this->data);
			$this->numTotalRegistros = count($data);
		}
		if($this->numTotalRegistros < $numPrimerRegistro) {
			$numPrimerRegistro = 0;
			$numEstaPagina = 1;
		}
		$this->numTotalPaginas = ceil($this->numTotalRegistros / $this->porPagina);
		if($this->numTotalRegistros >= 1) {
			$this->numPrimerRegistro = $numPrimerRegistro + 1;
			$pdata = array();
			if(!empty($this->sql)) {
				$sql = $this->sql." LIMIT $numPrimerRegistro, {$this->porPagina}"; //Separada version 2.0
				$result = (isset($this->conn)) ? @mysqli_query($this->conn, $sql) : @mysqli_query(null,$sql);
				if(!$result) return $this->error(false, @mysqli_error(), $sql, preg_match("/limit[ ]+[0-9]+(,[ ]*[0-9]+)?/", strtolower($sql))); // version 2.0
				$this->ejecutard = $result;
				$this->numTotalRegistros_actual = mysqli_num_rows($result);
			} else {
				$numUltimoRegistro = $numPrimerRegistro + $this->porPagina - 1;
				while($numPrimerRegistro <= $numUltimoRegistro) {
					if(isset($data[$numPrimerRegistro])) {
						$key = (isset($data_keys[$numPrimerRegistro])) ? $data_keys[$numPrimerRegistro] : rand()."_".$numPrimerRegistro;
						$pdata[$key] = $data[$numPrimerRegistro];
						$numPrimerRegistro++;
					} else {
						break;
					}
				}
				$this->ejecutard = $pdata;
				$this->numTotalRegistros_actual = count($pdata);
			}
			$this->numUltimoRegistro = $this->numPrimerRegistro + $this->numTotalRegistros_actual - 1;
		} else {
			$this->numPrimerRegistro = 0;
			$numEstaPagina = 0;
			$this->numTotalRegistros_actual = 0;
			$this->numUltimoRegistro = 0;
			$this->ejecutard = array();
		}
		$this->done = true;
		return true;
	}
	
	/**
	*	@access private
	* 	@version 2.0
	*/
	function error($desarrollo = true, $msg, $query = false, $limit_error = null) {
		if($this->modo != 'publicacion' and $this->mostre_error == false) {
			if($this->modo == 'reporte') {
				$error = "Hubo un error al intentar ejecutar la paginaci&oacute;n de los resultados. Por favor, comun&iacute;quese con el responsable de este sitio";
				if($desarrollo == true) {
					$this->error = $error;
					return false;
				}
				$this->mostre_error = true;
			} elseif(!empty($query)) {
				$error = "Hubo un error ejecutando la consulta<blockquote><code style='color: #00f; font-size: 13px;'>".htmlspecialchars($query)."</code></blockquote>El error devuelto es: <blockquote><code style='color: #080; font-size: 13px;'><strong>$msg</strong></code></blockquote>";
				if($limit_error == true) $error.= "El error probablemente se deba a que en la consulta MySQL que usted indic&oacute; aparentemente ya exist&iacute;a una cláusula LIMIT, la cuál es añadida automáticamente por el paginador. Más informaci&oacute;n en la página web del script.<br /><br />";
				$error.= "Si no logra solucionar el problema, env&iacute;e un mensaje a <code>desarrollo@tuweb7.com</code> indicando el error mostrado y la consulta que gener&oacute; el error";
			} else {
				$error = "Hubo un error ejecutando la paginaci&oacute;n. El mensaje devuelto es: <blockquote><code style='color: #080; font-size: 13px;'><strong>$msg</strong></code></blockquote>Si no logra solucionar el problema, env&iacute;e un mensaje a <code>desarrollo@tuweb7.com</code> indicando el error mostrado y la consulta que gener&oacute; el error";
			}
			$p = "<div style='border: 1px solid #666; background-color: #f6f6f6; margin: 5px 10px; padding: 10px 5px;'>";
			$p.= "<div style='color: #f00; font: 18px Georgia; margin: 0 5px; border-bottom: 1px dotted #f00;'><strong>PHPPaging - Error</strong></div>";
			$p.= "<div style='font: 12px Verdana; margin: 15px 19px;'>$error</div>";
			$p.= "<div style='font: 12px Georgia; text-align: right; color: #777; margin: 0; padding: 1px 4px;'>PHPPaging v2.1 (20081114)</div></div>";
			echo $p;
		} else {
			$this->error = $msg;
		}
		return false;
	}
}
?>