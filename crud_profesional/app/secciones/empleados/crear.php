<?php
include("../../db.php");

/**@ sentencia de consultar  */ 
if ($_POST) {


  $primernombre = (isset($_POST['primernombre']) ?$_POST['primernombre'] :"");
  $segundonombre = (isset($_POST['segundonombre']) ?$_POST['segundonombre'] :"");
  $primerapellido = (isset($_POST['primerapellido']) ?$_POST['primerapellido'] :"");
  $segundoapellido = (isset($_POST['segundoapellido']) ?$_POST['segundoapellido'] :"");


  $foto = (isset($_FILES['foto']['name']) ?$_FILES['foto']['name'] :"");
  $cv = (isset($_FILES['cv']['name']) ?$_FILES['cv']['name'] :"");


  $idpuesto = (isset($_POST['idpuesto']) ?$_POST['idpuesto'] :"");
  $fechadeingreso = (isset($_POST['fechadeingreso']) ?$_POST['fechadeingreso'] :"");


  $sentencia = $conexion->prepare("INSERT INTO `tbl_empleados` 
  (`id`, `primernombre`, `segundonombre`, `primerapellido`, `segundoapellido`, `foto`, `cv`, `idpuestp`, `fechadeingreso`)
   VALUES (NULL, :primernombre, :segundonombre, :primerapellido, :segundoapellido, :foto, :cv, :idpuesto, :fechadeingreso);");





$sentencia->bindParam(":primernombre", $primernombre);
$sentencia->bindParam(":segundonombre", $segundonombre);
$sentencia->bindParam(":primerapellido", $primerapellido);
$sentencia->bindParam(":segundoapellido", $segundoapellido);    




  /*******nombre de la foto para que no se sobrecrivan  ************ */
  $fecha_ = new DateTime();
  //creamos el nombre del archivo
  $nombreArchivo_foto = ($foto != '')?$fecha_->getTimestamp()."_".$_FILES['foto']['name']:"";
  //-> ibucacion del archivo temporal 
  $tmp_foto = $_FILES['foto']['tmp_name'];
  if ($tmp_foto != '') {
    move_uploaded_file($tmp_foto,"./".$nombreArchivo_foto);
  }


$sentencia->bindParam(":foto", $nombreArchivo_foto);




  /*******nombre de la pdf para que no se sobrecrivan  ************ */
  $nombreArchivo_cv = ($cv != '')?$fecha_->getTimestamp()."_".$_FILES['cv']['name']:"";
  //-> ibucacion del archivo temporal 
  $tmp_cv = $_FILES['cv']['tmp_name'];
  if ($tmp_cv != '') {
    move_uploaded_file($tmp_cv,"./".$nombreArchivo_cv);
  }

$sentencia->bindParam(":cv", $nombreArchivo_cv);



$sentencia->bindParam(":idpuesto", $idpuesto);
$sentencia->bindParam(":fechadeingreso", $fechadeingreso);
$sentencia->execute();

$mensaje="Registro agregado";
header("Location:index.php?mensaje=". $mensaje);
}


/*************************************************************** */
$sentencia = $conexion->prepare('SELECT * FROM `tbl_puestos`');
$sentencia->execute();
$lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);



?>







<?php
     include("../../templates/header.php");
?> 

<br />
Crear emepleados

<div class="card">
    <div class="card-header">
        Datos de empleado 
    </div>
    <div class="card-body">

    <form method="post" action="" enctype="multipart/form-data">
        
      <div class="mb-3">
        <label for="primernombre" class="form-label">Primero Nombre</label>
        <input type="text"
          class="form-control" 
          name="primernombre" 
          id="primernombre"
          aria-describedby="helpId"
          placeholder="Primer nombre">
      </div>  

      <div class="mb-3">
        <label for="segundonombre" class="form-label">Segundo Nombre</label>
        <input type="text"
          class="form-control" 
          name="segundonombre" 
          id="segundonombre"
          aria-describedby="helpId"
          placeholder="Segundo Nombre">
      </div>  

      <div class="mb-3">
        <label for="primerapellido" class="form-label">Primer Apllido</label>
        <input type="text"
          class="form-control" 
          name="primerapellido" 
          id="primerapellido"
          aria-describedby="helpId"
          placeholder="Primer Apelldo">
      </div>  

      <div class="mb-3">
        <label for="segundoapellido" class="form-label">Primer Segundo</label>
        <input type="text"
          class="form-control" 
          name="segundoapellido" 
          id="segundoapellido"
          aria-describedby="helpId"
          placeholder="Segundo Apelldo">
      </div>  

      <div class="mb-3">
        <label for="foto" class="form-label">Foto:</label>
        <input type="file"
          class="form-control" 
          name="foto" 
          id="foto"
          aria-describedby="helpId"
          placeholder="foto">
      </div>  

      
      <div class="mb-3">
        <label for="cv" class="form-label">CV(PDF):</label>
        <input type="file"
          class="form-control" 
          name="cv" 
          id="cv"
          aria-describedby="helpId"
          placeholder="cv">
      </div>  


<div class="mb-3">
    <label for="idpuesto" class="form-label">Puesto:</label>



    <select class="form-select form-select-lg" name="idpuesto" id="idpuesto">
    <?php  foreach ($lista_tbl_puestos as $registro){  ?>
         <option value=" <?php echo $registro['id']?>">
            <?php echo $registro['nombredelpuesto']?>
        </option> 
        <?php               }?>
        
      </select>
</div>

<div class="mb-3">
  <label for="fechadeingreso" class="form-label">Fecha de ingreso:</label>
  <input type="date" class="form-control" name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="fecha de ingrreso a la empresa">
</div>      

<button type="submit" class="btn btn-success">Agregar registro</button>  
<a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>     



    </form>


    </div>

    <div class="card-footer text-muted"></div>
</div>

<?php
     include("../../templates/footer.php");
?>