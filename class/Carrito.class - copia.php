<?php 
if(isset( $pagina) && $pagina=='cesta'){
	/* esos import lso saco del auten.php */
}else{
	session_start();
	include_once("../tw7control/class/functions.php");
	include_once("../tw7control/class/class.bd.php");
}


class Carrito{
 
    //aquí guardamos el contenido del carrito
    private $carrito = array();
 
    //seteamos el carrito exista o no exista en el constructor
    public function __construct(){
        
        if(!isset($_SESSION["carrito"])){
            $_SESSION["carrito"] = null;
            $this->carrito["precio_total"] = 0;
            $this->carrito["precio_total_online"] = 0;
						
            $this->carrito["articulos_total"] = 0;
            $this->carrito["precio_envio"] =  0;
            $this->carrito["id_suscrito"]= 0; //variable para almacenar la id de la sesion
             
        }
        $this->carrito = $_SESSION['carrito'];
	
    }
 
    //añadimos un producto al carrito
    public function add($articulo = array()){
        //primero comprobamos el articulo a añadir, si está vacío o no es un 
        //array lanzamos una excepción y cortamos la ejecución
        if(!is_array($articulo) || empty($articulo)){
            throw new Exception("Error, el articulo no es un array!", 1);    
        }
 
        //nuestro carro necesita siempre un id producto, cantidad y precio articulo
          if(!$articulo["id"] || !$articulo["cantidad"] || !$articulo["precio"] || !$articulo["precio_online"]){
              throw new Exception("Error, el articulo debe tener un id, cantidad y precio!", 1);    
          }
 
        //nuestro carro necesita siempre un id producto, cantidad y precio articulo
          if(!is_numeric($articulo["id"]) || !is_numeric($articulo["cantidad"]) || !is_numeric($articulo["precio"]) || !is_numeric($articulo["precio_online"]) ){
            throw new Exception("Error, el id, cantidad y precio deben ser números!", 1);    
          }
 
        //debemos crear un identificador único para cada producto
        $unique_id = $articulo["id"];
 
        //creamos la id única para el producto
        $articulo["unique_id"] = $unique_id;
        
        
        //si no está vacío el carrito lo recorremos 
        // if(!empty($this->carrito)){
            // foreach ($this->carrito as $row) {
                //comprobamos si este producto ya estaba en el 
                //carrito para actualizar el producto o insertar
                //un nuevo producto    
                
                // if($row["unique_id"] === $unique_id){
                    //si ya estaba sumamos la cantidad
                      // $articulo["cantidad"] = $row["cantidad"] + $articulo["cantidad"];
                // }
            // }
        // }
 
				//comprobar  si tiene algo adentro .. 
        if(!empty($this->carrito)){
													
								// sino existe sesion todo funciona con normalidad 
								 $existe=0;
								// recorremos carrtito 
								foreach ($this->carrito as $row){
										//si se repite  
										if($row["unique_id"] === $unique_id){
											$existe=1; 
										}
								}
								if($existe==1){ 
									// unset($_SESSION["carrito"][$unique_id]); //elimino
									// para esta web no vamos a utilizar la eliminacion desde boton, sino directo en cesta. .
									
								}else{  
									//sino add al carrito
									//evitamos que nos pongan números negativos y que sólo sean números para cantidad y precio
									$articulo["cantidad"] = trim(preg_replace('/([^0-9\.])/i', '', $articulo["cantidad"]));
									$articulo["precio"] = trim(preg_replace('/([^0-9\.])/i', '', $articulo["precio"]));
									$articulo["precio_online"] = trim(preg_replace('/([^0-9\.])/i', '', $articulo["precio_online"]));
				 
									//añadimos un elemento total al array carrito para 
									//saber el precio total de la suma de este artículo
										$articulo["total"] = $articulo["cantidad"] * $articulo["precio"];
										$articulo["total_online"] = $articulo["cantidad"] * $articulo["precio_online"];
									$_SESSION["carrito"][$unique_id] = $articulo;
								}											
            
        }else{ // si carro esta vacio
					//reseteo envio
					$_SESSION["suscritos"]["precio_envio"]=0;
					$this->precio_envio();
					//si carro esta vacio inserto producto al carro
					$_SESSION["carrito"][$unique_id] = $articulo;
        }
 
 
      
 
//Eliminado ** 
      //primero debemos eliminar el producto si es que estaba en el carrito
        // $this->unset_producto($unique_id);
 
        //actualizamos el carrito
        $this->update_carrito();
 
        //actualizamos el precio total y el número de artículos del carrito
        //una vez hemos añadido el producto          
          $this->update_precio_cantidad();
    }
 
