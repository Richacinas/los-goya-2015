<?php 
session_start();
require_once('../../app/core/class/NoCsrf.php');
include_once('../../app/core/functions_utils.php');

$password = isset($_GET['p']) ? $_GET['p'] : '';


//Se comprueba la existencia y validez del md5 pasado por cabecera.
if ($password != '' && isValidMd5($password)) {  
    if ($password == md5('dRtVe2015goyA')) {
        //Se da valor al token
        $token = NoCSRF::generate( 'csrf_token' );
        $host = "http://lab.rtve.es/los-goya-2015";

?>

<!doctype html>
<html lang="es-es">
    <head>
      <meta charset="utf-8">
      <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
      <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
      <link href="css/styles.css" rel="stylesheet">
    </head>
    <body>

      <div class="page-header">
        <h1>Social Radar Controler <small>lab.rtve.es</small></h1>
        <a id="radar-link" href="/los-goya-2015/radar" target="_blank">Ver Radar</a>
        <form action="<?php print($host);?>/app/twtprocess.php" method="post" name="cleanDataForm" id="cleanDataForm">
          <input type="hidden" name="method" value="cleanData" />
          <input type="submit" name="cleanDataButton" id="cleanDataButton" value="Limpiar todos los datos" />
          <div id="cleanDataPopup">
            <div>¿Realmente quieres borrar todos los datos recogidos del radar?</div>
            <div>
              <input type="submit" name="cleanDataButton" id="cleanDataAccept" value="¡SÍ, borrar todo!" />
              <input type="button" name="reject" id="cleanDataReject" value="NO, me he confundido de botón" />
            </div>
          </div>
          <input type="hidden" id="csrf_token" name="token" value="<?php echo $token; ?>"/>
        </form>
      </div>

      <div id="bl-data">

        <div id="config-list" class="config config-elm-disable">
          <h2>Listado de etiquetas de búsqueda <a href="#" id="muestra-tags" class="muestra"><i class="fa fa-minus"></i></a></h2>
          <div class="config-wrap clearfix">
            <form  id="dataForm" action="../../app/generateJSON.php" name="generateSearchTermsForm" method="post">
              <h3>Tags</h3><div class="tags-input"></div>
              <h3>Terminos</h3><div class="search-input"></div>
              <span id="mensajeTags" class="mensaje"></span>
              <button type="submit" >Guardar</button>           
              <button type="button" onclick="radarControler.searchTerms.anyadirTerminoBusqueda()">Añadir termino</button>         
            </form>
          </div>
        </div>

        <div id="config-streaming" class="config config-elm-disable">
          <h2>Gestion del evento <a href="#" id="muestra-config" class="muestra"><i class="fa fa-minus"></i></a></h2>
          <div class="config-wrap clearfix">
            <form  id="streamForm" action="streamConfig.php" name="streamConfig" method="post">
              <span id="mensajeStreaming" class="mensaje"></span>
              <button type="button" onclick="radarControler.streaming.iniciarEvento()">Iniciar Evento</button>           
              <button type="button" onclick="radarControler.streaming.finalizarEvento()">Finalizar Evento</button>
              <button type="button" onclick="radarControler.streaming.reiniciarEvento()">Reiniciar</button>          
            </form>
          </div>
        </div>

      </div>

      <div id="bl-sidebar">

        <div class="bl-sidebar-bl bl-sidebar-postlink">
          <h2>Inserta un post desde un link:</h2>
          <textarea id="paste-url" placeholder="Pega la url here!" name="" id="" cols="30" rows="10"></textarea>
          <div class="bottom clearfix">
            <a href="#" class="add-grande"><i class="fa fa-stop"></i></a>
            <a href="#" class="add-chico"><i class="fa fa-windows"></i></a>
            <a href="#" class="add-texto"><i class="fa fa-plus"></i></a>
            <select name="select" id="tag-select"><option value="-1">Untagged</option></select>
          </div>
        </div>

        <div class="bl-sidebar-bl">
          <h2 id="settings" class="pointer">Configuracion</h2>
        </div> 

        <div class="bl-sidebar-bl">
          <h2 id="streaming" class="pointer">Elementos enviados:</h2>
        </div>

        <div class="bl-sidebar-bl">
          <h2>Tuits e instagrams de FAVORITOS:</h2>
          <div id="bl-sidebar-list"></div>
        </div>

        <div class="bl-sidebar-bl">
          <h2>STREAM de twitter:</h2>
          <div id="bl-sidebar-list-stream"></div>
        </div>
      </div>
      <script src="js/jquery.min.js"></script>
      <script src="js/jquery-ui.js"></script>
      <script src="js/notify.min.js"></script>
      <script src="js/radarControler.js"></script>
    </body>
</html>

<?php
   } else {
       //No existe md5. Redirección 404??
   }
   
} else {
    //md5 no válido. Redirección 404??
}

?>