<?php
include '../config/bd.php';
$pages = $_POST['idpage'];
$usuario = $_POST['usuario'];

$paginas = explode(',', $pages);
$counter = count($paginas);

for($i = 0; $i < $counter; $i++){
    $conexion=conexion();
    $query=hoja_x_usuario($conexion, $paginas[$i], $usuario);
}
//var_dump(json_encode(array('success' => 1)));
if($query){
    echo json_encode(array('success' => 1));
}else{
    echo json_encode(array('success' => 0));
}
?>