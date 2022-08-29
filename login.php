<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Document</title>
</head>
<body>
    <?PHP
        $file = fopen("config.cone", "w");
        fwrite($file, "PROGRAMADOR-02" . PHP_EOL);
        fwrite($file, "DYNAMICS");
        fclose($file);
    ?>

    <div class="wrapper fadeInDown">
        <div class="empresa">
            <h1>FOSPUCA</h1>
        </div>
        <div id="formContent">
            <!-- Tabs Titles -->
            <h2 class="active"><a href="#">Iniciar Sesion</a></h2>
            <h2 class="inactive underlineHover"><a href="./register.html">Registrarse</a></h2>
    
            <!-- Icon -->
            <div class="fadeIn first">
                <img src="./images/VOG-horiz-blue.png" height="40px"> <br>
                <span>Comprobantes de Retención Online </span> <br>
            </div>
            <div>
            <!-- Login Form -->
                <form action="./selemp.php" method="post">
                    <input type="text" id="Usuario" class="fadeIn second" name="Usuario" placeholder="Ingrese su RIF">
                    <input type="Password" id="Contraseña" class="fadeIn third" name="Contraseña" placeholder="Ingrese su Contraseña">
                    <input type="submit" class="fadeIn fourth" value="Iniciar Sesión">
                </form>
            </div>
            <!-- Remind Passowrd -->
            <div id="formFooter">
                <img src="./images/MS Dynamics.jpg" height="45px"> <br>
                <!-- <a class="underlineHover" href="#">Olvido su Contraseña?</a> -->
            </div>
     
        </div>
    </div>
</body>
</html>