<?php
//Si se quiere subir una imagen
if (isset($_POST[$nombre_post])) {
   //Recogemos el archivo enviado por el formulario
   $archivo = $_FILES['archivo']['name'];
   //Si el archivo contiene algo y es diferente de vacio
   if (isset($archivo) && $archivo != "") {
      //Obtenemos algunos datos necesarios sobre el archivo
      $tipo = $_FILES['archivo']['type'];
      $tamano = $_FILES['archivo']['size'];
      $temp = $_FILES['archivo']['tmp_name'];
      //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
     if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")|| strpos($tipo, "webp")) && ($tamano < 2000000))) {
        echo '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
        - Se permiten archivos .gif, .jpg, .png., .webp y de 200 kb como máximo.</b></div>';
     }
     else {
        //Si la imagen es correcta en tamaño y tipo
        //Se intenta subir al servidor
         $extencion = explode("/", $tipo);
         $fecha = time();
         $aleatorio = rand ( 100 , 9999 );
         $nombreArchivo = $fecha.'-'.$aleatorio.'.'.$extencion[1];
         echo $nombreArchivo;
        if (move_uploaded_file($temp, '../images/'.$tabla.'/'.$nombreArchivo)) {
            //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
            chmod('../images/'.$tabla.'/'.$nombreArchivo, 0777);
            $actualizar = "UPDATE $tabla SET $campo = '$nombreArchivo' WHERE id = '$id_usuario'";

            $ejecutar = sqlsrv_query($con, $actualizar);
            if( $ejecutar ){
               ?>
               <script>showNotification('top', 'center', 'success', 'Imagen subida con exito');</script>
               <?php
            }
            ?>
            <script>showNotification('top', 'center', 'success', 'Usuario registrado correctamente');</script>
            <?php
				echo "<script>window.open('listaUsuarios.php', '_self')</script>";
        }
        else {
           //Si no se ha podido subir la imagen, mostramos un mensaje de error
           echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
        }
      }
   }
}
?>
