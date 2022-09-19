<?php
$SERVIDOR = $_POST["server"];
$USERBD = $_POST["UsuarioDB"];
$PASSBD = $_POST["PassDB"];
$EMPRESA = $_POST["nomemp"];
$URL = $_POST["webp"];
//Si se quiere subir una imagen
if (isset($_POST['subir'])) {
    $file = fopen("config.ini", "w");
    fwrite($file, $SERVIDOR . PHP_EOL);
    fwrite($file, "DYNAMICS" . PHP_EOL);
    fwrite($file, $USERBD . PHP_EOL);
    fwrite($file, $PASSBD . PHP_EOL);
    fwrite($file, $EMPRESA . PHP_EOL);
    fwrite($file, $URL);
    fclose($file);

    $file = fopen("config.cone", "w");
    fwrite($file, $SERVIDOR . PHP_EOL);
    fwrite($file, "DYNAMICS" . PHP_EOL);
    fwrite($file, $USERBD . PHP_EOL);
    fwrite($file, $PASSBD);
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
    include_once("conexionIni.php");

    $sql = ("USE [DYNAMICS]
            IF OBJECT_ID(N'dbo.USRCONSRET', N'U') IS NULL
            CREATE TABLE [dbo].[USRCONSRET](
                [Usuario] [varchar](10) NOT NULL,
                [Pass] [varchar](20) NULL,
            PRIMARY KEY CLUSTERED 
            (
                [Usuario] ASC
            )WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
            ) ON [PRIMARY]

            IF OBJECT_ID(N'dbo.EMPCONSRET', N'U') IS NULL
            CREATE TABLE [dbo].[EMPCONSRET](
                [RIF] [varchar](10) NOT NULL,
                [nomp_prov] [varchar](250) NOT NULL,
                [dbname] [varchar](50) NOT NULL,
                [nomb_emp] [varchar](250) NOT NULL
            ) ON [PRIMARY]

            ALTER TABLE [dbo].[EMPCONSRET]  WITH CHECK ADD FOREIGN KEY([RIF])
            REFERENCES [dbo].[USRCONSRET] ([Usuario])");

    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } 

    echo '<script>
            alert("Datos Guardados Correctamente!");
            window.location.replace("index.php")
        </script>';
}
