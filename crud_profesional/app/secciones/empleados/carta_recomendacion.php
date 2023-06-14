<?php
include("../../db.php");

if (isset($_GET['txtID'])) {

    /*********** Obetenemos los datos con GET peticione Url para contrarlos  **************************************** */
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
    $sentencia = $conexion->prepare("SELECT * FROM tbl_empleados WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);


    $primernombre = $registro['primernombre'];
    $segundonombre = $registro['segundonombre'];
    $primerapellido = $registro['primerapellido'];
    $segundoapellido = $registro['segundoapellido'];
        /** Unimos los datos */
    $nombreCompleto= $primernombre. " " . $segundonombre ." ".$primerapellido." ".$segundoapellido ;

    $fechadeingreso = $registro['fechadeingreso'];
    $fechaInicio = new DateTime($fechadeingreso);
    $fechaFin = new DateTime(date('Y-m-d'));
    $diFerencia =date_diff($fechaInicio, $fechaFin);





    
    #-----------------------------------------------------
    $sentencia = $conexion->prepare('SELECT *,
                                    (SELECT nombredelpuesto 
                                    FROM tbl_puestos 
                                     WHERE tbl_puestos.id = tbl_empleados.idpuestp limit 1) as 
                                     puesto FROM tbl_empleados WHERE id=:id ');  
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
    #-----------------------------------------------------

    $puesto = $registros["puesto"];











}


ob_start();
?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de recomendación</title>
</head>
<body>
    <h1>Carta de recondación laboral</h1>

    <br /><br />
    Colombia Choco, Quibdó <strong> <?php echo date('d  M Y') ?></strong>

    <br /><br />
    A quien pueda interesar: 

    <br /><br />
    Reciba un cordial y respetuoso saludo.

    <br /><br />
    A através de este linea deseo hacerde su conocimiento  que Sr(a) <strong><?php echo $nombreCompleto ?></strong>
    quien laboro durante  <strong> <?php echo $diFerencia->y; ?> año(s) </strong>
    le considero una gran persona digna de confianza y con la aptitud y capacidad para afrontar cualquier responsabilidad que se deje a su cargo.
    Asimismo, puedo asegurar que es una persona con una ética intachable.
    <br /><br />
    <br /><br />
    Durante estos años se ha desempleñado como <strong><?php echo $puesto; ?> </strong>
    <br><br><br>
    Atentamente,
    <br><br><br><br>

    __________________________________ <br />
    <strong> Ing, José Matenez</strong>
    
</body>
</html>



<?php
$HTML=ob_get_clean();

    
    /************ Pdf **************** */

    require_once("../../libs/autoload.inc.php");
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();

    $opciones= $dompdf->getOptions();
    $opciones->set(array("isRemoteEnabled" => true));

    $dompdf->setOptions($opciones);

    $dompdf->loadHTML($HTML);

    $dompdf->setPaper('letter');
    $dompdf->render();
    $dompdf->stream("archivo.pdf",  array("Attachment"=>false));





?>