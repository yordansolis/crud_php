
<?php
    

include("../../db.php");



/**@ sentencia de eliminar  */
if (isset($_GET['txtID'])) {

    $txtID = (isset($_GET['txtID']))?$_GET['txtID']:"";
//.. preparar la insercion
$sentencia = $conexion->prepare("SELECT * FROM tbl_usuarios WHERE id=:id");                    
// ... Asigando los valores
$sentencia->bindParam(":id", $txtID);
$sentencia->execute();

$registro = $sentencia->fetch(PDO::FETCH_LAZY);
$usuario = $registro['usuario'];
$password = $registro['password'];
$correo = $registro['correo'];

}


/************************* ACTUALIZAR *********************************** */

if ($_POST) {
    
     //.. recoletanto los datos y validando
     
     $txtID = (isset($_POST['textID']))?$_POST['textID']:"";
 

     $usuario = (isset($_POST['usuario']) ?$_POST['usuario'] :"");
     $password = (isset($_POST['password']) ?$_POST['password'] :"");
     $correo = (isset($_POST['correo']) ?$_POST['correo'] :"");
     
     //.. preparar la update

     
    
    $sentencia = $conexion->prepare('UPDATE tbl_usuarios
                                        SET usuario =:usuario, 
                                        password =:password,
                                        correo =:correo
                                        WHERE id=:id'
                                        );
                                        
    // ... Asigando los valores
     $sentencia->bindParam(":usuario", $usuario);
     $sentencia->bindParam(":password", $password);
     $sentencia->bindParam(":correo", $correo);
     $sentencia->bindParam(":id", $txtID);

     $sentencia->execute();

     $mensaje="Registro actualizado";
header("Location:index.php?mensaje=". $mensaje);
 }


 


?>




<?php
     include("../../templates/header.php");
?> 


Editar  Usuario

<div class="card">
    <div class="card-header">
        Crear usuarios
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
                <label for="usuario" class="form-label">Nombre del usuario</label>
                <input type="text" 
                value="<?php echo $usuario; ?>"
                class="form-control" 
                name="usuario" 
                id="usuario" 
                aria-describedby="helpId" 
                placeholder="Nombre del usuarios">
            </div>

            
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password"
                value="<?php echo $password; ?>"
                class="form-control"
                name="password"
                id="password" 
                aria-describedby="helpId" placeholder="Contraseña del usuarios">
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">correo</label>
                <input type="correo" 
                value="<?php echo $correo; ?>"
                class="form-control
                " name="correo"
                 id="correo" 
                aria-describedby="helpId" placeholder="Escriba su correo">
            </div>


            <button type="submit" class="btn btn-success">Actualizar</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>   
        
        </from>

    </div>
    <div class="card-footer text-muted">
    </div>
</div>





<?php
     include("../../templates/footer.php");
?>