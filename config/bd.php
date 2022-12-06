<?php 
function conexion(){
    $con=mysqli_connect('localhost','root','Root123456','archivo');
    return $con;
}

function listar($conexion){
    $sql="SELECT a.*, IFNULL((SELECT b.usuario FROM archivo_enabled AS b WHERE b.idpage = a.idpage), 'Sin Asignacion') AS usuario FROM archivo AS a";
    $query=mysqli_query($conexion,$sql);
    return $query;
}
function insertar($conexion, $idpage,$nombre,$categoria,$fecha,$tipo,$archivoBLOB){
    $sql="INSERT INTO archivo(idpage, categoria, nombre, fecha, archivo, tipo) VALUES('$idpage','$categoria','$nombre','$fecha','$archivoBLOB', '$tipo')";
    $query=mysqli_query($conexion,$sql);
    return $query;
}

function hoja_x_usuario($conexion, $idpage, $usuario){
    $sql = "INSERT INTO archivo_enabled(idpage, usuario) VALUES ('$idpage','$usuario')";
    $query = mysqli_query($conexion, $sql);
    return $query;
}

function eliminar($conexion,$id){
    $sql="DELETE from archivo WHERE id=$id";
    $query=mysqli_query($conexion,$sql);
    return $query;
}
function datos($conexion,$id){
    $sql="SELECT * FROM archivo WHERE id=$id";
    $query=mysqli_query($conexion,$sql);
    $datos=mysqli_fetch_assoc($query);
    return $datos;
}
function editarNombre($conexion,$id,$nombre){
    $sql="UPDATE archivo SET nombre='$nombre' WHERE id=$id";
    $query=mysqli_query($conexion,$sql);
    return $query;
}
function editarArchivo($conexion,$id,$categoria,$tipo,$fecha,$archivoBLOB){
    $sql="UPDATE archivo SET categoria='$categoria',tipo='$tipo',fecha='$fecha',archivo='$archivoBLOB' WHERE id=$id";
    $query=mysqli_query($conexion,$sql);
    return $query;
}
function editar($conexion,$id,$nombre,$categoria,$tipo,$fecha,$archivoBLOB){
    $sql="UPDATE archivo SET nombre='$nombre', categoria='$categoria',tipo='$tipo',fecha='$fecha',archivo='$archivoBLOB' WHERE id=$id";
    $query=mysqli_query($conexion,$sql);
    return $query;
}

?>