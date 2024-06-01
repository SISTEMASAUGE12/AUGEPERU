<?php include('auten.php');
$pagina='blog';
$fecha=fecha_hora(2);

if(isset($_GET['rewrite2']) && !empty($_GET['rewrite2'])){
  	$sql="SELECT * FROM publicacion WHERE estado_idestado=1 and titulo_rewrite='".$_GET['rewrite2']."' order by orden desc  ";
  	$rs = executesql($sql);
  	if(!empty($rs)){
  		$idep = $rs[0]["idpublicacion"];
    	$tit=$rs[0]["titulo"];
    	$desss=$rs[0]["avance"];
    	$imgtit='tw7control/files/images/publicaciones/'.$rs[0]['imagen'];
  	}else{
    	$tit="Blog | GRUPO AUGE ";
    	$desss="";
    	$imgtit="";
  	}

  	$meta= array(
		'title' => $tit.' | Blog | GRUPO AUGE ',
		'keywords' => $desss,
		'description' => $desss,
		'image' => $imgtit
	);

	$bd=new BD;
	date_default_timezone_set('America/Lima');
	$autos = json_decode(file_get_contents('https://api.ipify.org/?format=json'), true);
	$ip =  $autos['ip'];
	
	$campos=array(array('publica',$idep),array('ipe',$ip),array('fecha',$fecha));
	$bd->inserta_(arma_insert('contador',$campos,'POST'));

}else{
  	$meta = array(
    	'title' => 'Auge: Blog',
    	'description' => ''
	);
}

