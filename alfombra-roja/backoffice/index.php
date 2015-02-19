<?php
session_start();

//require_once('../../app/core/class/NoCsrf.php');
include '../partials/utils.php';

$password = isset($_GET['p']) ? $_GET['p'] : '';
$result = isset($_GET['r']) ? $_GET['r'] : '';

if ($password != '' && isValidMd5($password)) {

   if ($password == md5('dRtVe2015goyA')) {
       $data = getCarouselData(false); 
       $aCarousel = $data[0];
       
       $fecha = date_create();
       //$token = NoCSRF::generate( 'csrf_token' );
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Backoffice - La alfombra roja de los Oscar - Los Oscar 2015</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>

    <script type="text/javascript" src="http://www.rtve.es/js/rtve.pack.js"></script>
    <script language="javascript" type="text/javascript" src="//www.rtve.es/js/mushrooms/rtve_mushroom.js" ></script>
    <script language="javascript" type="text/javascript" src="../js/backoffice.js" ></script>
    
</head>
    <body>
        <div class="backoffice_wrapper">
        <form id="backoffice" method="post" action="commit.php" enctype="multipart/form-data">
            <h1>Administración Lupa / Alfombra Roja</h1>
            <div id="backoffice_instructions">
                <ul>
                    <li>Para los nombres, se aconseja utilizar el formato: <strong>Nombre Apellido.</strong></li>
                    <li><strong>La primera columna (posición) sirve para alterar el orden de los elementos.</strong> Se introduce el índice de cada elemento y hay que asegurarse de que no se repiten.</li>
                    <li>Se consideran los tamaños de las fotos del año pasado como ideales, para foto zoom 1177x1926 (96dpi) y para foto normal 550x900 (96dpi). Alrededor de esas resoluciones estará bien.</li>
                    <li>Máximo <strong>3mb</strong> por foto.</li>
                    <li>Si se desea resaltar alguna parte del texto de pie de foto (columna texto), se puede "rodear" con el tag &lt;strong&gt;. Ejemplo: Jennifer Lopez optó por un escotado vestido de <strong> &lt;strong&gt;Zuhair Murad&lt;strong&gt; </strong>que le... </li>
                    <li>Para enlazar una palabra de la descripción, sitúate delante de la palabra y pega este código: <strong>&lt;a href="URL DE LA NOTICIA QUE QUIERES ENLAZAR"&gt; palabra que quieres enlazar &lt;/a&gt; </strong></li>
                    <li>Los botones de la derecha sirven para <strong>eliminar y añadir</strong> un nuevo elemento (Papelera, Sumar).</li>
                    <li>Una vez realizados los cambios, hay que pulsar sobre el <strong>botón Guardar</strong> de la parte inferior.</li>
					<li>Por el momento y por razones de seguridad en el servidor de producción, sólo se pueden subir <strong>10 fotos a la vez</strong>.</li>
                </ul>
            </div>
            <table id="backoffice_table">
                <thead>
                    <tr>
                        <th>Posición</th>
                        <th>Nombre</th>
                        <th>Foto Zoom</th>
                        <th>Foto Normal</th>
                        <th>Fotógraf@</th>
                        <th>Texto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($aCarousel as $key=>$aElement): 
                        $aElement = escapeArray($aElement);
                        ?>
                    <tr id="row<?php print($key); ?>">
                        <td class="position_cell"><input type="text" class="input_short" id="position<?php print($key); ?>" name="position<?php print($key); ?>" value="<?php echo isset($_POST['position'.$key]) ? $_POST['position'.$key] : $aElement[0]; ?>"/></td>
                        <td class="name_cell"><input type="text" class="input_medium" id="name<?php print($key); ?>" name="name<?php print($key); ?>" value="<?php echo isset($_POST['name'.$key]) ? $_POST['name'.$key] : $aElement[2]; ?>"/></td>
                        <td class="image_cell"><img class="image_large" id="image_large<?php print($key); ?>" name="image_large<?php print($key); ?>" src="<?php echo $baseUrl; ?>fotos/zoom/<?php print($aElement[1]); ?>?t=<?php echo date_timestamp_get($fecha); ?>" onError="handleImageError(this);"/><input class="select_image_large" id="select_image_large<?php print($key); ?>" name="select_image_large<?php print($key); ?>" type="file" value="Examinar"/></td>
                        <td class="image_cell"><img class="image_medium" id="image_medium<?php print($key); ?>" name="image_medium<?php print($key); ?>" src="<?php echo $baseUrl; ?>fotos/<?php print($aElement[1]); ?>?t=<?php echo date_timestamp_get($fecha); ?>" onError="handleImageError(this);"/><input class="select_image_medium" id="select_image_medium<?php print($key); ?>" name="select_image_medium<?php print($key); ?>" type="file" value="Examinar"/></td>
                        <td class="photographer_cell"><input type="text" class="input_medium" id="photographer<?php print($key); ?>" name="photographer<?php print($key); ?>" value="<?php echo isset($_POST['photographer'.$key]) ? $_POST['photographer'.$key] : $aElement[3]; ?>"/></td>
                        <td class="text_cell"><textarea id="text<?php print($key); ?>" name="text<?php print($key); ?>" rows="6" cols="35"><?php echo isset($_POST['text'.$key]) ? $_POST['text'.$key] : $aElement[4]; ?></textarea></td>
                        <td class="id_cell"><input type="text" class="carousel_element_id" id="id<?php print($key); ?>" name="id<?php print($key); ?>" value="<?php echo isset($_POST['id'.$key]) ? $_POST['id'.$key] : $aElement[5]; ?>"/></td>
                        <td class="action_cell"><img class="delete_item" id="delete_item<?php print($key); ?>" name="delete_item<?php print($key); ?>" src="../images/delete.png"/></td>
                    </tr>
                  <?php endforeach; ?>
                    
                    <tr id="row<?php print($key + 1); ?>">
                        <td class="position_cell"><input type="text" class="input_short" id="position<?php print($key + 1); ?>" name="position<?php print($key + 1); ?>" value=""/></td>
                        <td class="name_cell"><input type="text" class="input_medium" id="name<?php print($key + 1); ?>" name="name<?php print($key + 1); ?>" value=""/></td>
                        <td class="image_cell"><img class="image_large" id="image_large<?php print($key + 1); ?>" name="image_large<?php print($key + 1); ?>" src="<?php echo $baseUrl; ?>fotos/zoom/silueta-los-oscar-2015.jpg"/><input class="select_image_large" id="select_image_large<?php print($key + 1); ?>" name="select_image_large<?php print($key + 1); ?>" type="file" value="Examinar"/></td>
                        <td class="image_cell"><img class="image_medium" id="image_medium<?php print($key + 1); ?>" name="image_medium<?php print($key + 1); ?>" src="<?php echo $baseUrl; ?>fotos/silueta-los-oscar-2015.jpg"/><input class="select_image_medium" id="select_image_medium<?php print($key + 1); ?>" name="select_image_medium<?php print($key + 1); ?>" type="file" value="Examinar"/></td>
                        <td class="photographer_cell"><input type="text" class="input_medium" id="photographer<?php print($key + 1); ?>" name="photographer<?php print($key + 1); ?>" value=""/></td>
                        <td class="text_cell"><textarea id="text<?php print($key + 1); ?>" name="text<?php print($key + 1); ?>" rows="6" cols="35"></textarea></td>
                        <td class="id_cell"><input type="text" class="carousel_element_id" id="id<?php print($key + 1); ?>" name="id<?php print($key + 1); ?>" value=""/></td>
                        <td class="action_cell"><img class="add_item" id="add_item" name="add_item" src="../images/add.png"/></td>
                    </tr>
                </tbody>
            </table>
            <p id="commit_result"><?php print($result); ?></p>
            <div class="button_container">
                <input type="submit" id="save" name="save" value="Guardar"/>
                <input type="submit" id="publish" name="publish" value="Publicar todo"/>
            </div>
            <input type="hidden" name="csrf_token" value="<?php echo $token; ?>"/>
        </form>
    </div>
    </body>
</html>

<?php
   } else {

   }
   
} else {
 
}

?>
