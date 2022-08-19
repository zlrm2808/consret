<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Configuracioón</title>
</head>
<body>
    <?PHP

    $archivo = false;

    if ($archivo === true) {
        echo "hay archivo";
    }
    else {
        echo
        "
        <div class='wrapper fadeInDown'>
            <div id='formContent'>
            <h2>Datos para la Conexion a la BD </h2> <br>
                <div>
                    <form>
                        <input type='text' id='Mostrar' class='fadeIn second' name='Mostrar' placeholder='Nombre para Mostrar'>
                        
                        <input type='submit' class='fadeIn fourth' value='Aceptar'>
                    </form>
                </div>
                <div id='formFooter'>
                    <img src='./images/MS Dynamics.jpg' height='45px'> <br>
                </div>
            </div>
        </div>
        ";
    }


    /*

    IF OBJECT_ID(N'USRCONSRET', N'U') IS NULL
CREATE TABLE USRCONSRET (
	Usuario VARCHAR(10) PRIMARY KEY,
	Pass VARCHAR(20)
);

IF OBJECT_ID(N'EMPCONSRET', N'U') IS NULL
CREATE TABLE EMPCONSRET (
	RIF VARCHAR(10),
	dbname VARCHAR(50)	NOT NULL,
	nomb_emp VARCHAR(250) NOT NULL,
	FOREIGN KEY (RIF) REFERENCES USRCONSRET(Usuario)
);



    */
        
    ?>
</body>
</html>