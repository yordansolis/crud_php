<?php
session_start();


if ($_POST) {
        include("db.php");
 


$sentencia = $conexion->prepare('SELECT *,COUNT(*) AS n_usuario
  FROM `tbl_usuarios`
  WHERE usuario=:usuario AND password=:password');


$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

$sentencia->bindParam(":usuario", $usuario);
$sentencia->bindParam(":password", $contrasena);





$sentencia->execute();
$registro = $sentencia->fetch(PDO::FETCH_LAZY);

if ($registro['n_usuario'] > 0 ) {

    $_SESSION['usuario'] = $registro["usuario"];
    $_SESSION['logueado'] = true;
    header("location:index.php");
}else {
    $mensaje = "Error: el usuario o la contraseña es incorrecto";
}





}



?>

<!doctype html>
<html lang="es">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <header>
    <!-- place navbar here -->
  </header>
 
  <main class="container"> 
  <div class="row">
      <div class="col-md-4">
      </div>

      <div class="col-md-4">
        <br /><br />
        <div class="card">
            <div class="card-header">
                Login
            </div>
            <div class="card-body">
                
            
    <?php  if(isset($mensaje)) { ?>        
    <div class="alert alert-danger" role="alert">
        <strong><?php echo $mensaje; ?></strong>
    </div>
    <?php  } ?>



          
            <form action="" method="post">

            <div class="mb-3">
              <label for="usuario" class="form-label">Usuario:</label>
              <input type="text"
                class="form-control"
                 name="usuario" id="usuario" 
                 aria-describedby="helpId" placeholder="Escriba su usuario">
            </div>

            <div class="mb-3">
              <label for="contraseña" class="form-label">Contraseña:</label>
              <input type="password"
                class="form-control"
                 name="contrasena" id="contraseña" 
                 aria-describedby="helpId" placeholder="Escriba su contraseña">
            </div>
            

            <button type="submit"  name="" id="" class="btn btn-primary" href="#" role="button">Entrar al sistema</button>


            </form>



            </div>
            <div class="card-footer text-muted">
           
            </div>
        </div>
    </div>
    
    </div>
  </main>
  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>