<?php $bd=new BD;

// echo $_aleatorios[5][0];
// echo var_dump($_aleatorios);
// exit();

$array_total = count($_aleatorios);
$_POST['orden_en_examen']= 0;
$_POST['fecha_registro'] = fecha_hora(2);
$_POST['estado_idestado']= 1;


for ($i = 0; $i < $array_total; ++$i){
        //echo $_sql_1=" select * from preguntas_bancos where estado_idestado=1 and id_cate='198' ORDER BY RAND() LIMIT ".$_POST["n_preguntas_rm"]." ";
    $_sql_1=" select * from preguntas_bancos where  corregido=1 and estado_idestado=1 and ".$_aleatorios[$i][0]." ORDER BY RAND() LIMIT ".$_aleatorios[$i][1]." ";
    $_consulta = executesql( $_sql_1);
    if( !empty( $_consulta) ){
        foreach( $_consulta as $row_pregunta ){
            $_POST['orden_en_examen']++;
            //$_POST['orden'] = _orden_noticia("","preguntas","");

            $_POST['id_cate']= $row_pregunta["id_cate"];
            $_POST['titulo']= $row_pregunta["titulo"];
            $_POST['titulo_rewrite']= $row_pregunta["titulo_rewrite"];

            if( $row_pregunta["id_cate"] == 199 ){  // comprension :: PRIMERO COMPRENSUION LUEG RM
                $_POST['puntos']= 2;

            }else if( $row_pregunta["id_cate"] == 198 ){  // RM 
                $_POST['puntos']= 2;
                
            }else{
                //$_POST['puntos']= $row_pregunta["puntos"];
                $_POST['puntos']= 3;
            }


            $_POST['descripcion']= $row_pregunta["descripcion"];
            $_POST['solucion']= $row_pregunta["solucion"];
            $_POST['solucion_es_video']= $row_pregunta["solucion_es_video"];
            $_POST['imagen']= $row_pregunta["imagen"];
            $_POST['imagen_pre_2']= $row_pregunta["imagen_pre_2"];
            $_POST['imagen2']= $row_pregunta["imagen2"];

            $campos=array('id_examen','id_cate','titulo','titulo_rewrite','puntos','descripcion','solucion','solucion_es_video','estado_idestado','orden_en_examen','imagen','imagen_pre_2','imagen2','fecha_registro');

            $_POST["id_pregunta"] = $bd->inserta_(arma_insert('preguntas',$campos,'POST'));/* Pregunta insertada */

            /** Agrego sus respuestas en caso existan  */
            $_respuestas_del_banco= executesql("select * from respuestas_bancos where estado_idestado=1 and id_pregunta='".$row_pregunta["id_pregunta"]."' ");
            if( !empty( $_respuestas_del_banco) ){
                foreach( $_respuestas_del_banco as $row_respuesta ){
                    $_POST['titulo']= $row_respuesta["titulo"];
                    $_POST['titulo_rewrite']= $row_respuesta["titulo_rewrite"];
                    $_POST['descripcion']= $row_respuesta["descripcion"];
                    $_POST['imagen']= $row_respuesta["imagen"];
                    $_POST['valor']= $row_respuesta["valor"];
                    $_POST['estado_rpta']= $row_respuesta["estado_rpta"];
                    //$_POST['orden'] = _orden_noticia("","respuestas","");

                    $campos=array('id_pregunta','id_examen','titulo','titulo_rewrite','estado_rpta','imagen','descripcion','valor','estado_idestado','fecha_registro'); /*inserto campos principales*/
                    $bd->inserta_(arma_insert('respuestas',$campos,'POST'));/*inserto hora -orden y guardo imag*/
                }
            } // end add respuestas 



        } // end for array execute preguntas_bancos
    } // end if preguntas bancos

} // end for recorrer el array 

?>