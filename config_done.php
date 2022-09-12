<?php
$SERVIDOR = $_POST["server"];
$EMPRESA = $_POST["nomemp"];
//Si se quiere subir una imagen
if (isset($_POST['subir'])) {
    $file = fopen("config.ini", "w");
    fwrite($file, $SERVIDOR . PHP_EOL);
    fwrite($file, $EMPRESA);
    fclose($file);

    //Recogemos el archivo enviado por el formulario
    $archivo = $_FILES['logoemp']['name'];
    //Si el archivo contiene algo y es diferente de vacio
    if (isset($archivo) && $archivo != "") {
        //Obtenemos algunos datos necesarios sobre el archivo
        $tipo = $_FILES['logoemp']['type'];
        $tamano = $_FILES['logoemp']['size'];
        $temp = $_FILES['logoemp']['tmp_name'];
        //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
        if (!((strpos($tipo, "gif")  || strpos($tipo, "jpeg") || strpos($tipo, "png")) && ($tamano < 2000000))) {
            echo '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
            - Se permiten archivos .gif, .jpg, .png. y de 200 kb como máximo.</b></div>';
        } else {
            //Si la imagen es correcta en tamaño y tipo
            //Se intenta subir al servidor
            $archivo = 'logo-emp.png';
            if (move_uploaded_file($temp, 'images/' . $archivo)) {
                //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                chmod('images/' . $archivo, 0777);
                //Mostramos el mensaje de que se ha subido co éxito
                //echo '<div><b>Se ha subido correctamente la imagen.</b></div>';
                //Mostramos la imagen subida
                //echo '<p><img src="images/' . $archivo . '"></p>';
            } else {
                //Si no se ha podido subir la imagen, mostramos un mensaje de error
                echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
            }
        }
    }
    //Recogemos el archivo enviado por el formulario
    $archivo = $_FILES['logoret']['name'];
    //Si el archivo contiene algo y es diferente de vacio
    if (isset($archivo) && $archivo != "") {
        //Obtenemos algunos datos necesarios sobre el archivo
        $tipo = $_FILES['logoret']['type'];
        $tamano = $_FILES['logoret']['size'];
        $temp = $_FILES['logoret']['tmp_name'];
        //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
        if (!((strpos($tipo, "gif")  || strpos($tipo, "jpeg") || strpos($tipo, "png")) && ($tamano < 2000000))) {
            echo '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
            - Se permiten archivos .gif, .jpg, .png. y de 200 kb como máximo.</b></div>';
        } else {
            //Si la imagen es correcta en tamaño y tipo
            //Se intenta subir al servidor
            $archivo = 'logo-ret.png';
            if (move_uploaded_file($temp, 'images/' . $archivo)) {
                //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                chmod('images/' . $archivo, 0777);
                //Mostramos el mensaje de que se ha subido co éxito
                //echo '<div><b>Se ha subido correctamente la imagen.</b></div>';
                //Mostramos la imagen subida
                //echo '<p><img src="images/' . $archivo . '"></p>';
            } else {
                //Si no se ha podido subir la imagen, mostramos un mensaje de error
                echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
            }
        }
    }
    //Recogemos el archivo enviado por el formulario
    $archivo = $_FILES['firmaysello']['name'];
    //Si el archivo contiene algo y es diferente de vacio
    if (isset($archivo) && $archivo != "") {
        //Obtenemos algunos datos necesarios sobre el archivo
        $tipo = $_FILES['firmaysello']['type'];
        $tamano = $_FILES['firmaysello']['size'];
        $temp = $_FILES['firmaysello']['tmp_name'];
        //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
        if (!((strpos($tipo, "gif")  || strpos($tipo, "jpeg") || strpos($tipo, "png")) && ($tamano < 2000000))) {
            echo '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
            - Se permiten archivos .gif, .jpg, .png. y de 200 kb como máximo.</b></div>';
        } else {
            //Si la imagen es correcta en tamaño y tipo
            //Se intenta subir al servidor
            $archivo = 'FirmaySello.png';
            if (move_uploaded_file($temp, 'images/' . $archivo)) {
                //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                chmod('images/' . $archivo, 0777);
                //Mostramos el mensaje de que se ha subido co éxito
                //echo '<div><b>Se ha subido correctamente la imagen.</b></div>';
                //Mostramos la imagen subida
                //echo '<p><img src="images/' . $archivo . '"></p>';
            } else {
                //Si no se ha podido subir la imagen, mostramos un mensaje de error
                echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
            }
        }
    }
    echo '<script>
            alert("Datos Guardados Correctamente!");
            window.location.replace("index.html")
        </script>';
}
