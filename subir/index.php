<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../estilos.css">
        <meta charset="utf-8">
        <title>PODCAST</title>
    </head>
    <body> 
        <div id="cont">
        <form action="subirmusica.php" method="post" enctype="multipart/form-data">
            <input type="text" name="categoria" value="" placeholder="categoria"/>
            <input type="file" name="archivo" multiple/>
            <input type="submit" />
        </form>
            <a href="../login/user.php">VOLVER</a>
            <a href="phplogout.php" class="logout">LOGOUT</a>
        </div>
    </body>
</html>
