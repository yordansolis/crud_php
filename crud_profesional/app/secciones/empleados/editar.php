<?php
include("../../db.php");



if (isset($_GET['txtID'])) {

     /*********** Obetenemos los datos con GET peticione Url para contrarlos  **************************************** */
     $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
     //.. preparar la insercion
     $sentencia = $conexion->prepare("SELECT * FROM tbl_empleados WHERE id=:id");
     // ... Asigando los valores
     $sentencia->bindParam(":id", $txtID);
     $sentencia->execute();

     $registro = $sentencia->fetch(PDO::FETCH_LAZY);

     $primernombre = $registro['primernombre'];
     $segundonombre = $registro['segundonombre'];
     $primerapellido = $registro['primerapellido'];
     $segundoapellido = $registro['segundoapellido'];

     $foto = $registro['foto'];
     $cv = $registro['cv'];
     $idpuesto = $registro['idpuestp'];
     $fechadeingreso = $registro['fechadeingreso'];


     /**@ sentencia de consultar de puestps  */
     $sentencia = $conexion->prepare('SELECT * FROM `tbl_puestos`');
     $sentencia->execute();
     $lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
}





/********** ACTUALIZANDO DATOS **************** */

if ($_POST) {

     $txtID = (isset($_POST['textID'])) ? $_POST['textID'] : "";
     $primernombre = (isset($_POST['primernombre']) ? $_POST['primernombre'] : "");
     $segundonombre = (isset($_POST['segundonombre']) ? $_POST['segundonombre'] : "");
     $primerapellido = (isset($_POST['primerapellido']) ? $_POST['primerapellido'] : "");
     $segundoapellido = (isset($_POST['segundoapellido']) ? $_POST['segundoapellido'] : "");

     $idpuestp = (isset($_POST['idpuesto']) ? $_POST['idpuesto'] : "");
     $fechadeingreso = (isset($_POST['fechadeingreso']) ? $_POST['fechadeingreso'] : "");

     $sentencia = $conexion->prepare("UPDATE  tbl_empleados 
     SET  primernombre=:primernombre,
          segundonombre=:segundonombre,
          primerapellido=:primerapellido,
          segundoapellido=:segundoapellido,
          idpuestp=:idpuestp,
          fechadeingreso=:fechadeingreso
     WHERE id=:id
     ");

     $sentencia->bindParam(":primernombre", $primernombre);
     $sentencia->bindParam(":segundonombre", $segundonombre);
     $sentencia->bindParam(":primerapellido", $primerapellido);
     $sentencia->bindParam(":segundoapellido", $segundoapellido);
     $sentencia->bindParam(":idpuestp", $idpuestp);
     $sentencia->bindParam(":fechadeingreso", $fechadeingreso);
     $sentencia->bindParam(":id", $txtID);
     $sentencia->execute();




     /*******SI SE ENVIA LA FOTO -> OBTENEMOS LOS DATOS DE LA FOTO ************ */
     $foto = (isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : "");
     $fecha_ = new DateTime();
     $nombreArchivo_foto = ($foto != '') ? $fecha_->getTimestamp() . "_" . $_FILES['foto']['name'] : "";
     $tmp_foto = $_FILES['foto']['tmp_name'];
    
     if ($tmp_foto != '') {
          move_uploaded_file($tmp_foto, "./" . $nombreArchivo_foto); #gurdamos la foto con su nuevo nombre

          #----------------------------------------------------------------------------------------
          //***** hacemos una consulta de la foto vieja -> con el id que esta  #.. print_r($_FILES['foto']); #.. (la foto que esta ahora)     
          $sentencia = $conexion->prepare('SELECT foto FROM `tbl_empleados` WHERE id =:id');
          $sentencia->bindParam(":id", $txtID);
          $sentencia->execute();
          $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY); #Esto trae un arreglo de todos los datos
          #----------------------------------------------------------------------------------------

          if (isset($registro_recuperado['foto']) && $registro_recuperado['foto'] != "") {
               if (file_exists("./" . $registro_recuperado['foto'])) {
                    unlink("./" . $registro_recuperado['foto']);    # borrar
               }
          }
          /**actulizamos el nombre de la foto :) */
          $sentencia = $conexion->prepare("UPDATE  tbl_empleados SET  foto=:foto  WHERE id=:id ");
          $sentencia->bindParam(":foto", $nombreArchivo_foto);
          $sentencia->bindParam(":id", $txtID);
          $sentencia->execute();
     }



     /*********** PDF*********************************************************** */

     $cv = (isset($_FILES['cv']['name']) ? $_FILES['cv']['name'] : "");
     $nombreArchivo_cv = ($cv != '') ? $fecha_->getTimestamp() . "_" . $_FILES['cv']['name'] : "";
     $tmp_cv = $_FILES['cv']['tmp_name'];

     if ($tmp_cv != '') {
          move_uploaded_file($tmp_cv, "./" . $nombreArchivo_cv);
          #----------------------------------------------------------------------------------------
          $sentencia = $conexion->prepare('SELECT cv FROM `tbl_empleados` WHERE id =:id');
          $sentencia->bindParam(":id", $txtID);
          $sentencia->execute();
          $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY); #Esto trae un arreglo de todos los datos

          #----------------------------------------------------------------------------------------

          if (isset($registro_recuperado['cv']) && $registro_recuperado['cv'] != "") {
               if (file_exists("./" . $registro_recuperado['cv'])) {
                    unlink("./" . $registro_recuperado['cv']);
               }
          }
          $sentencia = $conexion->prepare("UPDATE  tbl_empleados SET  cv=:cv  WHERE id=:id ");
          $sentencia->bindParam(":cv", $nombreArchivo_cv);
          $sentencia->bindParam(":id", $txtID);
          $sentencia->execute();
     }





     $mensaje="Registro actualizado";
     header("Location:index.php?mensaje=". $mensaje);
}


