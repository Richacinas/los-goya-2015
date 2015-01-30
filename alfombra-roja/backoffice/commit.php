<?php

include '../_partials/utils.php';
$files = $_FILES;

//Se guardan en sesión todos los valores presentes en el formulario
//if( $_POST != null ){
//    foreach($_POST as $campo => $valor) {
//        $_SESSION['registro'][$campo] = $valor;
//    }
//}

//Este bucle subirá las imágenes seleccionadas en el formulario.
$uploadOk = 1;
foreach ($files as $key => $values) {
    if ($values['name'] != '') {
        $splitResult = split("_", $key);
        
        $imageType = $splitResult[2];
        $imageType = preg_replace('/[0-9]+/', '', $imageType); //se elimina el número para obtener tan sólo large o medium
        
        $position = preg_match_all('/\d+/', $splitResult[2], $match);
        $position = $match[0][0];
        $imageName = formatImageName($_POST['name'.$position])."-goya-2015.jpg"; 
        //Si la variable contiene large, entonces es de tipo large y se establece la ruta en fotos/zoom. Si no, entonces será fotos/ además, se renombra según la convención nombre-apellido-goya-2015.jpg por si acaso
        if ($imageType == "large") {
            $target_file = "../fotos/zoom/" . $imageName;
        } else {
            $target_file = "../fotos/" . $imageName;
        }
        
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Chequear si es realmente una imagen
        $check = getimagesize($values['tmp_name']);
        if($check == false) {
            error_log(date('d/m/Y h:i:s')+ " El fichero no es una imagen\n", 3, "../php.log");
            $uploadOk = 0;
        }
        // Se chequea el tamaño del fichero, máximo 5mb
        if ($values['size'] > 3000000) {
            error_log(date('d/m/Y h:i:s') + " Alguna de las imágenes es demasiado pesada.\n", 3, "../php.log");
            $uploadOk = 0;
        }
        // Se permite el formato JPG solamente
        if($imageFileType != "jpg") {
            error_log(date('d/m/Y h:i:s') + " Solo se permite formato de imagen JPG.\n", 3, "../php.log");
            $uploadOk = 0;
        }
        // Se chequea el valor de $uploadOk para actualizar el log
        if ($uploadOk == 0) {
            error_log(date('d/m/Y h:i:s') + " Ha habido un error en el salvado de datos.\n", 3, "../php.log");
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($values['tmp_name'], $target_file)) {
                error_log(date('d/m/Y h:i:s') + "La imagen ". $target_file. " ha sido subida.\n", 3, "../php.log");
            } else {
                error_log(date('d/m/Y h:i:s') + "Ha habido un error subiendo alguna de la/s imagen/es.\n", 3, "../php.log");
            }
        }
    }
}

if ($uploadOk == 1 ) {
    if (count($_POST) > 0) {
        $result = setCsvArray($_POST, $files);
        if (generateCsv($result) == true) { 
            $message = "Se ha guardado correctamente.";
            if (isset($_POST['publish'])) {
                publishCsv();
                copyDir();
            }
        } else {
            $message = "Ha habido un error al guardar. Recuerda que sólo se permiten imágenes JPG.";
        }
    }
} else {
    $message = "Ha habido un error al subir la/s foto/s.";
}

header('Location: /test-los-goya-2015/alfombra-roja/backoffice/?p=cbbabb7feaf39925552bb5690c64d16d&r='.$message);
exit();

?>