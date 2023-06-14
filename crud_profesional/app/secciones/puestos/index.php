<?php
include("../../db.php");


/**@ sentencia de eliminar  */
if (isset($_GET['txtID'])) {
     
     
     # Obetenemos el valor a eliminar
$txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

$sentencia = $conexion->prepare('
    SELECT COUNT(*) AS ocupado
    FROM tbl_empleados
    INNER JOIN tbl_puestos ON tbl_puestos.id = tbl_empleados.idpuestp
    WHERE tbl_puestos.id = :id
');

$sentencia->bindParam(":id", $txtID);
$sentencia->execute();

$resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

$ocupado = $resultado['ocupado'];

if ($ocupado > 0) {
 #   echo "La tabla está ocupada por empleados.";
    $mensaje = "Error: La tabla está ocupada por empleados";
} else {
   
#echo "La tabla está vacía o no hay empleados asignados para el ID proporcionado."; 
//.. preparar la insercion
$sentencia = $conexion->prepare("DELETE FROM tbl_puestos WHERE id=:id");                    
$sentencia->bindParam(":id", $txtID);
$sentencia->execute();
$mensaje="Registro eliminado";
header("Location:index.php?mensaje=". $mensaje);

}

}


/************************/

/**@ sentencia de consultar  */
$sentencia = $conexion->prepare('SELECT * FROM `tbl_puestos`');
$sentencia->execute();
$lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>






<?php include("../../templates/header.php");?>




<br />

<h4> Puestos</h4>

<div class="card">
     <div class="card-header">
          <a name="" id=""
           class="btn btn-primary"
            href="crear.php"
             role="button">Agregar Puestos</a>
     </div>


     <div class="card-body">

     <?php  if(isset($mensaje)) { ?>        
    <div class="alert alert-danger" role="alert">
        <strong><?php echo $mensaje; ?></strong>
    </div>
    <?php  } ?>

          <div class="table-responsive-sm">
               <table class="table" id="tabla_id">
                    <thead>
                         <tr>
                              <th scope="col">ID</th>
                              <th scope="col">Nombre del puesto </th>
                              <th scope="col">Acciones </th>
                         </tr>
                    </thead>
                    <tbody>

                    <?php  foreach ($lista_tbl_puestos as $registro){  ?>
                    

                         <tr class="">
                              <td scope="row"><?php echo $registro['id']; ?></td>
                              <td><?php echo $registro['nombredelpuesto']; ?></td>
                              <td>
                              <a class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id']; ?>" role="button">Editar</a>
                                   |
                              <a class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id'];?>);" role="button">Eliminar</a>
                              </td>
                         </tr>

                         <?php               }?>
 
                    </tbody>
               </table>
          </div>
     </div>






<?php
include("../../templates/footer.php");
?>