?>





<?php include("../../templates/header.php"); ?>
<br />

Listar editar

<div class="card">
     <div class="card-header">
          Datos de empleado
     </div>
     <div class="card-body">

          <form method="post" action="" enctype="multipart/form-data">


               <div class="mb-3">
                    <label for="textID" class="form-label">ID:</label>
                    <input type="text" value="<?php echo $txtID; ?>" class="form-control" readonly name="textID" id="textID" aria-describedby="helpId" placeholder="ID">
               </div>




               <div class="mb-3">
                    <label for="primernombre" class="form-label">Primero Nombre</label>
                    <input type="text" value="<?php echo $primernombre; ?>" class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="Primer nombre">
               </div>

               <div class="mb-3">
                    <label for="segundonombre" class="form-label">Segundo Nombre</label>
                    <input type="text" value="<?php echo $segundonombre; ?>" class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="Segundo Nombre">
               </div>

               <div class="mb-3">
                    <label for="primerapellido" class="form-label">Primer Apllido</label>
                    <input type="text" value="<?php echo $primerapellido; ?>" class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="Primer Apelldo">
               </div>

               <div class="mb-3">
                    <label for="segundoapellido" class="form-label">Primer Segundo</label>
                    <input type="text" value="<?php echo $segundoapellido; ?>" class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="Segundo Apelldo">
               </div>

               <div class="mb-3">
                    <label for="foto" class="form-label">Foto:</label>
                    "<?php echo $foto; ?>"
                    <br />
                    <img width="100" src="<?php echo $foto; ?>" class="rounded" alt="" />
                    <br />
                    <br />
                    <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="foto">
               </div>


               <div class="mb-3">
                    <label for="cv" class="form-label">(PDF):</label>
                    <br />
                    <a href="<?php echo $cv; ?>"><?php echo $cv; ?></a>
                    <input type="file" class="form-control" name="cv" id="cv" aria-describedby="helpId" placeholder="cv">
               </div>


               <div class="mb-3">
                    <label for="idpuesto" class="form-label">Puesto:</label>

                    <select class="form-select form-select-lg" name="idpuesto" id="idpuesto">
                         <?php foreach ($lista_tbl_puestos as $registro) {  ?>


                              <option <?php echo ($idpuesto == $registro['id']) ? "selected" : "";   ?> value=" <?php echo $registro['id'] ?>">
                                   <?php echo $registro['nombredelpuesto'] ?>
                              </option>


                         <?php     } ?>

                    </select>
               </div>

               <div class="mb-3">
                    <label for="fechadeingreso" class="form-label">Fecha de ingreso:</label>
                    <input type="date" class="form-control" value="<?php echo $fechadeingreso; ?>" name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="fecha de ingrreso a la empresa">
               </div>

               <button type="submit" class="btn btn-success">Actualizar registro</button>
               <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>



          </form>


     </div>



     <?php
     include("../../templates/footer.php");
     ?>