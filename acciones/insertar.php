<?php 
use \setasign\Fpdi\Fpdi;

require '../fpdf/fpdf.php';
require '../fpdi/src/autoload.php';
include '../config/bd.php';
require_once "../vendor/autoload.php";
#capturar los datos
    //$nombre=$_POST['nombreArchivo'];
    $archivo=$_FILES['archivo'];
    //var_dump($archivo);
#categoria y tipo
$tipo=$archivo['type'];
$categoria=explode('.',$archivo['name'])[1];
$nombre=explode('.',$archivo['name'])[0];
$target_dir = "C:\\AppServ\\www\\unir_pdf\\unir_pdf\\crud-de-archivos-php-main\\crud-de-archivos-BLOB-main\\archivo\\archivospdf\\";
$target_file = $target_dir . basename($archivo["name"]);
//printf($archivo["tmp_name"]." ");
if (move_uploaded_file($archivo["tmp_name"], $target_file)) {
#fecha
$fecha=date('Y-m-d H:i:s');

/*$tmp_name=$archivo['tmp_name'];
$contenido_archivo=file_get_contents($tmp_name);
$archivoBLOB=addslashes($contenido_archivo);

$conexion=conexion();
$query=insertar($conexion,$nombre,$categoria,$fecha,$tipo,$archivoBLOB);

if($query){
    header('location:../index.php?insertar=success');
}else{
    header('location:../index.php?insertar=error');
}*/
$parseador = new \Smalot\PdfParser\Parser();
$documento = $parseador->parseFile($target_file);

$paginas = $documento->getPages();
foreach ($paginas as $indice => $pagina) {
    //printf("<h1>Página #%02d</h1>", $indice + 1);
    $texto = $pagina->getText();
    $conexion=conexion();
    $query=insertar($conexion, $indice + 1,$nombre,$categoria,$fecha,$tipo,$texto);
}
if($query){
    header('location:../index.php?insertar=success');
}else{
    header('location:../index.php?insertar=error');
}

}else{
    //echo "Error al subir";
    header('location:../index.php?insertar=error');
}
?>