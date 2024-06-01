<!DOCTYPE html>
<?php  
$unix_date = strtotime(date('Y-m-d H:i:s')); 

include("auten.php");
$_wsp='915152861'; 


$sql="SELECT * FROM landings_bigs WHERE estado_idestado=1 and titulo_rewrite='".$_GET['rewrite']."' order by orden desc limit 0,1 ";
$landings_bigs = executesql($sql);
if(!empty($landings_bigs) ){ // consultamos si existe 
  
  $href_wsp='https://api.whatsapp.com/send?phone=+51'.$_wsp.'&text=Hola,%20quiero%20inscribirme%20en%20'.$landings_bigs[0]['emergente_link']; 

?>
<!-- saved from url=(0315)https://cf.conviertemas.com/cmd?utm_source=meta&utm_medium=cpc&utm_campaign=120202065212150091&utm_content=120202370669660091&utm_term=120202370669750091&fbclid=PAAaaWZ5LtUipbGGN8a0-13bvRPLnzxSgg21QdtBM4jqUrYWXVnyuEDVUfRkM_aem_AUsBqNGE_hnHdASoo9jDP-4cXkg3kjFXg_h1yBf4OftjV0xTElAu49aYqL4MnOIsHHs7uh5uESjzdh1EqoScSj2B -->
<html lang="en" class="clickfunnels-com wf-proximanova-i4-active wf-proximanova-i7-active wf-proximanova-n4-active wf-proximanova-n7-active wf-active bgRepeat wf-proximanova-i3-active wf-proximanova-n3-active elFont_lato wf-proximanovasoft-n4-active wf-proximanovasoft-n7-active wf-proximasoft-n4-active wf-proximasoft-i4-active wf-proximasoft-i6-active wf-proximasoft-n6-active wf-proximasoft-i7-active wf-proximasoft-n7-active " style="overflow: initial; background-color: rgb(233, 233, 233); ">
<head data-next-url="" data-this-url="<?php echo $url; ?>">
<base href="<?php echo $url; ?>"/>
  
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


<meta content="utf-8" http-equiv="encoding">
<meta name="viewport" content="initial-scale=1">
<title> <?php echo $landings_bigs[0]['titulo_seo']; ?></title>
<meta class="metaTagTop" name="description" content=" regístrate al evento ">
<meta class="metaTagTop" name="keywords" content="">
<meta class="metaTagTop" name="author" content=" educaauge.com  ">
<meta class="metaTagTop" property="og:image" content=" <?php echo '../intranet/files/images/landings_bigs/'.$landings_bigs[0]['imagen']; ?>" id="social-image">
<meta property="og:title" content=" <?php echo $landings_bigs[0]['titulo_seo']; ?> ">
<meta property="og:description" content=" <?php echo $landings_bigs[0]['titulo_seo']; ?>">
<meta property="og:url" content="<?php echo $url; ?>">
<meta property="og:type" content="website">
<link rel="stylesheet" media="screen" href="assets/lander.css">
<link rel="shortcut icon" href="../favicon.png">


<link rel="canonical" href="<?php echo $url; ?>">
<link rel="stylesheet" href="assets/all.css">
<link rel="stylesheet" href="assets/v4-shims.css">
<link href="assets/css" rel="stylesheet" type="text/css">

<script async="" src="assets/clarity.js"></script><script src="assets/id.min.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script type="text/javascript" integrity="sha384-VuGgAcmMrGHihvjXxxBVMIqoDFXc8/PO9q/08kCgq4Wn1iPnSmUbI3xhXaFozVFv" crossorigin="anonymous" async="" src="assets/amplitude-8.18.1-min.gz.js.descargar"></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/player.js.descargar" async=""></script><script src="assets/track-v3.js.descargar" type="text/javascript" async=""></script><script type="text/javascript" async="" src="assets/vendor.js.descargar"></script><script async="" src="assets/launcher.js.descargar"></script><script async="" src="assets/fbevents.js.descargar"></script></script><script type="text/javascript" async="" src="assets/js"></script><script src="assets/diffuser.js.descargar" async=""></script><script async="" src="assets/d5sqzfrllq"></script><script id="ti-js" async="" src="assets/bc554.js.descargar"></script><script type="text/javascript" async="" src="assets/index.js.descargar"></script><script type="text/javascript" async="" data-scriptid="dfunifiedcode" src="assets/reactunified.bundle.js.descargar"></script><script type="text/javascript" async="" data-scriptid="dfunifiedcode" src="assets/reactunified.bundle.js.descargar"></script><script src="assets/track-v3.js.descargar" type="text/javascript" async=""></script><script async="" src="assets/launcher.js.descargar"></script><script async="" src="assets/w.js.descargar"></script><script async="" src="assets/gtm.js(1).descargar"></script><script async="" src="assets/gtm.js(2).descargar"></script><script src="assets/application.js.descargar" async="async"></script>

<link rel="stylesheet" href="css/main.css?ud=<?php echo $unix_date; ?>" />

<style>
    [data-timed-style='fade']{display:none}[data-timed-style='scale']{display:none}
</style>


<script async="" src="assets/js(1)"></script>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap');
  </style>


<link rel="stylesheet" href="assets/style.css">

<!--  chat chaufa 
<script src="assets/cwa-1.js.descargar"></script>   
-->

<script type="text/javascript" async="" src="assets/f.txt"></script>
<script type="text/javascript" async="" src="assets/f(1).txt"></script>
<script src="assets/embed.js.descargar" id="app-convertbox-script" async="" data-uuid="adedbfec-1e79-4b5c-86e1-97a65ef13ee2"></script>
<style type="text/css">
  .addthisevent {visibility:hidden;}.addthisevent-drop ._url,.addthisevent-drop ._start,.addthisevent-drop ._end,.addthisevent-drop ._zonecode,.addthisevent-drop ._summary,.addthisevent-drop ._description,.addthisevent-drop ._location,.addthisevent-drop ._organizer,.addthisevent-drop ._organizer_email,.addthisevent-drop ._attendees,.addthisevent-drop ._facebook_event,.addthisevent-drop ._all_day_event {display:none!important;}</style><style type="text/css" id="ate_css">.addthisevent-drop {display:inline-block;position:relative;font-family:arial;color:#333!important;background:#f4f4f4 url(https://addthisevent.com/gfx/icon-calendar-t1.png) no-repeat 9px 50%;text-decoration:none!important;border:1px solid #d9d9d9;color:#555;font-weight:bold;font-size:14px;text-decoration:none;padding:9px 12px 8px 35px;-moz-border-radius:2px;-webkit-border-radius:2px;-webkit-touch-callout:none;-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;}.addthisevent-drop:hover {border:1px solid #aab9d4;color:#555;font-weight:bold;font-size:14px;text-decoration:none!important;}
  .addthisevent-drop:active {top:1px;}.addthisevent-selected {background-color:#f7f7f7;}.addthisevent_dropdown {width:200px;position:absolute;z-index:99999;padding:6px 0px 0px 0px;background:#fff;text-align:left;display:none;margin-top:-2px;margin-left:-1px;border-top:1px solid #c8c8c8;border-right:1px solid #bebebe;border-bottom:1px solid #a8a8a8;border-left:1px solid #bebebe;-moz-border-radius:2px;-webkit-border-radius:2px;-webkit-box-shadow:1px 3px 6px rgba(0,0,0,0.15);-moz-box-shadow:1px 3px 6px rgba(0,0,0,0.15);box-shadow:1px 3px 6px rgba(0,0,0,0.15);}.addthisevent_dropdown span {display:block;cursor:pointer;line-height:110%;background:#fff;text-decoration:none;font-size:12px;color:#6d84b4;padding:8px 10px 9px 15px;}.addthisevent_dropdown span:hover {background:#f4f4f4;color:#6d84b4;text-decoration:none;font-size:12px;}.addthisevent span {display:none!important;}.addthisevent-drop ._url,.addthisevent-drop ._start, 
  .addthisevent-drop ._end,.addthisevent-drop ._zonecode,.addthisevent-drop ._summary,.addthisevent-drop ._description,.addthisevent-drop ._location,.addthisevent-drop ._organizer,.addthisevent-drop ._organizer_email,.addthisevent-drop ._facebook_event,.addthisevent-drop ._all_day_event {display:none!important;}.addthisevent_dropdown .copyx {width:200px;height:21px;display:block;position:relative;cursor:default;}.addthisevent_dropdown .brx {width:180px;height:1px;overflow:hidden;background:#e0e0e0;position:absolute;z-index:100;left:10px;top:9px;}.addthisevent_dropdown .frs {position:absolute;top:5px;cursor:pointer;right:10px;padding-left:10px;font-style:normal;font-weight:normal;text-align:right;z-index:101;line-height:110%;background:#fff;text-decoration:none;font-size:9px;color:#cacaca;}.addthisevent_dropdown .frs:hover {color:#999!important;} 
</style>

<style id="fit-vids-style">.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}</style><style>.df-clearing-box {
    background: lightgrey;
    padding: 0 10px;
    position: fixed;
    float: left;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    font-size: 20px;
}
</style><style>.df-clearing-box {
    background: lightgrey;
    padding: 0 10px;
    position: fixed;
    float: left;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    font-size: 20px;
}
</style>

<script type="text/javascript" async="" src="assets/f(2).txt"></script>
<script id="ti-js-init" async="" src="assets/tc-app-v444.js.descargar"></script>
<script src="assets/polyfill.min.js.descargar"></script>

</head>


<svg xmlns="http://www.w3.org/2000/svg" style="display: none !important">
  <filter id="grayscale">
    <fecolormatrix type="matrix" values="0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0"></fecolormatrix>
  </filter>
</svg>



<!-- --FLLOTANTE NO te vallas -->
<div class="containerWrapper">

<meta name="robots" content="noindex, nofollow">
<style id="globalHeadlineCSS" data-font-fam="Poppins"> .elHeadlineWrapper[data-htype="headline"]{ font-family: "Poppins", Helvetica, sans-serif !important; } </style>

<?php  
if(  !empty($landings_bigs[0]['emergente_link']) &&   !empty($landings_bigs[0]['imagen_emergente']) &&  $landings_bigs[0]['mostrar_emergente']==1  ){
  include("inc/emergente_flotantes.php");

}
?>



<?php } ?> 