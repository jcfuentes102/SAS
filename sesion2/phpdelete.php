<?php

session_start();
session_destroy; //Borra todas las variables de sesión
if(isset($_SESSION['canciones'])){
    unset($_SESSION["canciones"]); // sólo borra la variable de sesion canciones
}

header("Location:../subir/subirmusica.php");