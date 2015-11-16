<?php

require '../clases/AutoCarga.php';
$cancion = Request::get("cancion");
$session = new Session();
$canciones = $session->get("canciones"); 

if($canciones==null){
    //Otra forma en la clase phpadd de sesion
    $canciones = array();
}

$canciones[]= $cancion;
$session->set("canciones", $canciones);

header("Location:../subir/subirmusica.php");
exit();