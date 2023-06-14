<?php
include("../../db.php");



if ($_POST) {
    
    //.. recoletanto los datos y validando
    $usuario = (isset($_POST['usuario']) ?$_POST['usuario'] :"");
    $password = (isset($_POST['password']) ?$_POST['password'] :"");
    $correo = (isset($_POST['correo']) ?$_POST['correo'] :"");
    
    //.. preparar la insercion
    $sentencia = $conexion->prepare('INSERT INTO tbl_usuarios (id, usuario,password,correo)
                                        VALUES(null, :usuario, :password, :correo)');
    // ... Asigando los valores
    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":password", $password);
    $sentencia->bindParam(":correo", $correo);

    $sentencia->execute();
    
    $mensaje="Registro agregado";
    header("Location:index.php?mensaje=". $mensaje);
}

?>



<?php
     include("../../templates/header.php");
?> 


<br />

<div class="card">
    <div class="card-header">
        Crear usuarios
    </div>
    <div class="card-body">

        <form method="post" action="" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre del usuario</label>
                <input type="text" class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Nombre del usuarios">
            </div>

            
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" 
                aria-describedby="helpId" placeholder="Contraseña del usuarios">
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">correo</label>
                <input type="correo" class="form-control" name="correo" id="correo" 
                aria-describedby="helpId" placeholder="Escriba su correo">
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