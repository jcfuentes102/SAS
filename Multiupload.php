<?php
class Multiupload
{
 
    /**
    *sube archivos al servidor a través de un formulario
    *@access public
    *@param array $files estructura de array con todos los archivos a subir
    */
    public function upFiles($files = array())
    {
        //inicializamos un contador para recorrer los archivos
        $i = 0;
 
        //si no existe la carpeta files la creamos
        if(!is_dir("files/")) 
            mkdir("files/", 0777);
         
        //recorremos los input files del formulario
        foreach($files as $file) 
        {
            //si se está subiendo algún archivo en ese indice
            if($_FILES['userfile']['tmp_name'][$i])
            {
                //separamos los trozos del archivo, nombre extension
                $trozos[$i] = explode(".", $_FILES["userfile"]["name"][$i]);
 
                //obtenemos la extension
                $extension[$i] = end($trozos[$i]);
 
                //si la extensión es una de las permitidas
                if($this->checkExtension($extension[$i]) === TRUE)
                {
 
                    //comprobamos si el archivo existe o no, si existe renombramos 
                    //para evitar que sean eliminados
                    $_FILES['userfile']['name'][$i] = $this->checkExists($trozos[$i]);           
 
                    //comprobamos si el archivo ha subido
                    if(move_uploaded_file($_FILES['userfile']['tmp_name'][$i],"files/".$_FILES['userfile']['name'][$i]))
                    {
                        echo "<p style='position:relative; top:300px; left: 1000px;'>subida correctamente</p>";
                        //aqui podemos procesar info de la bd referente a este archivo
                    } 
                //si la extension no es una de las permitidas
                }else{
                    echo "<p style='position:relative; top:300px; left: 1000px;'>la extension no esta permitida</p>";
                }
            //si ese input file no ha sido cargado con un archivo
            }else{
                echo "<p style='position:relative; top:300px; left: 1000px;'>sin imagen</p>";
            }
            echo "<br />";
            //en cada pasada por el loop incrementamos i para acceder al siguiente archivo
            $i++;     
        }   
    }
 
    /**
    *funcion privada que devuelve true o false dependiendo de la extension
    *@access private
    *@param string 
    *@return boolean - si esta o no permitido el tipo de archivo
    */
    private function checkExtension($extension)
    {
        //aqui podemos añadir las extensiones que deseemos permitir
        $extensiones = array("jpg","png","gif","pdf");
        if(in_array(strtolower($extension), $extensiones))
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }
 