include ('inc/header.php');
?>
<main id="blog"  class=" <?php if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ echo "logeado"; }?> ">
<?php
	if(isset($_GET['rewrite2']) && !empty($_GET['rewrite2'])){
	$bloga = executesql("SELECT * FROM publicacion WHERE estado_idestado = 1 AND titulo_rewrite = '".$_GET['rewrite2']."'",0);
	$conta = executesql("SELECT * FROM contador WHERE publica=".$bloga['idpublicacion']);
?>
	<div class="callout callout-2">
	<div class="row ">
		<div class="large-12 columns">
			<div class="parte-medio">
				<h1 class="color1 poppi-b"><?php echo $bloga['titulo'] ?></h1>
				<ul class="no-bullet color1 compa">
					<li class="poppi-sb">
						<img src="img/iconos/ojo.png"> 
						<?php 
						if( $bloga['idpublicacion'] == '11'){ 
							echo count($conta)+2042;
						
						}else if($bloga['idpublicacion'] == '10'){
							echo count($conta)+2467;
							
						}else{ 
							echo count($conta);
						}
						?>
							Vistos
					</li>
					
					<li class="poppi">Comparte en tus redes sociales:<a title="Twitter" href="javascript: void(0);" onclick="window.open('https://twitter.com/intent/tweet?text=&url='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/twitter-b.png"></a> <a title="Facebook" href="javascript: void(0);" onclick="window.open('http://www.facebook.com/sharer.php?u='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/face-b.png"></a> <a title="Telegram" href="javascript: void(0);" onclick="window.open('https://telegram.me/share/url?url='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/telegram-b.png"></a> <a href="https://api.whatsapp.com/send/?phone&text=<?php echo 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" target="_blank"><img src="img/iconos/wsp-b.png"></a></li>
				</ul>
			</div>
		</div>
		<div class="large-12 nothing text-center columns">
				<?php if(!empty($bloga['link']) ){ 
							$video= explode('watch?v=',$bloga['link']);
							$clemb= strpos($video[1],'&');
							$emb=substr($video[1],0,$clemb);
							$embed=($clemb !==false)?$emb:$video[1]; ?>
          <aside>                       
						<div class="para-video">
							<iframe width="100%" class="height-video-you" src="https://www.youtube.com/embed/<?php echo $embed; ?>" frameborder="0" allowfullscreen></iframe>
						</div>                         
          </aside>
			<?php }else{ ?>
				<div class="imagenmedio">
					<img src="tw7control/files/images/publicaciones/<?php echo $bloga['imagen'] ?>">
					<span class="poppi texto">Fuente: foto auge</span>
				</div>
			<?php } ?>
		</div>
		
		<div class="large-12 columns" style="padding-bottom:100px;">
			<div class="parte-medio descr">
				<?php echo $bloga['descripcion'] ?>
			</div>
		</div>
		
			
			<?php 
			$categ_recursos=executesql("select * from categoria_archivos_blog where estado_idestado=1 and publicacion_idpublicacion='".$bloga['idpublicacion']."' ");
			if( !empty($categ_recursos)){
			?>
		<div class="large-12 columns lleva_recursos" style="padding-bottom:100px;">	<div class="parte-medio descr">
			<h3 class="poppi-sb ">Recursos <small>[click para descargar archivo]</small></h3>
			<?php
					foreach($categ_recursos as $categ){
			?>
			<h4 class="poppi-sb ">	<?php echo $categ['titulo'] ?></h4>
						<?php 
						$archivos=executesql("select * from archivos_blog where estado_idestado=1 and publicacion_idpublicacion='".$categ['publicacion_idpublicacion']."'  and categoria_idcategoria='".$categ['idcategoria']."' ");
						if( !empty($archivos)){
								foreach($archivos as $data){
						?>
							<p><a href="tw7control/files/files/blog_recursos/<?php echo $bloga['idpublicacion'].'/'.$data['archivo']?>" target="_blank"><?php echo $data['titulo'] ?></a></p>
						<?php
								}
						}
						?>
						
			<?php
					}
					?>
		</div></div>
		<?php 
			}
			?>
		
		<div class="large-12 nothing text-center columns">
			<?php if(!empty($bloga['link_externo']) ){ 
							$video= explode('watch?v=',$bloga['link_externo']);
							$clemb= strpos($video[1],'&');
							$emb=substr($video[1],0,$clemb);
							$embed=($clemb !==false)?$emb:$video[1]; ?>
          <aside>                       
						<div class="para-video">
							<iframe width="100%" class="height-video-you" src="https://www.youtube.com/embed/<?php echo $embed; ?>" frameborder="0" allowfullscreen></iframe>
						</div>                         
          </aside>
			<?php } ?>
		</div>
		
		<section class="social contenido medium-8 medium-centered  columns" style="float:none;">										
			<h6 class="osans" style="padding-top:30px;"><b>FORO:</b></h6>         
			<div class="fb-comments" data-href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" data-width="800" data-numposts="15"></div>																		
		</section>

		
	</div>
<?php
// Listado segun categoria ..
	}elseif(isset($_GET['rewrite']) && !empty($_GET['rewrite'])){
?>
	<div class="callout callout-1"><div class="row row3 listado ">
<?php
		$blog1 = executesql("SELECT p.*, c.titulo as categ, c.titulo_rewrite as tipo_rew FROM publicacion p INNER JOIN categoriablogs c ON c.tipo = p.tipo WHERE p.estado_idestado = 1 and c.titulo_rewrite='".$_GET['rewrite']."' ORDER BY p.fecha_registro DESC ");
		if(!empty($blog1)){ ?>
		<div class="large-12 columns"><h1 class="poppi-b color1"><a href="blog" style="color:#333;">Blog </a> >  <small style="color:#444;"><?php echo $blog1[0]["categ"];?></small> </h1></div>

<?php 		foreach($blog1 as $blog01){
			$meses=array('Jan'=>'ENERO','Feb'=>'FEBRERO','Mar'=>'MARZO','Apr'=>'ABRIL','May'=>'MAYO','Jun'=>'JUNIO','Jul'=>'JULIO','Aug'=>'AGOSTO','Sep'=>'SEPTIEMBRE','Oct'=>'OCTUBRE','Nov'=>'NOVIEMBRE','Dec'=>'DICIEMBRE');
			$fecha= strtr(date('d\ \d\e\ M',strtotime($blog01['fecha_registro'])),$meses);
			$idq=$blog01['idpublicacion'];
?>
			<div class="large-4 medium-4 columns end "><div class="blog-grande">
				<figure class="rel"><a href="blog/<?php echo $blog01['tipo_rew'].'/'.$blog01['titulo_rewrite'] ?>"><img src="tw7control/files/images/publicaciones/<?php echo $blog01['imagen'] ?>"></a></figure>
				<div class="descri">
					<p class="poppi-b"><a href="blog/<?php echo $blog01['tipo_rew'].'/'.$blog01['titulo_rewrite'] ?>"><?php echo short_name($blog01['titulo'],75); ?></a></p>
					<span class="fecha poppi"><?php echo $fecha?></span>
					<div class="table-final">
						<div class="poppi"><a href="blog/<?php echo $blog01['tipo_rew'].'/'.$blog01['titulo_rewrite'] ?>" class="ref">Leer más</a></div>
						<div class="poppi">7 min de lectura</div>
						<!--
						<div class="poppi text-right"><a><img src="img/iconos/compartir.png"></a></div>
						-->
					</div>
				</div>
			</div></div>
<?php	
				} 
			}else{
				echo '	<div class="large-12 columns"><h1 class="poppi-b color1"><a href="blog" style="color:#333;">Blog </a> >  <small style="color:#444;"> No se encontro resultados ..</small> </h1></div><div style="padding:150px 0;"></div>';
			}
?>

	</div></div>
	<!-- end listado -->
<?php
	}else{
?>
	<div class="callout callout-1"><div class="row row3">
		<div class="large-12 columns">
			<h1 class="poppi-b color1">Blog</h1>
		</div>
		<div class="large-8 medium-8 nothing columns">
			<div class="large-6 medium-6 columns"><div class="blog-grande">
<?php
        	$blog1 = executesql("SELECT p.*, c.titulo_rewrite as tipo_rew FROM publicacion p INNER JOIN categoriablogs c ON c.tipo = p.tipo WHERE p.estado_idestado = 1 ORDER BY p.orden DESC LIMIT 0,1");
        	if(!empty($blog1)){ foreach($blog1 as $blog01){
        		$meses=array('Jan'=>'ENERO','Feb'=>'FEBRERO','Mar'=>'MARZO','Apr'=>'ABRIL','May'=>'MAYO','Jun'=>'JUNIO','Jul'=>'JULIO','Aug'=>'AGOSTO','Sep'=>'SEPTIEMBRE','Oct'=>'OCTUBRE','Nov'=>'NOVIEMBRE','Dec'=>'DICIEMBRE');
    			$fecha= strtr(date('d\ \d\e\ M',strtotime($blog01['fecha_registro'])),$meses);
        		$idq=$blog01['idpublicacion'];
?>
				<figure class="rel"><a href="blog/<?php echo $blog01['tipo_rew'].'/'.$blog01['titulo_rewrite'] ?>"><img src="tw7control/files/images/publicaciones/<?php echo $blog01['imagen'] ?>"></a></figure>
				<div class="descri">
					<p class="poppi-b"><a href="blog/<?php echo $blog01['tipo_rew'].'/'.$blog01['titulo_rewrite'] ?>"><?php echo $blog01['titulo'] ?></a></p>
					<span class="fecha poppi"><?php echo $fecha?></span>
					<div class="table-final">
						<div class="poppi"><a href="blog/<?php echo $blog01['tipo_rew'].'/'.$blog01['titulo_rewrite'] ?>" class="ref">Leer más</a></div>
						<div class="poppi">7 min de lectura</div>
						<!--
						<div class="poppi text-right"><a><img src="img/iconos/compartir.png"></a></div>
						-->
					</div>
				</div>
<?php
			} }
?>
			</div></div>
			<div class="large-6 medium-6 olda columns">
<?php
        	$blog2 = executesql("SELECT p.*, c.titulo_rewrite as tipo_rew FROM publicacion p INNER JOIN categoriablogs c ON c.tipo = p.tipo WHERE p.estado_idestado = 1  ORDER BY p.orden DESC LIMIT 1,5");
        	$idglo = '';
        	if(!empty($blog2)){ foreach($blog2 as $blog02){
        		$meses=array('Jan'=>'ENERO','Feb'=>'FEBRERO','Mar'=>'MARZO','Apr'=>'ABRIL','May'=>'MAYO','Jun'=>'JUNIO','Jul'=>'JULIO','Aug'=>'AGOSTO','Sep'=>'SEPTIEMBRE','Oct'=>'OCTUBRE','Nov'=>'NOVIEMBRE','Dec'=>'DICIEMBRE');
    			$fecha= strtr(date('d\ \d\e\ M',strtotime($blog02['fecha_registro'])),$meses);
        		$idglo=$blog02['idpublicacion'].',';
?>
				<div class="lista-blog">
					<p class="poppi-b"><a href="blog/<?php echo $blog02['tipo_rew'].'/'.$blog02['titulo_rewrite'] ?>"><?php echo $blog02['titulo'] ?></a></p>
					<div class="table-list">
						<div class="poppi color1"><?php echo $fecha ?></div>
						<div class="poppi color1">7 min de lectura</div>
					</div>
				</div>
<?php
			} }
			if(!empty($idglo)){
				$global = substr($idglo, 0, -1);
			}
?>
			</div>
		</div>
		<div class="large-4 medium-4 catego columns">
			<h5 class="poppi-b color1">Temas a seguir</h5>
<?php
        	$ses = executesql("SELECT * FROM categoriablogs WHERE estado_idestado = 1 ORDER BY ORDEN ASC");
        	if(!empty($ses)){ foreach($ses as $sesi){
?>
			<div class="separar"><p class="poppi-b color1"><?php echo $sesi['titulo'] ?><a href="blog/<?php echo $sesi['titulo_rewrite'] ?>" class="poppi-sb boton">Ver ahora</a></p></div>
<?php
			} }
?>
<!--
			<a class="bota">Leer más</a>
			-->
		</div>
		<div class="clearfix clearfix2"></div>


		<div class="large-8 medium-8 float-left nothing columns">
<?php
				$sql_blog_2="SELECT p.*, c.titulo_rewrite as tipo_rew FROM publicacion p INNER JOIN categoriablogs c ON c.tipo = p.tipo WHERE p.estado_idestado = 1  ORDER BY p.fecha_registro, p.orden DESC LIMIT 5,1000 "; 
				
				// echo $sql_blog_2;
       	$blog3 = executesql($sql_blog_2);
        	if(!empty($blog3)){ foreach($blog3 as $blog03){
        		$meses=array('Jan'=>'ENERO','Feb'=>'FEBRERO','Mar'=>'MARZO','Apr'=>'ABRIL','May'=>'MAYO','Jun'=>'JUNIO','Jul'=>'JULIO','Aug'=>'AGOSTO','Sep'=>'SEPTIEMBRE','Oct'=>'OCTUBRE','Nov'=>'NOVIEMBRE','Dec'=>'DICIEMBRE');
    			$fecha= strtr(date('d\ \d\e\ M',strtotime($blog03['fecha_registro'])),$meses);
?>
			<div class="large-8 medium-8 opa columns">
				<div class="lista-blog2">
					<p class="poppi-b titu"><a href="blog/<?php echo $blog03['tipo_rew'].'/'.$blog03['titulo_rewrite'] ?>"><?php echo $blog03['titulo'] ?></a></p>
					<?php echo !empty($blog03['avance']) ? '<p class="poppi texto">'.$blog03['avance'].'</p>' : ''; ?>
					<div class="table-final">
						<div class="poppi"><?php echo $fecha ?></div>
						<div class="poppi">7 min de lectura</div>
						<!--
						<div class="poppi text-right"><a><img src="img/iconos/compartir.png"></a></div>
						-->
					</div>
				</div>
			</div>
			<div class="large-4 medium-4 opa columns">
				<figure class="rel fire"><img src="tw7control/files/images/publicaciones/<?php echo $blog03['imagen'] ?>"></figure>
			</div>
			<div class="clearfix clearfix3 opa"></div>
			
<?php
			} }

			// LIstado noticias movil
        	$blog4 = executesql("SELECT p.*, c.titulo_rewrite as tipo_rew FROM publicacion p INNER JOIN categoriablogs c ON c.tipo = p.tipo WHERE p.estado_idestado = 1  ORDER BY p.fecha_registro DESC LIMIT 5,1000 ");
        	if(!empty($blog4)){ foreach($blog4 as $blog04){
        		$meses=array('Jan'=>'ENERO','Feb'=>'FEBRERO','Mar'=>'MARZO','Apr'=>'ABRIL','May'=>'MAYO','Jun'=>'JUNIO','Jul'=>'JULIO','Aug'=>'AGOSTO','Sep'=>'SEPTIEMBRE','Oct'=>'OCTUBRE','Nov'=>'NOVIEMBRE','Dec'=>'DICIEMBRE');
    			$fecha= strtr(date('d\ \d\e\ M',strtotime($blog04['fecha_registro'])),$meses);
?>
			<div class="large-8 medium-8 small-9 opa2 columns">
				<div class="lista-blog2">
					<p class="poppi-b titu"><a href="blog/<?php echo $blog04['tipo_rew'].'/'.$blog04['titulo_rewrite'] ?>"><?php echo $blog04['titulo'] ?></a></p>
					<div class="table-final">
						<div class="poppi"><?php echo $fecha ?></div>
						<div class="poppi">7 min de lectura ...</div>
					</div>
				</div>
			</div>
			<div class="large-4 medium-4 small-3 opa2 columns">
				<figure class="rel fire"><img src="tw7control/files/images/publicaciones/<?php echo $blog04['imagen'] ?>"></figure>
			</div>
			<div class="clearfix clearfix4 opa2"></div>
<?php
			} }

?>

		</div>
		<div class="large-4 medium-4 catego catego2 columns">
			<h5 class="poppi-b color1">Temas a seguir</h5>
<?php
        	$ses = executesql("SELECT * FROM categoriablogs WHERE estado_idestado = 1 ORDER BY ORDEN ASC");
        	if(!empty($ses)){ foreach($ses as $sesi){
?>
			<div class="separar"><p class="poppi-b color1"><?php echo $sesi['titulo'] ?><a href="blog/<?php echo $sesi['titulo_rewrite'] ?>" class="poppi-sb boton">Ver ahora</a></p></div>
<?php
			} }
?>
<!--
			<a class="bota">Leer más </a>
			-->
		</div>
	</div></div>
<?php
	}
?>
</main>
<?php include ('inc/footer.php'); ?>