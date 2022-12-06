<?php
#capturar los datos
    $id=$_POST['id'];
    $nombre=$_POST['nombreArchivo'];
    $archivo=$_FILES['archivo'];
    include '../config/bd.php';
    $conexion=conexion();
    $datos=datos($conexion,$id);
    $nombreA=$datos['nombre'];

    if(($archivo['size']==0 && $nombre=='') || ($archivo['size']==0 && $nombre==$nombreA) ){ #no modifico el archivo
        header("location:../editar.php?id=$id");
    }

    if(($archivo['size']==0 && $nombre!='') || ($archivo['size']==0 && $nombre!=$nombreA)){
        #solo el nombre
        $query=editarNombre($conexion,$id,$nombre);
        header("location:../editar.php?id=$id&&editar=success");
    }

    #categoria y tipo
    $tipo=$archivo['type'];
    $categoria=explode('.',$archivo['name'])[1];

    #fecha
    $fecha=date('Y-m-d H:i:s');

    $tmp_name=$archivo['tmp_name'];
    $contenido_archivo=file_get_contents($tmp_name);
    $archivoBLOB=addslashes($contenido_archivo);

    if(($archivo['size']>0 && $nombre=='') || ($archivo['size']>0 && $nombre==$nombreA)){
        #modificar solo archivo
        $query=editarArchivo($conexion,$id,$categoria,$tipo,$fecha,$archivoBLOB);
        header("location:../editar.php?id=$id&&editar=success");

    }
    if(($archivo['size']>0 && $nombre!='') || ($archivo['size']>0 && $nombre!=$nombreA)){
        #modificar todo
        $query=editar($conexion,$id,$nombre,$categoria,$tipo,$fecha,$archivoBLOB);
        header("location:../editar.php?id=$id&&editar=success");
    }




