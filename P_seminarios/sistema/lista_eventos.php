<?php

session_start();
/*
if ($_SESSION['rol'] != 1) {
    # code...

    header("location: ../");
}

*/

 include "../conection.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"?>
	<title>LISTA DE EVENTOS</title>
</head>
<body>
 <?php include "includes/header.php"?>
	<section id="container">
		<h1><i class="fas fa-list-alt"></i> Lista de Eventos</h1>
        <a href="registro_evento.php" class="btn_new">Agregar Nuevo Evento</a>
        

    <form action="buscar_evento.php" method="get" class="form_search">
        <input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
        <input type="submit" value="Buscar" class="btn_search" >
    </form>
<hr>
        <table>
            <tr>
                <th>ID</th>
                <th>Evento</th>
                <th>Precio</th>
                <th>Capacidad</th>
                <th>Fecha Evento</th>
                <th>Foto</th>
                <th>Acciones</th>                    
                
            </tr>

            <?php

            //PAGINADO CCODIGO
           $sql_registre = mysqli_query($conection,"SELECT COUNT(*) AS total_registro FROM evento WHERE status =1");
           $result_registre = mysqli_fetch_array($sql_registre);
           $total_resgistros = $result_registre['total_registro'];
           $por_pagina = 5;

           if (empty($_GET['pagina'])) {
               $pagina =1;
               # code...
           }
           else {
               $pagina = $_GET['pagina'];
           }

           $desde = ($pagina - 1) * $por_pagina;
           $total_paginas = ceil($total_resgistros / $por_pagina);


           $query = mysqli_query($conection,"SELECT * FROM evento  WHERE status = 1                                                                                                      
                                                                    ORDER BY codevento DESC LIMIT $desde, $por_pagina");
           $result = mysqli_num_rows($query);
           mysqli_close($conection);
           if ($result > 0) {
               while ($data = mysqli_fetch_array($query)) {
                if ($data['foto'] !='img_evento.png') {
                    $foto ='img/uploads/'.$data['foto'];
                }else {
                    $foto ='img/'.$data['foto'];
                }
           ?>
            <tr class="row<?php echo $data["codevento"];?>">
                <td><?php echo $data["codevento"];?></td>
                <td><?php echo $data["descripcion"];?></td>
                <td><?php echo $data["precio"];?></td>
                <td><?php echo $data["capMax"];?></td>
                <td><?php echo $data["fecha_evento"];?></td>
                <td class="img_evento"><img src="<?php echo $foto;?>" alt="<?php echo $data["descripcion"];?>"></td>
                
                <td>
                    <a class="link_edit" href="editar_evento.php?id=<?php echo $data["codevento"];?>">Editar</a>
                    
                   <?php if ($_SESSION['rol']==1 || $_SESSION['rol']==2) {
                       # code...
                     ?>
                     |
                    <a class="link_delete del_event" href="#" event="<?php echo $data["codevento"];?>">Eliminar</a>

                    <?php } ?>
                </td>
            </tr>

                <?php
                   # code...
               }
               # code...
           }


            ?>
            <table>
               
            </table>
         
           
        </table>


        <div class="paginador">
                    <ul>
                        <?php
                            if ($pagina != 1) {
                              
                            ?>  
                            <li><a href="?pagina=<?php echo 1;?>">|<</a></li>
                            <li><a href="?pagina=<?php echo $pagina-1;?>"><<</a></li>

                            <?php
                                # code...
                            }
                        
                        
                        ?>
                    

                    <?php 
                    
                    for ($i=1; $i <= $total_paginas; $i++) { 

                        if ($i == $pagina) {
                            
                            echo '<li class="pageSelected">'.$i.'</li>';
                            # code...
                        }
                        else {

                            echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
                        # code...
                        }


                    }
                    if ($pagina!=$total_paginas) {
   
                    
                    ?>
                     
                    <li><a href="?pagina=<?php echo $pagina+1;?>">>></a></li>
                    <li><a href="?pagina=<?php echo $total_paginas;?>">>|</a></li>
                        <?php 
                            }
                        
                        ?>
                    </ul>

                </div>
	</section>
<?php include "includes/footer.php"?>
</body>
</html>