    /**
    *funcion que comprueba si el archivo existe, si es asi, iteramos en un loop 
    *y conseguimos un nuevo nombre para el, finalmente lo retornamos
    *@access private
    *@param array 
    *@return array - archivo con el nuevo nombre
    */
    private function checkExists($file)
    {
        //asignamos de nuevo el nombre al archivo
        $archivo = $file[0] . '.' . end($file);
        $i = 0;
        //mientras el archivo exista entramos
        while(file_exists('files/'.$archivo))
        {
            $i++;
            $archivo = $file[0]."(".$i.")".".".end($file);       
        }
        //devolvemos el nuevo nombre de la imagen, si es que ha 
        //entrado alguna vez en el loop, en otro caso devolvemos el que
        //ya tenia
        return $archivo;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="Description" content="Oficina Virtual Sistema Sanitario Publico Andalucia" />
    <title>Servicio de diagnóstico por imagen</title>
    <link rel="stylesheet" type="text/css" href="estilo/intersas.css" />
    </head>
    <body>
        <div style="width: 24%; float:left; padding: 0px;">
            <map name="logocorporativo" id="logocorporativo">
                <area href="#contenido_principal" shape="rect" coords="1, 0, 202, 5" accesskey="s" alt="Acceso al contenido principal de esta página" title="Acceso al contenido principal de esta página" />
                <area href="http://www.andaluciajunta.es/" shape="rect" coords="1, 6, 68, 64" target="_blank" alt="Acceso en una nueva ventana a la página web de la Junta de Andalucía" title="Acceso en una nueva ventana a la página web de la Junta de Andalucía"/>
                <area href="http://www.juntadeandalucia.es/servicioandaluzdesalud/" shape="rect" coords="81, 28, 202, 38" target="_blank" alt="Acceso en una nueva ventana a la página web del Servicio Andaluz de Salud" title="Acceso en una nueva ventana a la página web del Servicio Andaluz de Salud"/>
                <area href="http://www.juntadeandalucia.es/salud" shape="rect" coords="80, 44, 202, 54" target="_blank" alt="Acceso en una nueva ventana a la página web de la Consejería de Salud" title="Acceso en una nueva ventana a la página web de la Consejería de Salud"/>
            </map>
            <img src="img/logo_consejeria_verde_2015_07.gif" style="border: medium none;" usemap="#logocorporativo" alt="" height="64"/>
        </div>
        <div class="tabla_formulario" style="text-align:center;padding-top:2px; padding-bottom:9px; border:0px;">
            <h2 class="etiquetas_campos" style="padding-bottom: 0px; margin-bottom: 0px;">
                <img style="border:none" src="img/cuadradito_verde.gif" alt="" />&nbsp;
                Acceso a servicios personales 
                (<a class="enlaces2" href="/pls/intersas/servicios.motivos_identificacion" title="Razones por las que es conveniente identificarse en este portal">&iquest;Por qu&eacute; identificarse?&nbsp;</a>):
            </h2>
            <br />
            <form method="post" action="login/index.php">
            <ul style="display:inline;">
                <li style="display:inline; padding-right:20px">
                    <a href="/pls/intersas/servicios.inicio_identificacion?tipo_identificacion=1" class="boton_identificacion" title="Acceso a identificación con Certificado Digital">Mediante Certificado Digital</a>
                <li style="display:inline; padding-left:10px">
                    <input type="submit" class="boton_identificacion" value="Acceso a identificación sin Certificado Digital"/>
                </li>
            </ul>
        </form>
        </div>
        <div id="menu_lateral">
            <dl style="display:inline; padding:0">
                <dt class="titulo">
                    <a href="servicios.inicio" title="P&aacute;gina de Inicio de InterS@S" class="anagrama"><abbr title="InterSaS">INTERS@S</abbr></a>
                </dt>
                <dt class="menu_servicios">
                    <a href="servicios.carpeta_salud.tramite_enlinea_cs" class="enlaces_servicios" title="Acceso a Clic Salud">Clic Salud</a>
                </dt>
                <dt class="menu_servicios">
                    <a href="servicios.informacion_tarjeta" class="enlaces_servicios" title="Acceso a p&#225;gina de informaci&#243;n sobre la Tarjeta Sanitaria." >Tarjeta Sanitaria</a>
                </dt>
                <dt class="menu_servicios">
                    <a href="servicios.datos_usuario_consulta" class="enlaces_servicios" title="Acceso a consulta de datos personales.">Consulta de datos personales</a>
                </dt>
                <dt class="menu_servicios">
                    <a href="servicios.tramite_enlinea_citamedico" class="enlaces_servicios" title="Obtención de citas para su médico.">Cita para el médico</a>
                </dt>
                <dt class="menu_servicios">
                    <a href="servicios.tramite_enlinea_citamedico?p_id_servicio=2" class="enlaces_servicios" title="Obtención de citas para vacunación antigripal.">Cita para vacunación antigripal</a>
                </dt>
                <dt class="menu_servicios">
                    <a href="servicios.tramite_enlinea_medico" class="enlaces_servicios" title="Acceso a cambio de m&#233;dico de atenci&#243;n primaria.">Elecci&#243;n de M&#233;dico</a>
                </dt>
                <dt class="menu_servicios">
                    <a href="servicios.tramite_enlinea_domicilio" class="enlaces_servicios" title="Acceso a modificaci&#243;n de datos de contacto.">Cambio de datos de contacto</a>
                </dt>
                <dt class="menu_servicios">
                    <a href="servicios.tramite_enlinea_desplazamiento" class="enlaces_servicios" title="Acceso a realizaci&#243;n de un desplazamiento temporal.">Desplazamiento temporal a otro municipio</a>
                </dt>
                <dt class="menu_servicios">
                    <a href="servicios.rdq.tramite_enlinea_rdq" class="enlaces_servicios" title="Intervenciones quirúrgicas sujetas a garantía de tiempo de respuesta">Lista de Espera Quirúrgica</a>
                </dt>
                <dt class="menu_servicios">
                    <a href="servicios.tramite_enlinea_seg_opinion"  class="enlaces_servicios" title="Acceso a Segunda Opini&#243;n M&#233;dica.">Segunda Opini&#243;n M&#233;dica</a>
                </dt>
                <dt class="menu_servicios">
                    <a href="servicios.descarga_de_formularios" class="enlaces_servicios" title="Acceso a descarga de Formularios.">Formularios Disponibles</a>
                </dt>
                <dt class="menu_contactar">
                    <a href="http://www.juntadeandalucia.es/servicioandaluzdesalud/sugerencias/suger.asp?idp=3A5734812AB44%7C2756A3%7C14AB5F&ctrl=%5B51413169493153%5D" class="enlaces_contactar" title="Acceso a la p&#225;gina de sugerencias del Servicio Andaluz de Salud."><img style="border: none;" src="img/ic_suge.gif" alt="" width="22" height="20" /><br />Sugerencias</a>
                </dt>
                <dt class="menu_administracion">
                    <a href="http://www.juntadeandalucia.es/SaludResponde/AppMovil/" class="enlaces_contactar" title="Acceso a la web de App Cita Médica"><span style="text-decoration: underline; padding-left: 2%; padding-right: 2%;">App Cita Médica</span></a>
                </dt>
                <dt class="menu_administracion">
                    <a href="https://www.juntadeandalucia.es/salud/rv2/inicioCiudadania.action" class="enlaces_contactar" title="Registro de Voluntades Vitales Anticipadas"><span style="text-decoration: underline; padding-left: 2%; padding-right: 2%;">Registro de Voluntades Vitales Anticipadas</span></a>
                </dt>
                <dt class="menu_administracion" style="border-top-width:1px; border-top-style:outset; border-top-color: none;">
                    <a href="http://www.juntadeandalucia.es/temas/personas/administracion/ae.html" class="enlaces_contactar" title="Servicios de administraci&oacute;n electr&oacute;nica de la Junta de Andaluc&iacute;a">&nbsp;<span style="font-size: 1.7 em;">@</span><span style="text-decoration: underline; padding-left: 2%; padding-right: 2%;"> e-Administración&nbsp;</span></a>
                </dt>
                <dt class="menu_final">
                    <a href="servicios.informacion_intersas" class="enlaces2" title="Informaci&oacute;n sobre InterS@S">Qu&eacute; es InterS@S</a>
                </dt>
                <dt class="menu_final">
                    <a href="servicios.infor_certificado_digital" class="enlaces2" title="Acceso a obtenci&oacute;n de Certificado Digital.">Certificado digital</a>
                </dt>
                <dt class="menu_final">
                    <a href="servicios.seguridad_y_acceso" class="enlaces2" title="Informaci&oacute;n sobre seguridad y acceso a este portal">Seguridad y Acceso</a>
                </dt>
                <dt class="menu_final">
                    <a href="servicios.informacion_accesibilidad" class="enlaces2" title="Informaci&oacute;n sobre accesibilidad">Accesibilidad del sitio</a>
                </dt>
            </dl>
        </div>
        <div id="imagen_central">
            <br />
            <div class="situacion">
                <h1 id="titulo_pagina" class="etiquetas_campos">
                    <a name="contenido_principal">Servicio de diagnóstico por imagen</a>
                </h1>
            </div>
            <ul id="second_menu">
                <li class="disponible"><a href="servicios.informacion_cita_medica" class="enlace_second_menu">Informaci&oacute;n</a></li>
                <li class="actual">Tr&aacute;mite en l&iacute;nea</li>
            </ul>
            <div style="padding-top:1%; padding-bottom:2%; width:99%; text-align:justify;">
                <p class="letra_general" style="text-align: justify; padding: 1px;">Servicio de tramitación de cita: solicitud, cancelación y consulta.</p>
                <p class="letra_general" style="text-align: justify; padding: 10px;">Si lo desea puede <a href="/pls/intersas/servicios.inicio_identificacion?tipo_identificacion=1" class="enlaces2">identificarse con Certificado Digital</a>.</p>
                <p class="letra_general" style="text-align: justify; padding: 2px;"><img style="border:none" src="img/tramite_en_linea.gif" alt="" />&nbsp;Anote los datos de la persona para la que desee tramitar la cita y pulse <em>Conectar</em>:</p>
                <div style="margin-left: 2%;  width: 90%;">
                    <form name="Formulario_validacion"  class="tabla_formulario" style="padding: 0.5em; width: 99%; background-color: #f5f5f5;" title="Identificación sin Certificado Digital" method="post" action="sas_subir.php" enctype="multipart/form-data" >
                        <label for="nuss" class="etiquetas_campos"><img style="border:none" src="img/cuadradito_verde.gif" alt="" />&nbsp;&nbsp;Nº de Tarjeta Sanitaria:</label>
                        <input required class="campos" type="text" id="nuss" name="id_us" size="17" maxlength="12"  style="position:relative; left:6%;" />
                        <br/>
                        <fieldset style="padding-bottom: 1em; border: 0px; margin-top: 10px;" title="Fecha de Nacimiento">
                            <legend class="etiquetas_campos" style="margin-left: -1.2%;">
                                <img style="border:none" src="img/cuadradito_verde.gif" alt="" />&nbsp;&nbsp;Fecha de Nacimiento:&nbsp;&nbsp;
                            </legend>
                            <div style="position:relative; left:25%;">
                                <label for="dia_id" class="etiquetas_campos">D&iacute;a</label>
                                <input required type="text" class="campos" name="dia" id="dia_id" size="2" maxlength="2" />
                                <label for="mes_id" class="etiquetas_campos">Mes</label>
                                <input required type="text" class="campos" name="mes" id="mes_id" size="2" maxlength="2" />
                                <label for="anio_id" class="etiquetas_campos">A&ntilde;o</label>
                                <input required type="text" class="campos" name="anio" id="anio_id" size="4" maxlength="4" />
                            </div>
                        </fieldset>
                        <fieldset style="border: 0px;" title="Documento Identificativo">
                            <legend class="etiquetas_campos" style="margin-left: -1.2%; padding-bottom: 6px;">
                                <img style="border:none" src="img/cuadradito_verde.gif" alt="" />&nbsp;&nbsp;Documento Identificativo
                                <span class="letra_general_2" style="font-size: 90%; font-weight: normal;">(Obligatorio para mayores de 14 a&ntilde;os)</span>:
                            </legend>
                            <div style="position:relative; left:15%;">
                                <label for="identificador" class="etiquetas_campos">Tipo:</label>
                                <select class="campos" id="identificador" name="Tipo_Id">
                                    <option value="1" selected="selected">D.N.I.</option>
                                    <option value="4">Otros</option>
                                    <option value="2">Pasaporte</option>
                                    <option value="3">Tarjeta de Extranjero</option>
                                </select>
                                <label for="dni" class="etiquetas_campos">Número: </label>
                                <input required type="text" class="campos" name="dni" size="13" id="dni" maxlength="10" value="" />
                            </div>
                        </fieldset>
                        <fieldset style="border: 0px;" title="Imágenes tele diagnóstico">
                            <legend class="etiquetas_campos" style="margin-left: -1.2%; padding-bottom: 6px;">
                                <img style="border:none" src="img/cuadradito_verde.gif" alt="" />&nbsp;&nbsp;Imágenes tele diagnóstico
                            </legend>
                            <div style="position:relative; left:15%;">
                                <input type="button" class="boton" id="btSubir" value="Agregar" />
                            </div>
                            <div id="imagenesSubir">
                            </div>
                            <div id="inputSubir" style="display:none;">
                            </div>
                        </fieldset>
                        <div style="position: relative; left: 20%;">
                            <input type="submit" value="Enviar" class="boton" style="margin-top: 6px; position:relative; left:15%; cursor: pointer; cursor: hand;" title="Pulse para identificarse sin Certificado Digital y subir sus imágenes" />
                            <input type="hidden" value="1" name="origen" id="origen"/>
                        </div>
                    </form>
                </div>
                <br />
                <br />
            </div>
            <br />
            <div id="direcciones_junta">
                <ul style="margin-left:0px; padding-left:0px;" title="Lista con enlaces a direcciones web de la Junta de Andaluc&iacute;a">
                    <li><a href="http://www.juntadeandalucia.es/servicioandaluzdesalud/" title="Ir a la p&aacute;gina web del Servicio Andaluz de Salud">Servicio Andaluz de Salud</a></li>
                    <li><a href="http://www.juntadeandalucia.es/salud/principal/" title="Ir a la p&aacute;gina web de la Consejer&#237;a de Salud">Consejer&#237;a de Salud</a></li>
                    <li><a href="http://www.andaluciajunta.es" title="Ir a la p&aacute;gina web de la Junta de Andaluc&iacute;a">JUNTA DE ANDALUC&#205;A</a></li>
                </ul>
            </div>
            <span class="texto_oculto">Fin de la p&aacute;gina</span>
        </div>
        <script src="js/intersas.js"></script>
    </body>
</html>