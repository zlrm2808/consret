<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=>, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
        include_once("conexion.php");

        $sql = ("SELECT nomp_prov,
                        nomb_emp,
                        dbname
                FROM EMPCONSRET
                WHERE RIF = 'J309672371'");

        $stmt = sqlsrv_query($conn, $sql);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo '
                <select name="empresas" id="">';
                    while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        echo '<option value="'. $row["dbname"].'">'.$row["nomb_emp"].'</option>';
                    }
                '</select>';
        }
    ?>
</body>

</html>