
<?php
    

include("../../db.php");

/**@ sentencia de eliminar  */
if (isset($_GET['txtID'])) {

     $txtID = (isset($_GET['txtID']))?$_GET['txtID']:"";
//.. preparar la insercion
$sentencia = $conexion->prepare("SELECT * FROM tbl_puestos WHERE id=:id");                    
// ... Asigando los valores
$sentencia->bindParam(":id", $txtID);
$sentencia->execute();

$registro = $sentencia->fetch(PDO::FETCH_LAZY);
$nombredelpuesto = $registro['nombredelpuesto'];
}



if ($_POST) {
    
     
     $txtID = (isset($_POST['textID']))?$_POST['textID']:"";
     $nombredelpuesto = (isset($_POST['nombredelpuesto']) ?$_POST['nombredelpuesto'] :"");
     
     //.. preparar la insercion
     $sentencia = $conexion->prepare('UPDATE tbl_puestos
      SET nombredelpuesto =:nombredelpuesto WHERE id=:id');
     // ... Asigando los valores
     $sentencia->bindParam(":nombredelpuesto", $nombredelpuesto);
     $sentencia->bindParam(":id", $txtID);

     $sentencia->execute();
     
     
$mensaje="Registro Actualizado";
header("Location:index.php?mensaje=". $mensaje);
   
 }
 


?>






<?php include("../../templates/header.php"); ?> 
<br />
Editar puestos
<div class="card">
    <div class="card-header">
        Puestos
    </div>
    <div class="card-body">

        <form method="post" action="" enctype="multipart/form-data">

<div class="mb-3">
  <label for="textID"class="form-label">ID:</label>
  <input type="text"
  value="<?php echo $txtID; ?>"
    class="form-control"
     readonly name="textID" 
     id="textID"
     aria-describedby="helpId"
     placeholder="ID">
     </div>


            <div class="mb-3">
                <label for="nombredelpuesto" 
                class="form-label">Nombre del puesto</label>
                <input type="text"
                value="<?php  echo $nombredelpuesto;  ?>"
                 class="form-control" 
                 name="nombredelpuesto"
                  id="nombredelpuesto" 
                  aria-describedby="helpId" 
                  placeholder="Nombre del puesto">
            </div>

            <button type="submit" class="btn btn-success">Actializar</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>   
        
        </from>

    </div>
    <div class="card-footer text-muted">
    </div>
</div>





<?php
     include("../../templates/footer.php");
?>