    //método que actualiza el precio total y la cantidad
    //de productos total del carrito
    private function update_precio_cantidad(){
        //reseteamos las variables precio y artículos a 0
          $precio = 0;
          $precio_online = 0;
          $articulos = 0;
 
        //recorrecmos el contenido del carrito para actualizar
        //el precio total y el número de artículos
        foreach ($this->carrito as $row){
            $precio += ($row['precio'] * $row['cantidad']);
            $precio_online += ($row['precio_online'] * $row['cantidad']);
            $articulos += $row['cantidad'];
        }
 
        //asignamos a articulos_total el número de artículos actual
        //y al precio el precio actual
          $_SESSION['carrito']["articulos_total"] = $articulos;
          $_SESSION['carrito']["precio_subtotal"] = $precio;
          $_SESSION['carrito']["precio_total"] = $precio;

					$_SESSION['carrito']["precio_subtotal_online"] = $precio_online;
          $_SESSION['carrito']["precio_total_online"] = $precio_online;
 
        //refrescamos él contenido del carrito para que quedé actualizado
        $this->update_carrito();
    }
    
 
    public function id_suscrito(){ //funcion para capturar y devolver el id de la sesion automaticamente 
      //si existe sesion id_suscrito , este array toma ese valor
      if(isset($_SESSION["suscritos"]["id_suscrito"]) and !empty($_SESSION["suscritos"]["id_suscrito"]) ){
          $this->carrito["id_suscrito"] = $_SESSION["suscritos"]["id_suscrito"];
          return $this->carrito["id_suscrito"] ? $this->carrito["id_suscrito"] : 0;
        }else{
          return 0; 
        }
    }

		public function precio_envio(){ //funcion para capturar y devolver el id de la sesion automaticamente 
      //si existe sesion precio_envio , este array toma ese valor
      if(isset($_SESSION["suscritos"]["precio_envio"]) and !empty($_SESSION["suscritos"]["precio_envio"]) ){
          $this->carrito["precio_envio"] = $_SESSION["suscritos"]["precio_envio"];
          return $this->carrito["precio_envio"] ? $this->carrito["precio_envio"] : 0;
        }else{
          return 0; 
        }
    }
    
    //método que retorna el precio precio_subtotal del carrito
    public function precio_subtotal(){
        //si no está definido el elemento precio_subtotal o no existe el carrito
        //el precio total será 0
        if(!isset($this->carrito["precio_subtotal"]) || $this->carrito === null) {
            return 0;
        }
        
        //si no es númerico lanzamos una excepción porque no es correcto
        if(!is_numeric($this->carrito["precio_subtotal"])){
            throw new Exception("El precio total del carrito debe ser un número", 1);    
        }
        
        //en otro caso devolvemos el precio total del carrito
          return $this->carrito["precio_subtotal"] ? $this->carrito["precio_subtotal"] : 0;
    }

		//método que retorna el precio precio_subtotal_online del carrito
    public function precio_subtotal_online(){
        //si no está definido el elemento precio_subtotal_online o no existe el carrito
        //el precio total será 0
        if(!isset($this->carrito["precio_subtotal_online"]) || $this->carrito === null) {
            return 0;
        }
        
        //si no es númerico lanzamos una excepción porque no es correcto
        if(!is_numeric($this->carrito["precio_subtotal_online"])){
            throw new Exception("El precio total del carrito debe ser un número", 1);    
        }
        
        //en otro caso devolvemos el precio total del carrito
          return $this->carrito["precio_subtotal_online"] ? $this->carrito["precio_subtotal_online"] : 0;
    }
 
	//método que retorna el precio total del carrito
    public function precio_total(){
        //si no está definido el elemento precio_total o no existe el carrito
        //el precio total será 0
				if(!isset($_SESSION["suscritos"]["precio_envio"])){
					$variable_de_envio=0;
				}else{
					$variable_de_envio=$_SESSION["suscritos"]["precio_envio"];					
				}
				
				
        if(isset($_SESSION['carrito']["precio_subtotal"])){
          $this->carrito["precio_total"] = $_SESSION['carrito']["precio_subtotal"]+$variable_de_envio; //añado precio del envio
        }else{
          $this->carrito["precio_total"] =0; //añado precio del envio

        }

        if(!isset($this->carrito["precio_total"]) || $this->carrito === null) {
            return 0;
        }
        
        //si no es númerico lanzamos una excepción porque no es correcto
        if(!is_numeric($this->carrito["precio_total"])){
            throw new Exception("El precio total del carrito debe ser un número", 1);    
        }
        
        //en otro caso devolvemos el precio total del carrito
          return $this->carrito["precio_total"] ? $this->carrito["precio_total"] : 0;
    }


