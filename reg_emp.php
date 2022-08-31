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
$contador = 0;

$sql = ("DECLARE @rn INT = 1, @dbname varchar(MAX) = '', @conteo int = 0, @query VARCHAR(MAX);
        WHILE @dbname IS NOT NULL
        BEGIN
            SET @dbname = (SELECT INTERID FROM (SELECT INTERID, ROW_NUMBER() OVER (ORDER BY INTERID) rn
                FROM DYNAMICS..SY01500 WHERE INTERID NOT IN('PRUEB', 'TWO', 'DESAR', 'TEST','T0001','T0002')) t WHERE rn = @rn);
            IF @dbname <> '' AND @dbname IS NOT NULL

            EXEC ('use ['+@dbname+'];
                SELECT PV_MI_idprov
                FROM IMPP0161
                WHERE PV_MI_idprov = ''".$usuario."''
                    ')
            WITH RESULT SETS
            (([ID] VARCHAR(MAX)))
            SET @conteo = @conteo + @@ROWCOUNT;
            SET @rn = @rn + 1;
        END;
        SELECT IIF(@CONTEO > 0 ,'EXISTE','NO EXISTE') AS EXISTENCIA;");

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo 'hola'. $row['@conteo'];
}

sqlsrv_free_stmt($stmt);


/*
foreach (sqlsrv_field_metadata($stmt) as $fieldMetadata) {
    foreach ($fieldMetadata as $name => $value) {
        echo "$name: $value<br />";
    }
    echo "<br />";
}

*/
/*
$rows_affected = sqlsrv_rows_affected($stmt);
if ($rows_affected != 0 ) {
    echo 'EXISTE';
    ECHO $rows_affected;
} else {
    echo 'NO ENCONTRO NADA';
    echo $rows_affected;
    echo $sql;
}
*/

die;
/*
$rows_affected = sqlsrv_rows_affected($stmt);
if ($rows_affected != 0) {
    echo "ENCONTRADO";
} else {
    echo "no encontrado    ";
}

$sql = ("SELECT PV_MI_idprov,
                PV_MI_nompro
        FROM IMPP0161
        WHERE PV_MI_idprov = '" . $usuario . "' ;
        "
);

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    echo "EL RIF INDICADO NO SE ENCUENTRA EN NUESTRA BASE DE DATOS";
} else {
    echo '<script>alert("Registro Exitoso!!")</script>';
    
    //header("Location: login.html");
    //exit();
    
    if ($password != $password2) {
        echo "Las contraseñas no coinciden";
    } else {
        $sql = ("INSERT INTO ");
    }
}
*/
?>