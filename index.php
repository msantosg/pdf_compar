<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <form class="m-auto w-50 mt-2 mb-2" method="POST" enctype="multipart/form-data" action="acciones/insertar.php">
            <div class="mb-2">
                <label class="form-label">Selecciona un archivo</label>
                <input class='form-control form-control-sm' type="file" name="archivo">
            </div>
            <button class="btn btn-primary btn-sm">Subir archivo</button>
        </form>
        
        <table class="table table-sm table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>categoria</th>
                    <th>Archivo</th>
                    <th>fecha</th>
                    <th>Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    include 'config/bd.php';
                    $conexion=conexion();
                    $query=listar($conexion);
                    $contador=0;
                    while($datos=mysqli_fetch_assoc($query)){
                        $contador++;
                        $id=$datos['id'];
                        $nombre=$datos['nombre'];
                        $categoria=$datos['categoria'];
                        $fecha=$datos['fecha'];
                        $archivo=$datos['archivo'];
                        $tipo=$datos['tipo'];
                        $usuario=$datos['usuario'];

                    $valor="";
                    if($categoria=='jpg' || $categoria=='png'){
                        $valor="<img width='50' src='data:image/jpg;base64,".base64_encode($archivo)."'>";
                    }

                    if($categoria=='pdf'){
                        $valor="<img  width='50' src='img/pdf.png'>";
                    }

                    if($categoria=='xls' || $categoria=='xlsm' ){
                        $valor="<img  width='50' src='img/exel.png'>";
                    }

                    if($categoria=='doc' || $categoria=='docx'){
                        $valor="<img  width='50' src='img/word.png'>";
                    }
                    if($categoria=='mp4'){
                        $valor="<img  width='50' src='img/desconocido.png'>";
                    }

                    if($categoria=='mp3'){
                        $valor="<img  width='50' src='img/desconocido.png'>";
                    }

                    if($valor==''){
                        $valor="<img  width='50' src='img/desconocido.png'>";
                    }

                    
                ?>
                <tr>
                    <td><?php echo $contador;?></td>
                    <td><?php echo $nombre ;?></td>
                    <td><?php echo $categoria;?></td>
                    <td><?php echo $valor ;?></td>
                    <td><?php echo date("d/m/Y", strtotime($fecha)) ;?></td>
                    <td><?php echo $usuario; ?></td>
                    <td><a class='btn btn-secondary' href="editar.php?id=<?php echo $id?>">Editar</a> <a class='btn btn-danger' href="acciones/eliminar.php?id=<?php echo $id?>">Eliminar</a></td>
                </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>
        <button class="btn btn-success btn-sm btn_modal">Habilitar páginas por usuario</button>
        <div class="modal" tabindex="-1" role="dialog" id="modalPage">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Páginas por usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-2">Páginas</div>
                            <div class="col-sm-7"><input type="text" name="txtidpage" id="txtidpage" 
                            class="form-control form-control-sm txtidpage"/></div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-sm-2">Usuario</div>
                            <div class="col-sm-7"><input type="text" name="txtusuario" id="txtusuario" 
                            class="form-control form-control-sm txtusuario"/></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btnhabilita">Habilitar páginas</button>
                        <button type="button" class="btn btn-secondary btncerrar" >Cerrar</button>
                    </div>
             </div>
        </div>
        
    </div>
    <br/>
    <br/>
    <div class="row"> 
        <div class="col-12">
            <span class="text-danger align-middle" id="Msg"></span>
        </div>
    </div>
</div>
    
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="bootstrap/bootstrap.bundle.min.js"></script>
<script>
    $(function(){
        $('.btn_modal').click(function(){
            $("#modalPage").modal("show");
        });
    });

    $(function(){
        $('.btncerrar').click(function(){
            $("#modalPage").modal("hide");
        });
    });

    $(function(){
        $('.btnhabilita').click(function(){
            var idpages = $('.txtidpage').val();
            var usuario = $('.txtusuario').val();

            $.ajax(
                {
                    url: "acciones/habilitar.php",
                    type: "POST",
                    cache: false,
                    data:{idpage:idpages,usuario:usuario},
                    success:function(response) {
                        
                        var jsonData = JSON.parse(response);
                        console.log(jsonData.success);
                         if (jsonData.success == "1")
                        {        
                            $("#modalPage").modal("hide");
                            $("#Msg").html("<div class='alert alert-success' role='alert'>Páginas habilitadas al usuario: " 
                            + usuario + "</div>");                            
                        }
                        else
                        {
                            $("#modalPage").modal("hide");
                            $("#Msg").html("<div class='alert alert-danger' role='alert'>Error al habilitar las páginas por usuario ingresado, por favor intente de nuevo.</div> ");                            
                        }

                        $('.txtidpage').val("");
                        $('.txtusuario').val("");
                        window.location.reload();
                    }
                }
            );
        });
    });
</script>
</body>
</html>