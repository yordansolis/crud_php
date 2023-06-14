<?php
include("../../db.php");

if ($_POST) {
    
    //.. recoletanto los datos y validando
    $nombredelpuesto = (isset($_POST['nombredelpuesto']) ?$_POST['nombredelpuesto'] :"");
    
    //.. preparar la insercion
    $sentencia = $conexion->prepare('INSERT INTO tbl_puestos(id, nombredelpuesto)
                                        VALUES(null, :nombredelpuesto)');
    // ... Asigando los valores
    $sentencia->bindParam(":nombredelpuesto", $nombredelpuesto);
    $sentencia->execute();

    $mensaje="Registro agregado";
    header("Location:index.php?mensaje=". $mensaje);
}

?>





<?php
include("../../templates/header.php");
?>

<br />
Crear puestos
<div class="card">
    <div class="card-header">
        Puestos
    </div>
    <div class="card-body">

        <form method="post" action="" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="nombredelpuesto" class="form-label">Nombre del puesto</label>
                <input type="text" class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId" placeholder="Nombre del puesto">
            </div>

            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>   
        
        </from>

    </div>
    <div class="card-footer text-muted">
    </div>
</div>


<?php
include("../../templates/footer.php");
?>