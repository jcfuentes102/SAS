

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../estilos.css">
        <meta charset="utf-8">
        <title>PODCAST</title>
    </head>
    <body> 
        <div id="cont">
            <a href="../login/user.php">VOLVER</a>
            <a href="../login/phplogout.php" class="logout">LOGOUT</a>
            <?php
            
            $mostrar = array_diff(scandir("../files"), array('..', '.'));

            echo "<ul>";
            foreach ($mostrar as $key => $value) {
                echo $value;
                echo '<li><img src="'.'../files/'. $value . '"></img></li><br><br>';
            }
            echo "</ul>";
            ?>
        </div>
    </body>
</html>