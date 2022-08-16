<HTML>

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

<BODY>
    <script>
        alert("Registro Exitoso!!")
    </script>
    <a href="javascript:esperar(10000)">
        <?php
            header("Location: login.html");
            exit();
        ?>
    </a>
</BODY>

</HTML>