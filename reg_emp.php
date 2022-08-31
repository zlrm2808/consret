<head>
    <script>
        function esperar(espera) {
            string = "pausa_alerta(" + espera + ");";
            setTimeout(string, espera);
        }

        function pausa_alerta(espera) {
            alert("Ok " + espera / 1000 + " Segundos");
        }
    </script>
</HEAD>

<?php

include_once("conexion.php");

$usuario = $_POST["Usuario"];
$password = $_POST["Contraseña"];
$password2 = $_POST["Contraseña2"];
$conteo = 0;

// Consulta para buscar en las diferentes bases de datos del sistema 
// y comprobar si el proveedor existe en alguna de ellas

$sql = ("DECLARE @rn INT = 1, @dbname varchar(MAX) = '', @conteo int = 0, @query VARCHAR(MAX);
        WHILE @dbname IS NOT NULL
        BEGIN
            SET @dbname = (SELECT INTERID FROM (SELECT INTERID, ROW_NUMBER() OVER (ORDER BY INTERID) rn
                FROM DYNAMICS..SY01500 WHERE INTERID NOT IN('PRUEB', 'TWO', 'DESAR', 'TEST','T0001','T0002')) t WHERE rn = @rn);
            IF @dbname <> '' AND @dbname IS NOT NULL

            EXEC ('use ['+@dbname+'];
                SELECT PV_MI_idprov
                FROM IMPP0161
                WHERE PV_MI_idprov = ''".$usuario. "''
                    ')
            SET @conteo = @conteo + @@ROWCOUNT;
            SET @rn = @rn + 1;
        END");

// Verifico si efectivamente el proveedor existe en alguna BD

$stmt = sqlsrv_query($conn, $sql);
$affectedRows = array();
do {
    if(sqlsrv_rows_affected($stmt)!=0){
        $conteo += 1;
    }
} while (sqlsrv_next_result($stmt));

if ($conteo == 0) {
    echo '<script>alert("RIF no se encuentra en nuestra Base de Datos","error");
                    window.location.replace("register.html")</script>';

// Verifico que la contraseña intrudicida para el registro sea igual em ambos campos 

}else { if ($password != $password2) {
        echo '<script>alert("Las contraseñas no coinciden","error");
                    window.location.replace("register.html")</script>';
    }
};

// Verifico que el RIF no este refistrado en la aplicacion 

$sql = ("SELECT * FROM DYNAMICS.dbo.USRCONSRET 
        WHERE Usuario = '" . $usuario . "'" );

$stmt = sqlsrv_query($conn, $sql);
$rows_affected = sqlsrv_rows_affected($stmt);
if($rows_affected != 0){
    echo '<script>alert("RIF ya se encuentra registrado en nuestra Base de Datos","error");
                    window.location.replace("register.html")</script>';
}

// Valido el Registro del usuario

$sql = ("INSERT INTO DYNAMICS.dbo.USRCONSRET
        VALUES('".$usuario."','".$password."')");
$stmt = sqlsrv_query($conn, $sql);
$rows_affected = sqlsrv_rows_affected($stmt);
if ($rows_affected != 0) {
    echo '<script>alert("Registrado Correctamente","registro");
                    window.location.replace("login.php")</script>';
}

?>