		public function precio_total_online(){
        //si no está definido el elemento precio_total_online o no existe el carrito
        //el precio total será 0
				if(!isset($_SESSION["suscritos"]["precio_envio"])){
					$variable_de_envio=0;
				}else{
					$variable_de_envio=$_SESSION["suscritos"]["precio_envio"];					
				}
				
				if(isset($_SESSION['carrito']["precio_subtotal_online"])){
          $this->carrito["precio_total_online"] = $_SESSION['carrito']["precio_subtotal_online"]+$variable_de_envio; //añado precio del envio
          
        }else{
          $this->carrito["precio_total_online"] = 0; //añado precio del envio

        }


        if(!isset($this->carrito["precio_total_online"]) || $this->carrito === null) {
            return 0;
        }
        
        //si no es númerico lanzamos una excepción porque no es correcto
        if(!is_numeric($this->carrito["precio_total_online"])){
            throw new Exception("El precio total online del carrito debe ser un número", 1);    
        }
        
        //en otro caso devolvemos el precio total del carrito
          return $this->carrito["precio_total_online"] ? $this->carrito["precio_total_online"] : 0;
    }
 
 
    //método que retorna el número de artículos del carrito
    public function articulos_total(){
        //si no está definido el elemento articulos_total o no existe el carrito
        //el número de artículos será de 0
        
        if(!isset($this->carrito["articulos_total"]) || $this->carrito === null){
            return 0;
        }
        
        //si no es númerico lanzamos una excepción porque no es correcto
        if(!is_numeric($this->carrito["articulos_total"])){
            throw new Exception("El número de artículos del carrito debe ser un número", 1);    
        }
        
        //en otro caso devolvemos el número de artículos del carrito
        return $this->carrito["articulos_total"] ? $this->carrito["articulos_total"] : 0;
    }
 
    //este método retorna el contenido del carrito
    public function get_content(){
        //asignamos el carrito a una variable
        $carrito = $this->carrito;
    //debemos eliminar del carrito el número de artículos y el precio total , ID_CLIENTE  para poder mostrar bien los artículos
        //ya que estos datos los devuelven los métodos 
        //articulos_total y precio_total
          unset($carrito["articulos_total"]); 
          unset($carrito["precio_subtotal"]);
          unset($carrito["precio_total"]);

					unset($carrito["precio_subtotal_online"]);
          unset($carrito["precio_total_online"]);
					
          unset($carrito["id_suscrito"]);
          unset($carrito["precio_envio"]);
					
					// ELIMINANDO CURSOS/PRODUCTOS QUE YA HAN SIDO COMPRADOS POR EL CLIENTE: excepto libros que los peuda comprar cuantsa veces desee 
					//recorro carrito para validar los cursos que ya compro el cliente y si esta nen la cesta agregados eliminarlos automaticamente.
					// para evitar que compre un curso que ya tiene actualmente. 
					if(isset($_SESSION["suscritos"]["id_suscrito"]) and !empty($_SESSION["suscritos"]["id_suscrito"]) and ($_SESSION["suscritos"]["id_suscrito"] > 0) ){ 
							//Validamos suscripcion al curso
							// recorremos carrtito lso proucto agregados actuales. 
							foreach ($carrito as $row){							
									// $campo = is_array($row) ? $row['id'] : $row;
									$id_curso =  $row['id'];		
									
									// consultamos si lso productos de la cesta se encuentras comprados por el alumno: 
									// $sql_repet_curso="select id_curso from suscritos_x_cursos where id_tipo!=2 and estado!=3 and estado_idestado=1 and id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."' and id_curso='".$id_curso."' ";								
									
									
									/* id_tipo !=2 :: =>> permite q lo s libros pueden ser conpraods varias veces .. */
									$sql_repet_curso="select id_curso from suscritos_x_cursos where id_tipo='".$row['id_tipo']."' and id_tipo!=2  and estado!=3 and estado_idestado=1 and id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."' and id_curso='".$id_curso."' ";								
									
									$valido_curso_add=executesql($sql_repet_curso);										
									if( !empty($valido_curso_add) ){ 
										$id_curso =  $row['unique_id'];
										// si el curso ya lo tiene comprado, lo eliminamos. de la cesta. 
										unset($_SESSION["carrito"][$id_curso]); //elimino
									 //actualizamos el carrito
										
									}		// end if consulta de curso 
									$this->update_carrito();         
									$this->update_precio_cantidad();
									$this->precio_total();	
									$this->precio_total_online();	
													
							}	// for carrito														
					}// if exitst sesion
					
					
        return $carrito == null ? null : $carrito;
    }
    
 
    //método que llamamos al insertar un nuevo producto al 
    //carrito para eliminarlo si existia, así podemos insertarlo
    //de nuevo pero actualizado
    
    private function unset_producto($unique_id){
        unset($_SESSION["carrito"][$unique_id]);
    }
 
 
    //para eliminar un producto debemos pasar la clave única
    //que contiene cada uno de ellos
    public function remove_producto($unique_id){
        //si no existe el carrito
        if($this->carrito === null){
            throw new Exception("El carrito no existe!", 1);
        }
 
        //si no existe la id única del producto en el carrito
        if(!isset($this->carrito[$unique_id])){
            throw new Exception("La unique_id $unique_id no existe!", 1);
        }
 
        //en otro caso, eliminamos el producto, actualizamos el carrito y 
        //el precio y cantidad totales del carrito
        unset($_SESSION["carrito"][$unique_id]);
        $this->update_carrito();
        $this->update_precio_cantidad();
        return true;
    }
 
 
    //eliminamos el contenido del carrito por completo
    public function destroy() {
        unset($_SESSION["carrito"]);
        $this->carrito = null;
        return true;
    }
 
    //actualizamos el contenido del carrito
    public function update_carrito(){
        self::__construct();
    }
 
}