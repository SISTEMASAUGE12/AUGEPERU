<?php class BD{
	
// private $host='localhost';
// private $database='educaauge';
// private $user='root';
// private $pass='jopedis1';


// private $host='localhost';
// private $database='augeperu_bd';
// private $user='root';
// private $pass='';


private $host='localhost';
private $database='eduauge2024_bd_mayo';
private $user='eduauge2024_usuariobd';
private $pass='usuariobd$auge%';
		
		
		
	public $cn;
  const ABIERTA=1;
  const CERRADA=0;
  var $status=0;

 /** Abrimos la bd */
  public function open()
  {
    $this->cn = mysqli_connect($this->host,$this->user,$this->pass,$this->database) or die(mysqli_error($this->cn ));
    @mysqli_set_charset($this->cn, 'utf8');
  }


  
 /**
  * Cierra la bd
  */
  public function close()
  {
    mysqli_close($this->cn);
  }

 /**
  * Ejecutamos una consulta para que nos devuelva resultados
  * @param string $sql Consulta SQL
  */
  public function Begin()
  {
    $this->ExecuteQuery("BEGIN;");
  }
  public function Commit()
  {
    if($this->status==BD::CERRADA ) $this->open();
    return mysqli_query($this->cn,"COMMIT;");
  }
  public function ExecuteQuery($sql)
  {
    if($this->status==BD::CERRADA) $this->open();
    mysqli_query($this->cn,$sql);
  }
  public function return_ExecuteQuery($sql)
  {
    if($this->status==BD::CERRADA) $this->open();
    return mysqli_query($this->cn,$sql);
  }
  public function inserta_($query)
  {
    $this->ExecuteQuery($query);
    return mysqli_insert_id($this->cn);
  }
  public function actualiza_($query)
  {
    if($this->status==BD::CERRADA ) $this->open();
    $rs=mysqli_query($this->cn,$query);

    return mysqli_affected_rows($this->cn);
  }



 /**
  * Ejecutamos una consulta SQl
  * @param string $query Consulta SQL
  * @return un array  de registros, cada uno siendo una array asociativo de campos
  */
  /*
  public function Execute($query)
  {
    if($this->status==BD::CERRADA) $this->open();
    $rs = mysqli_query($this->cn,$query);
    if(!$rs)
    {
      throw new Exception(mysqli_error());
    }
    //pasamos el recordset al array asociativo
    $i = 0;
    $tab = array();
    while($row = mysqli_fetch_array($rs))
    {
      $tab[$i++] = $row;
    }
    return $tab;
  }
*/
		
public function Execute($query, $tipoRespuesta = 'array')
{
    if ($this->status == BD::CERRADA) $this->open();
    $rs = mysqli_query($this->cn, $query);

    if (!$rs) {
        throw new Exception(mysqli_error($this->cn));
    }
    $i = 0;
    $tab = array();
    if ($tipoRespuesta == 'array') {
        while ($row = mysqli_fetch_array($rs)) {
            $tab[$i++] = $row;
        }
    }
    if ($tipoRespuesta == 'assoc') {
        while ($row = mysqli_fetch_assoc($rs)) {
            $tab[] = $row;
        }
    }
    if ($tipoRespuesta == 'object') {

    }

    return $tab;
  }




}
?>